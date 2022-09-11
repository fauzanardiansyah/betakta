<?php

namespace App\Http\Controllers\Backend\Dpn\MasterAnggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB;
use Session;

class MasterAnggotaController extends Controller
{
    public function anggotaBaru()
    {
        return view('backend/dpn/content-pages/master-anggota.anggota-baru');
    }

    public function getDataAnggotaBaru()
    {
        $anggotaBaru = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_detail_kta.jenis_pengajuan',  '!=', 4)
        ->where('t_detail_kta.is_inserted', '=', 4)
	    // ->where('t_app_kta.status_pengajuan', '>=', 3)
        ->whereIn('t_detail_kta.jenis_pengajuan', ['0','1','2','3'])
        ->whereNotIn('t_app_kta.status_pengajuan', ['0'])
        ->select(['t_detail_kta.id as id_detail_kta', 't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 't_detail_kta.waktu_pengajuan', 't_app_kta.status_pengajuan',
                  't_kta.jenis_bu'
                  ]);
        
      

        return Datatables::of($anggotaBaru)
        ->editColumn('jenis_pengajuan', function($jenis_pengajuan){
            if($jenis_pengajuan->jenis_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-plus'></i> buat baru</a>";
            }

            if($jenis_pengajuan->jenis_pengajuan === 1) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-male'></i> daftar ulang</a>";
            }

            if($jenis_pengajuan->jenis_pengajuan === 3) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-level-up'></i> perpanjang</a>";
            }
            if($jenis_pengajuan->jenis_pengajuan === 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-level-up'></i> Pindah Dpp </a>";
            }
            if($jenis_pengajuan->jenis_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-level-up'></i> Naik Kualifikasi</a>";
            }

            if($jenis_pengajuan->jenis_pengajuan === 7) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-level-up'></i> Turun Kualifikasi</a>";
            }
        })

        ->editColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i> Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di kembalikan oleh dpp</a>";
            }
            if ($status_pengajuan->status_pengajuan == 10) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-pdf-o'></i>Menunggu Bukti Bayar Anggota</a>";
            }

            if($status_pengajuan->status_pengajuan === 8) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Bayar DPP </a>";
            }

            if($status_pengajuan->status_pengajuan === 12) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Bayar DPP </a>";
            }
            if($status_pengajuan->status_pengajuan === 9) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Konfirmasi </a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpp</a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-search-plus'></i> Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di kembalikan oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu nomor kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 3) {
                return '<a class="btn btn-xs btn-success">Terverifikasi</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">Di kembalikan</a>';
            }

            elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">Selesai</a>';
            }
        })
        ->addColumn('action', function ($kta) {
            if($kta->status_pengajuan == 7) {
                return '
                <a href="'.route('dpn.master-anggota.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                   ';
            } else {
                return '
                <a href="'.route('dpn.master-anggota.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="reject-dokumen-anggota"  title="Tolak Dokumen"><i class="glyphicon glyphicon-remove"></i></a>
                ';
            }
           
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }

    public function anggotaBerhenti()
    {
        return view('backend/dpn/content-pages/master-anggota.anggota-berhenti');
    }

    public function getDataAnggotaBerhenti()
    {
        $anggotaBaru = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_detail_kta.jenis_pengajuan',  '=', 4)
        ->where('t_app_kta.status_pengajuan', '>=', 3)
        ->select(['t_detail_kta.id as id_detail_kta', 
                  't_registrasi_users.nm_bu',
                   't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                   't_kta.kualifikasi',
                   't_detail_kta.waktu_pengajuan', 
                   't_app_kta.status_pengajuan',
                   't_kta.jenis_bu'
                   ]);
        
    

        return Datatables::of($anggotaBaru)
        ->editColumn('jenis_pengajuan', function($jenis_pengajuan){
            if($jenis_pengajuan->jenis_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'>pemberhentian</a>";
            }

        })
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
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } else if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'>Di periksa oleh dpn</a>";
            }
            elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">Di tolak</a>';
            }

            elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">Selesai</a>';
            }
        })
        ->addColumn('action', function ($kta) {
            return '
            <a href="'.route('dpn.pemberhentian.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
            
            <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="reject-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
            ';
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }


    public function pindah_dpp()
    {

        return view('backend/dpn/content-pages/master-anggota.pindah_dpp');
    }

    public function get_data_anggota_pindah()
    {
        
       $pindah_dpp = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        // ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->where('t_detail_kta.jenis_pengajuan',  '=', 5)
        ->where('t_app_kta.status_pengajuan', '>=', 3)
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan',
                  't_detail_kta.surat_permohonan'
                  ]);
        
        // dd($pindah_dpp->get());
    

       return Datatables::of($pindah_dpp)
        ->editColumn('jenis_pengajuan', function($jenis_pengajuan){
            if($jenis_pengajuan->jenis_pengajuan === 5) {
                return "<a class='btn btn-xs btn-danger'>Pindah DPP</a>";
            }

        })
       
        ->addColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i> Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di kembalikan oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpp</a>";
            }
             if ($status_pengajuan->status_pengajuan == 10) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-pdf-o'></i>Menunggu Bukti Bayar Anggota</a>";
            }

            if($status_pengajuan->status_pengajuan === 8) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Bayar DPP </a>";
            }

            if($status_pengajuan->status_pengajuan === 12) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Bayar DPP </a>";
            }
            if($status_pengajuan->status_pengajuan === 9) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Konfirmasi </a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-search-plus'></i> Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di kembalikan oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu no kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7 or $status_pengajuan->status_pengajuan === 11)  {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
            }
        })
        ->addColumn('action', function ($kta) {
            return '
            <a href="'.route('dpn.pindah.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
            
            <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
            ';
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }

    public function naik_kualifikasi()
    {
        return view('backend/dpn/content-pages/master-anggota.naik_kualifikasi');
    }

    public function get_data_naik_kualifikasi()
    {

       $pindah_dpp = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        // ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->where('t_detail_kta.jenis_pengajuan',  '=',6)
        ->whereIn('t_app_kta.status_pengajuan',[3,4,6,7,8,9,12])
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan',
                  't_detail_kta.surat_permohonan'
                  ]);
        
        // dd($pindah_dpp->get());
    

       return Datatables::of($pindah_dpp)
        ->editColumn('jenis_pengajuan', function($jenis_pengajuan){
            if($jenis_pengajuan->jenis_pengajuan === 5) {
                return "<a class='btn btn-xs btn-danger'>Pindah DPP</a>";
            }
            if($jenis_pengajuan->jenis_pengajuan ===6) {
                return "<a class='btn btn-xs btn-danger'>Naik Kualifikasi</a>";
            }

        })
        ->editColumn('status_pengajuan', function($status_pengajuan){
               if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i> Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di kembalikan oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpp</a>";
            }
             if ($status_pengajuan->status_pengajuan == 10) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-pdf-o'></i>Menunggu Bukti Bayar Anggota</a>";
            }
            
            if($status_pengajuan->status_pengajuan === 8) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Bayar DPP </a>";
            }

            if($status_pengajuan->status_pengajuan === 12) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Bayar DPP </a>";
            }
            if($status_pengajuan->status_pengajuan === 9) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Konfirmasi </a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-search-plus'></i> Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di kembalikan oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu no kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } 
            // elseif ($status_pengajuan->status_pengajuan === 3) {
            //     return '<a class="btn btn-xs btn-success">Terverifikasi</a>';
            // }
             elseif ($status_pengajuan->status_pengajuan === 3) {
                return '<a class="btn btn-xs btn-success">Di periksa oleh dpn</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">Di kembalikan</a>';
            }

            elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">Selesai</a>';
            }
        })
        ->addColumn('action', function ($kta) {
            if($kta->status_pengajuan===7)
            {
                $row = '<a href="'.route('dpn.naik_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>';
            }
            else
            {
                $row ='
                <a href="'.route('dpn.naik_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
                ';    
            }
            return $row;
            
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    } 


    public function turun_kualifikasi()
    {
        return view('backend/dpn/content-pages/master-anggota.turun_kualifikasi');
    }

    public function get_data_turun_kualifikasi()
    {

       $pindah_dpp = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_detail_kta.jenis_pengajuan',  '=',7)
        ->whereIn('t_app_kta.status_pengajuan',[3,4,6,7,8,9])
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan',
                  't_detail_kta.surat_permohonan'
                  ]);
        
    

       return Datatables::of($pindah_dpp)
        ->editColumn('jenis_pengajuan', function($jenis_pengajuan){
            if($jenis_pengajuan->jenis_pengajuan === 5) {
                return "<a class='btn btn-xs btn-danger'>Pindah DPP</a>";
            }
            if($jenis_pengajuan->jenis_pengajuan ===6) {
                return "<a class='btn btn-xs btn-danger'>Naik Kualifikasi</a>";
            }
            if($jenis_pengajuan->jenis_pengajuan ===7) {
                return "<a class='btn btn-xs btn-danger'>Turun Kualifikasi</a>";
            }

        })
        ->editColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i> Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di kembalikan oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpp</a>";
            }
             if ($status_pengajuan->status_pengajuan == 10) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-pdf-o'></i>Menunggu Bukti Bayar Anggota</a>";
            }

            if($status_pengajuan->status_pengajuan === 8) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Bayar DPP </a>";
            }
            if($status_pengajuan->status_pengajuan === 9) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Konfirmasi </a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-search-plus'></i> Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di kembalikan oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu no kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 3) {
                return '<a class="btn btn-xs btn-success">Terverifikasi</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">Di kembalikan</a>';
            }

            elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">Selesai</a>';
            }
        })
        ->addColumn('action', function ($kta) {
             if($kta->status_pengajuan===7)
            {
                $row = '<a href="'.route('dpn.turun_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>';
            }
            else
            {
                $row = '
                <a href="'.route('dpn.turun_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
                ';    
            }
            return $row;
            
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }



}
