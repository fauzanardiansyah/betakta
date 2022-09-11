<?php

namespace App\Http\Controllers\Backend\Dpn\Edit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Input;
use App\Kta;
use App\DataAdministrasiBadanUsaha;
use App\DataPenanggungJawabBadanUsaha;
use App\DataLegalitasBadanUsaha;
use App\DataDokumenPendukungBadanUsaha;
use App\RegistrationUsers;
use Ramsey\Uuid\Uuid;
use Validator;
use DB;
use Image;
use Session;

class DataAnggotaController extends Controller
{
  

    public function index_edit_data()
    {
        
        return view('backend/dpn/content-pages/master-anggota.index_edit_data');
    }
    


     public function get_data_anggota_edit()
    {
       $edit_data = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_detail_kta.jenis_pengajuan',  '=', 8)
        ->whereIn('t_app_kta.status_pengajuan',[3,4,6,7,8,9])
        ->select(['t_detail_kta.id as id_detail_kta',
                  't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                  't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 
                  't_detail_kta.waktu_pengajuan', 
                  't_app_kta.status_pengajuan',
                  't_detail_kta.surat_permohonan'
                  ]);
        
    

       return Datatables::of($edit_data)
        ->editColumn('jenis_pengajuan', function($jenis_pengajuan){
            if($jenis_pengajuan->jenis_pengajuan === 8) {
                return "<a class='btn btn-xs btn-danger'>Perubahan Data</a>";
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
                $row = '<a href="'.route('dpn.edit_data.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>';
            }
            else
            {
                $row = '
                <a href="'.route('dpn.edit_data.screening', ['id_detail_kta' => $kta->id_detail_kta]).'" class="btn btn-xs btn-primary"  title="Screening"><i class="glyphicon glyphicon-search"></i></a>
                
                <a href="#" class="btn btn-xs btn-danger" data-detail-kta="'.$kta->id_detail_kta.'" id="pindah-dokumen-anggota"  title="Reject Document"><i class="glyphicon glyphicon-remove"></i></a>
                ';
            }
            return $row;
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan'])
        ->make(true);
    }

}
