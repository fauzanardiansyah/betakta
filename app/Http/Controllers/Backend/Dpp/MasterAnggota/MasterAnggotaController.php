<?php

namespace App\Http\Controllers\Backend\Dpp\MasterAnggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB;
use Session;

class MasterAnggotaController extends Controller
{
    public function anggotaBaru()
    {
        return view('backend/dpp/content-pages/master-anggota.anggota-baru');
    }

    public function getDataAnggotaBaru()
    {
        $anggotaBaru = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->whereIn('t_detail_kta.jenis_pengajuan', ['0','1','2','3'])
        ->where('t_detail_kta.is_inserted', '=', 4)
        ->select(['t_detail_kta.id as id_detail_kta', 't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu','t_kta.id as id_kta',
                   't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 't_detail_kta.waktu_pengajuan', 't_app_kta.status_pengajuan']);
        
    

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
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Role Sharing </a>";
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
            } elseif ($status_pengajuan->status_pengajuan === 2) {
                return '<a class="btn btn-xs btn-warning">Terverifikasi</a>';
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
            return '<a href="'.route('dpp.master-anggota.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
            <a href="'.route('dpp.edit.documents', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-warning" title="Edit Dokumen"><i class="glyphicon glyphicon-pencil"></i></a>
            ';      
            }
          
             else if($kta->status_pengajuan == 3)
            {
                return '
                    <a href="'.route('dpp.master-anggota.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                    <a href="'.route('dpp.edit.documents', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-warning" title="Edit Dokumen"><i class="glyphicon glyphicon-pencil"></i></a>';
            }

            else if($kta->status_pengajuan==0 or $kta->status_pengajuan==2 or $kta->status_pengajuan==1 or $kta->status_pengajuan==6 or $kta->status_pengajuan== 8 or $kta->status_pengajuan ==12 or $kta->status_pengajuan==10)
            {
                return '
                <a href="'.route('dpp.master-anggota.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="reject-dokumen-anggota"  title="Tolak Dokumen"><i class="glyphicon glyphicon-remove"></i></a>
                <a href="'.route('dpp.edit.documents', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-warning" title="Edit Dokumen"><i class="glyphicon glyphicon-pencil"></i></a>
                <a href="javascript:void(0)" onclick="delete_pengajuan(`'.$kta->id_kta.'`)" class="btn btn-xs btn-danger" title="HAPUS PENGAJUAN"><i class="glyphicon glyphicon-minus"></i></a>';
            }
           
           

            
            
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }

    public function anggotaBerhenti()
    {
        return view('backend/dpp/content-pages/master-anggota.anggota-berhenti');
    } 

  

    public function getDataAnggotaBerhenti()
    {
        $anggotaBaru = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->where('t_detail_kta.jenis_pengajuan',  '=', 4)
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan'
                  ]);
        
        
    

        return Datatables::of($anggotaBaru)
        ->editColumn('jenis_pengajuan', function($jenis_pengajuan){
            if($jenis_pengajuan->jenis_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'>pemberhentian</a>";
            }

        })
        ->editColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'>Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'>Di kembalikan oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'>Menunggu invoice dpp</a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'>Di periksa oleh dpn</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } else if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'>Di periksa oleh dpn</a>";
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
                $row = '<a href="'.route('dpp.pemberhentian.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>';
                 return $row;
            }
            else
            {
                $id_kta_  = (empty($kta)) ? "" : $kta->id_kta;
                return '
                <a href="'.route('dpp.pemberhentian.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="reject-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
                <a href="javascript:void(0)" onclick="delete_pengajuan(`'.$id_kta_.'`)" class="btn btn-xs btn-danger" title="HAPUS PENGAJUAN"><i class="glyphicon glyphicon-minus"></i></a>
                ';
            }
            
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }


    public function pindah_dpp()
    {

        return view('backend/dpp/content-pages/master-anggota.pindah_dpp');
    }

    public function get_data_anggota_pindah()
    {

       $pindah_dpp = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->where('t_detail_kta.jenis_pengajuan',  '=', 5)
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan',
                  't_detail_kta.surat_permohonan',
                  't_kta.id as id_kta'
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
            if($status_pengajuan->status_pengajuan === 9 or $status_pengajuan->status_pengajuan === 11) {
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
                if($status_pengajuan->status_pengajuan)
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            }
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

            if($kta->status_pengajuan===7 or $kta->status_pengajuan ===11)
            {
                $row = '<a href="'.route('dpp.pindah.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>';
                 return $row;
            }
            elseif($kta->status_pengajuan== 3 or $kta->status_pengajuan== 6)
            {
                $row = '<a href="'.route('dpp.pindah.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>';
                return $row;
            }
            else
            {
                $id_kta_  = (empty($kta)) ? "" : $kta->id_kta;
                $row = '<a href="'.route('dpp.pindah.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
                <a href="javascript:void(0)" onclick="delete_pengajuan(`'.$id_kta_.'`)" class="btn btn-xs btn-danger" title="HAPUS PENGAJUAN"><i class="glyphicon glyphicon-minus"></i></a>';
                return $row;
            }
            
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }

    public function naik_kualifikasi()
    {
        return view('backend/dpp/content-pages/master-anggota.naik_kualifikasi');
    }

    public function get_data_naik_kualifikasi()
    {

       $pindah_dpp = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->where('t_detail_kta.jenis_pengajuan',  '=',6)
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan',
                  't_detail_kta.surat_permohonan',
                  't_kta.id as id_kta'
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
                return "<a class='btn btn-xs btn-default'><i class='fa fa-search-plus'></i> Menunggu Bukti Role Sharing </a>";
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

            if($kta->status_pengajuan===7 or $kta->status_pengajuan ===11)
            {
                 return '
                <a href="'.route('dpp.naik_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>';
            }
            elseif($kta->status_pengajuan== 3 or $kta->status_pengajuan== 6)
            {
                $row = '<a href="'.route('dpp.pindah.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>';
                return $row;
            }
            else
            {
                $id_kta_  = (empty($kta)) ? "" : $kta->id_kta;
                 return '
                <a href="'.route('dpp.naik_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
                <a href="javascript:void(0)" onclick="delete_pengajuan(`'.$id_kta_.'`)" class="btn btn-xs btn-danger" title="HAPUS PENGAJUAN"><i class="glyphicon glyphicon-minus"></i></a>';
            }
           

        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    } 


    public function turun_kualifikasi()
    {
        return view('backend/dpp/content-pages/master-anggota.turun_kualifikasi');
    }

    public function get_data_turun_kualifikasi()
    {

       $pindah_dpp = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->where('t_detail_kta.jenis_pengajuan',  '=',7)
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan',
                  't_detail_kta.surat_permohonan',
                  't_kta.id as id_kta'
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
            if($kta->status_pengajuan===7 or $kta->status_pengajuan ===11)
            {
                 return '
                 <a href="'.route('dpp.turun_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>';
            }
            elseif($kta->status_pengajuan== 3 or $kta->status_pengajuan== 6)
            {
                $row = '<a href="'.route('dpp.pindah.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>';
                return $row;
            }
            else
            {
                $id_kta_  = (empty($kta)) ? "" : $kta->id_kta;
                 return '
                <a href="'.route('dpp.turun_kualifikasi.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
                <a href="javascript:void(0)" onclick="delete_pengajuan(`'.$id_kta_.'`)" class="btn btn-xs btn-danger" title="HAPUS PENGAJUAN"><i class="glyphicon glyphicon-minus"></i></a>';     
            }
           
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }

    public function deletePengajuan(Request $request)
    {
        $id_kta = $request->id_kta;
        $member = \App\Kta::findOrFail($id_kta);
        if($member->delete()) {
            return response()->json('success', 200);
        }
    }

    
}
