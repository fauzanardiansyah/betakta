<?php

namespace App\Http\Controllers\Backend\Dpp\Download;


use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
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
        $memberData =  DB::table('t_kta')
        ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
        ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
        ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
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
                    't_registrasi_users.nm_bu'
                    )
                    
        ->where('t_detail_kta.is_inserted', 4)
        ->whereIn('t_app_kta.status_pengajuan',['7','11'])
        ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->orderBy('t_detail_kta.created_at', 'desc')
        ->get();
        // dd($memberData);
       return view('backend/dpp/content-pages/download-kta.main-download', compact('memberData')); 
       
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
                // $pdf = PDF::loadView($result = ($dataKta->jenis_bu == 'pmdn') ? 'kta-template.lokal' : 'kta-template.afiliasi', compact('dataKta','dpnSignature'))->setPaper('a4', 'landscape');
                // return $pdf->stream('kta-inkindo.pdf');

               return view('kta-template/v3/copy.'.$result = ($dataKta->jenis_bu == 'pmdn') ? 'pmdn-sertificate' : 'pma-sertificate', compact('dataKta','dpnSignature'));
            } elseif($this->segment === 'idcard') {
                // $pdf = PDF::loadView('kta-template.idcard', compact('dataKta','dpnSignature'))->setPaper('a4', 'portrait');
                // return $pdf->stream('idcard-inkindo.pdf');

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
