<?php

namespace app\Traits;

use Yajra\Datatables\Datatables;
use DB;


/**
 * Trait for generate report council
 */
trait ReportTraitDpn
{
   
    /**
     * Trait for generate All members of province which is status_anggota == 0/Active
     */
    public function getMembersOfProvinceActiveTrait($data)
    {
        $results = DB::table('t_kta')
                 ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                 ->join('t_registrasi_users', 't_registrasi_users.id', 't_kta.id_registrasi_users')
                 ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                 ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                 ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                 ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
                 ->join('t_app_kta', 't_app_kta.id_detail_kta', '=', 't_detail_kta.id')
                 ->select(
                     't_registrasi_users.nm_bu',
                     't_kta.kualifikasi',
                     't_kta.no_kta',
                     't_kta.status_kta',
                     't_kta.jenis_bu',
                     't_detail_kta.tgl_terbit',
                     't_administrasi_kta.alamat',
                     't_pj_kta.nm_pjbu',
                     't_pj_kta.no_hp_pjbu',
                     't_registrasi_users.status_bu',
                     't_detail_kta.jenis_pengajuan'
                 )
                 ->whereBetween('t_detail_kta.tgl_terbit', [$data['start_date'], $data['to_date']])
                 ->where('t_kta.status_kta', 0)
                 ->where('t_detail_kta.is_inserted', 4);
                 if($data['provinsi'] != 0) {
                    $results->where('provinsi.id', $data['provinsi']);
                 }  
                 if($data['jenis_pengajuan'] != 'All') {
                    if($data['jenis_pengajuan'] == 'status_pengajuan')
                    {

                        $results->where('t_app_kta.status_pengajuan',3)
                            ->whereBetween('t_detail_kta.waktu_pengajuan', [$data['start_date'], $data['to_date']])
                            ;

                    }
                    else
                    {
                        $results->where('t_detail_kta.jenis_pengajuan', $data['jenis_pengajuan']);    
                    }
                    
                 }  
                if($data['kualifikasi'] != 'All') {
                    $results->where('t_kta.kualifikasi', $data['kualifikasi']);
                 }  
            
                 
                
        return Datatables::of($results)

                 ->editColumn('no_kta', function ($no_kta) {
                     return "<a class='btn btn-xs btn-primary'>".$no_kta->no_kta."</a>";
                 })

                 ->editColumn('status_kta', function ($status_kta) {
                     if ($status_kta->status_kta == 0) {
                         return "<a class='btn btn-xs btn-success'>Aktif</a>";
                     }
                 })

                 ->editColumn('status_bu', function ($status_bu) {
                     return ucfirst($status_bu->status_bu);
                 })

                 ->editColumn('jenis_pengajuan', function ($jenis_pengajuan) {
                     if ($jenis_pengajuan->jenis_pengajuan == 0) {
                         return "<a class='btn btn-xs btn-primary'>Buat Baru</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 1){
                         return "<a class='btn btn-xs btn-success'>Daftar Ulang</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 2){
                         return "<a class='btn btn-xs btn-default'>Perubahan</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 3){
                         return "<a class='btn btn-xs btn-warning'>Perpanjangan</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 4){
                         return "<a class='btn btn-xs btn-danger'>Pemberhentian</a>";
                     }
                 })
        
                 ->rawColumns(['no_kta', 'status_kta','status_bu', 'jenis_pengajuan'])
                 ->make(true);
    }

    /**
     * Trait for generate All members of province which is status_anggota == 2/Not active
     */
    public function getMembersOfProvinceNotActiveTrait($data)
    {
        $results = DB::table('t_kta')
                 ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                 ->join('t_registrasi_users', 't_registrasi_users.id', 't_kta.id_registrasi_users')
                 ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                 ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                 ->select(
                     't_registrasi_users.nm_bu',
                     't_kta.kualifikasi',
                     't_kta.no_kta',
                     't_kta.status_kta',
                     't_kta.jenis_bu',
                     't_detail_kta.tgl_terbit',
                     't_registrasi_users.status_bu',
                     't_detail_kta.jenis_pengajuan'
                 )
                 ->whereBetween('t_detail_kta.tgl_terbit', [$data['start_date'], $data['to_date']])
                 ->where('t_kta.status_kta', 2)
                 ->where('t_detail_kta.is_inserted', 4);
                 if($data['provinsi'] != 0) {
                    $results->where('provinsi.id', $data['provinsi']);
                 } 
                 if($data['jenis_pengajuan'] != 'All') {
                    if($data['jenis_pengajuan'] == 'status_pengajuan')
                    {
                        $results->where('t_app_kta.status_pengajuan',3)
                        ->whereBetween('t_detail_kta.waktu_pengajuan', [$data['start_date'], $data['to_date']]);
                    }
                    else
                    {
                        $results->where('t_detail_kta.jenis_pengajuan', $data['jenis_pengajuan']);    
                    }
                 } 
                
        return Datatables::of($results)

                 ->editColumn('no_kta', function ($no_kta) {
                     return "<a class='btn btn-xs btn-primary'>".$no_kta->no_kta."</a>";
                 })

                 ->editColumn('status_kta', function ($status_kta) {
                     if ($status_kta->status_kta == 2) {
                         return "<a class='btn btn-xs btn-danger'>Tidak Aktif</a>";
                     }
                 })

                 ->editColumn('status_bu', function ($status_bu) {
                     return ucfirst($status_bu->status_bu);
                 })
        
                 ->editColumn('jenis_pengajuan', function ($jenis_pengajuan) {
                     if ($jenis_pengajuan->jenis_pengajuan == 0) {
                         return "<a class='btn btn-xs btn-primary'>Buat Baru</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 1){
                         return "<a class='btn btn-xs btn-success'>Daftar Ulang</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 2){
                         return "<a class='btn btn-xs btn-default'>Perubahan</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 3){
                         return "<a class='btn btn-xs btn-warning'>Perpanjangan</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 4){
                         return "<a class='btn btn-xs btn-danger'>Pemberhentian</a>";
                     }
                 })
        
                 ->rawColumns(['no_kta', 'status_kta','status_bu', 'jenis_pengajuan'])
                 ->make(true);
    }


    /**
     * Trait for generate All members of province which is status_anggota == 1/Pasive
     */
    public function getMembersOfProvincePasiveTrait($data)
    {
        $results = DB::table('t_kta')
                 ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                 ->join('t_registrasi_users', 't_registrasi_users.id', 't_kta.id_registrasi_users')
                 ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                 ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                 ->select(
                     't_registrasi_users.nm_bu',
                     't_kta.kualifikasi',
                     't_kta.no_kta',
                     't_kta.status_kta',
                     't_kta.jenis_bu',
                     't_detail_kta.tgl_terbit',
                     't_registrasi_users.status_bu'
                 )
                 ->whereBetween('t_detail_kta.tgl_terbit', [$data['start_date'], $data['to_date']])
                 ->where('t_kta.status_kta', 1)
                 ->where('t_detail_kta.is_inserted', 4);
                 if($data['provinsi'] != 0) {
                    $results->where('provinsi.id', $data['provinsi']);
                 } 
                 if($data['jenis_pengajuan'] != 'All') {
                    if($data['jenis_pengajuan'] == 'status_pengajuan')
                    {
                        $results->where('t_app_kta.status_pengajuan',3)
                        ->whereBetween('t_detail_kta.waktu_pengajuan', [$data['start_date'], $data['to_date']]);
                    }
                    else
                    {
                        $results->where('t_detail_kta.jenis_pengajuan', $data['jenis_pengajuan']);    
                    }
                 } 
                
        return Datatables::of($results)

                 ->editColumn('no_kta', function ($no_kta) {
                     return "<a class='btn btn-xs btn-primary'>".$no_kta->no_kta."</a>";
                 })

                 ->editColumn('status_kta', function ($status_kta) {
                     if ($status_kta->status_kta == 2) {
                         return "<a class='btn btn-xs btn-danger'>Tidak Aktif</a>";
                     }
                 })

                 ->editColumn('status_bu', function ($status_bu) {
                     return ucfirst($status_bu->status_bu);
                 })
                 ->editColumn('jenis_pengajuan', function ($jenis_pengajuan) {
                     if ($jenis_pengajuan->jenis_pengajuan == 0) {
                         return "<a class='btn btn-xs btn-primary'>Buat Baru</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 1){
                         return "<a class='btn btn-xs btn-success'>Daftar Ulang</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 2){
                         return "<a class='btn btn-xs btn-default'>Perubahan</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 3){
                         return "<a class='btn btn-xs btn-warning'>Perpanjangan</a>";
                     } elseif($jenis_pengajuan->jenis_pengajuan == 4){
                         return "<a class='btn btn-xs btn-danger'>Pemberhentian</a>";
                     }
                 })
        
                 ->rawColumns(['no_kta', 'status_kta','status_bu', 'jenis_pengajuan'])
                 ->make(true);
    }


    /**
    * Trait for generate All payment of role sharing
    */
    public function getPaymentsOfRoleSharingTrait($data)
    {
        $results = DB::table('t_role_share_confirmation')
        ->join('t_role_share_accumulation', 't_role_share_confirmation.id_role_share_accumulation', '=', 't_role_share_accumulation.id')
        ->join('t_invoice_role_share', 't_role_share_confirmation.id_invoice_role_share', '=', 't_invoice_role_share.id')
        ->join('t_detail_kta', 't_invoice_role_share.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
        ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
        ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
        ->select('t_role_share_confirmation.*',
         't_role_share_accumulation.nominal',
         't_registrasi_users.nm_bu', 
         't_invoice_role_share.status_pembayaran', 
         't_detail_kta.id as id_detail_kta', 
         't_app_kta.status_pengajuan', 
         't_registrasi_users.status_bu',
         't_invoice_role_share.no_invoice'
         )
        ->whereBetween('t_role_share_confirmation.created_at', [$data['start_date'], $data['to_date']])
        ->where('t_detail_kta.is_inserted', 4);
        if($data['provinsi'] != 0) {
            $results->where('provinsi.id', $data['provinsi']);
         } 

        return Datatables::of($results)

        ->editColumn('status_pembayaran', function ($status_pembayaran) {
            if ($status_pembayaran->status_pembayaran == 0) {
                return "<a class='btn btn-xs btn-warning'>Pending</a>";
            }

            if ($status_pembayaran->status_pembayaran == 1) {
                return "<a class='btn btn-xs btn-success'>Paid</a>";
            }
        })

        ->editColumn('nominal', function ($nominal) {
            return "IDR.". $nominal->nominal;
        })

        ->rawColumns(['status_pembayaran', 'nominal'])

        ->make(true);
    }

    /**
    * Trait for generate All payment of members afiliasi
    */
    public function getPaymentsOfMembersAffiliationTrait($data)
    {
        $results = DB::table('t_payment_confirmation')
        ->join('t_invoice_kta', 't_payment_confirmation.id_invoice_kta', '=', 't_invoice_kta.id')
        ->join('t_detail_kta', 't_invoice_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
        ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
        ->select('t_payment_confirmation.*',
         't_registrasi_users.nm_bu', 
         't_invoice_kta.status_pembayaran', 
         't_detail_kta.id as id_detail_kta', 
         't_app_kta.status_pengajuan', 
         't_registrasi_users.status_bu')
        ->whereBetween('t_payment_confirmation.created_at', [$data['start_date'], $data['to_date']])
        ->where('t_detail_kta.is_inserted', 4)
        ->where('t_kta.jenis_bu', '=', 'pma');

        return Datatables::of($results)

        ->editColumn('status_pembayaran', function ($status_pembayaran) {
            if ($status_pembayaran->status_pembayaran == 0) {
                return "<a class='btn btn-xs btn-warning'>Pending</a>";
            }

            if ($status_pembayaran->status_pembayaran == 1) {
                return "<a class='btn btn-xs btn-success'>Paid</a>";
            }
        })

        ->editColumn('nominal', function ($nominal) {
            return "IDR.". $nominal->nominal;
        })

        ->rawColumns(['status_pembayaran', 'nominal'])

        ->make(true);
    }
}
