<?php

namespace App\Http\Controllers\Backend\Dpn\Download;


use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Kta;
use App\DetailKta;
use Session;
use DB;
use PDF;

class DownloadKtaController extends Controller
{
    
    /** @var Int $segment for uri segment */
    protected $segment;
    

    /**
     * Get the URI Segment
     */
    public function __construct()
    {
        $this->segment = Request::segment(4);
    }


    /**
     * Download KTA page
     *
     * @return void
     */
    public function index()
    {

       return view('backend/dpn/content-pages/download-kta.main-download'); 
       
    }


    public function getData()
    {
      // dd('tes');
        $memberData =  DB::table('t_kta')
        ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
        ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
        ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
        ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
        ->leftJoin('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
        ->select('t_kta.id as id_kta', 
                    't_kta.no_kta',
                    't_kta.lokasi_pengurusan', 
                    't_kta.status_kta',
                    't_detail_kta.waktu_pengajuan',
                    't_detail_kta.jenis_pengajuan', 
                    't_detail_kta.masa_berlaku', 
                    't_detail_kta.id as id_detail_kta', 
                    't_app_kta.status_pengajuan',
                    't_kta.status_penataran',
                    't_kta.jenis_bu',
                    't_registrasi_users.nm_bu',
                    'provinsi.name as provinsi' 
                    )
                    
        ->where('t_detail_kta.is_inserted', 4)
        ->whereIn('t_app_kta.status_pengajuan',['7','11']);
                    
        
        return Datatables::of($memberData)
        ->editColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'>Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di kembalikan oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'>Menunggu invoice dpp</a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'>Di periksa oleh dpn</a>";
            }
            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di tolak oleh dpn</a>";
            }
        })
        ->editColumn('jenis_pengajuan', function ($jenis_pengajuan) {
            if ($jenis_pengajuan->jenis_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'>buat baru</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 1) {
                return "<a class='btn btn-xs btn-success'>daftar ulang</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 3) {
                return "<a class='btn btn-xs btn-warning'>perpanjang</a>";
            }
            if ($jenis_pengajuan->jenis_pengajuan === 8) {
                return "<a class='btn btn-xs btn-danger'> Perubahan Data </a>";
            }
            if ($jenis_pengajuan->jenis_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'> Naik Kualifikasi</a>";
            }
            if($jenis_pengajuan->jenis_pengajuan === 5) {
                return "<a class='btn btn-xs btn-danger'>Pindah DPP</a>";
            }
            if ($jenis_pengajuan->jenis_pengajuan === 7) {
                return "<a class='btn btn-xs btn-warning'> Turun Kualifikasi</a>";
            }
        })
        ->addColumn('action', function ($kta) {
            return ' <center>
            <a href="'.route('dpn.process-download-kta', ['idKta' => $kta->id_kta]) .'"
                id="download-kta" class="btn btn-sm btn-danger"
                title="Download KTA Certificate"><i class="fa fa-file-pdf-o"></i> Cetak
                KTA
            </a>
            <a href="'.route('dpn.process-download-idcard', ['idKta' => $kta->id_kta]).'"
                id="download-idcard" class="btn btn-sm btn-warning"
                title="Download ID Card"><i class="fa fa-credit-card"></i> Cetak ID Card
            </a>
        </center>';
        })
        ->rawColumns(['action', 'jenis_pengajuan'])
        ->make(true);

    }


    /**
     * KTA download process
     *
     * @param Int $idKta
     * @return void
     */
    public function DownloadProcess($idKta)
    {
      
        $dataKta = DB::table('t_kta')
                     ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                     ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                     ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                     ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                     ->join('t_administrasi_kta', 't_detail_kta.id', '=', 't_administrasi_kta.id_detail_kta')
                     ->join('t_pj_kta', 't_detail_kta.id', '=', 't_pj_kta.id_detail_kta')
                     ->join('t_dokumen_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                     ->select('t_registrasi_users.email_bu', 't_registrasi_users.nm_bu', 't_registrasi_users.npwp_bu',
                              'provinsi.name as province_name', 't_kta.*', 't_detail_kta.*', 't_administrasi_kta.kota',
                              't_administrasi_kta.kecamatan', 't_administrasi_kta.alamat','t_administrasi_kta.no_telp', 
                              't_administrasi_kta.no_fax', 't_administrasi_kta.website', 't_dokumen_kta.file_foto_pjbu',
                              't_pj_kta.nm_pjbu', 't_dp.nm_ketua_provinsi', 't_dp.nm_sekretaris_provinsi', 't_dp.nm_ketum',
                              't_dp.nm_sekjen', 't_registrasi_users.status_bu',
                              't_dp.ttd_ketum', 't_dp.ttd_sekjen',
                              't_dp.ttd_ketua_provinsi', 't_dp.ttd_sekretaris_provinsi',
                              't_dp.ketua_bkka','t_dp.sekretaris_bkka',
                              't_dp.ttd_sekretaris_bkka',
                              't_dp.ttd_ketua_bkka', 
                              't_kta.id_registrasi_users'
                              )
                     ->where('t_kta.id', $idKta)
                     ->orderBy('t_kta.created_at')
                     ->first();
        $dpnSignature = DB::table('t_dp')->whereLevel(1)->first();
        
        if(empty($dataKta)) {
            abort(404);
        }
            if($this->segment === 'kta') {
               return view('kta-template/v3/copy.'.$result = ($dataKta->jenis_bu == 'pmdn') ? 'pmdn-sertificate' : 'pma-sertificate', compact('dataKta','dpnSignature'));
            } elseif($this->segment === 'idcard') {

                return view('kta-template/v3/copy.idCard', compact('dataKta','dpnSignature'));

            }
    }

    /**
     * Download proof of registration process
     *
     * @param Int $idKta
     * @return void
     */
    public function downloadBuktiRegistrasiBaru($idKta)
    {
        $dataKta = DB::table('t_kta')
                    ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                    ->join('t_administrasi_kta', 't_detail_kta.id', '=', 't_administrasi_kta.id_detail_kta')
                    ->join('t_dokumen_kta','t_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                    ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                    ->join('t_pj_kta', 't_detail_kta.id', '=', 't_pj_kta.id_detail_kta')                   
                    ->select(
                        't_kta.no_kta',
                        't_registrasi_users.npwp_bu',
                        't_registrasi_users.nm_bu',
                        't_dokumen_kta.file_foto_pjbu',
                        't_administrasi_kta.alamat',
                        't_detail_kta.waktu_pengajuan',
                        't_pj_kta.nm_pjbu'
                        )
                     ->where('t_kta.id', $idKta)
                     ->where('t_kta.id_registrasi_users', Session::get('id_registrasi_user'))
                     ->first();
      

        if(!empty($dataKta)) {
            $pdf = PDF::loadView('kta-template.bukti-registrasi-baru', compact('dataKta'))->setPaper('a4', 'portrait');
            return $pdf->stream('bukti-registrasi-baru | '.$dataKta->nm_bu.'.pdf');
        } else {
            abort(404);
        }
    }


    

  
}
