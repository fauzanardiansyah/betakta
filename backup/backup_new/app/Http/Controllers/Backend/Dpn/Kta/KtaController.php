<?php

namespace App\Http\Controllers\Backend\Dpn\Kta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Kta;
use App\DetailKta;
use App\HistoryApprovalPengajuan;
use App\RoleShareConfirmation;
use Validator;
use DB;

class KtaController extends Controller
{
    public function afiliasiKta()
    {
        return view('backend/dpn/content-pages/publish/afiliasi.afiliasi-page');
    }

    public function getAnggotaAfiliasiFinal()
    {
        $anggotaBaru = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_kta.jenis_bu', '=', 'pma')
        ->where('t_detail_kta.is_inserted', '=', 4)
        ->where('t_app_kta.status_pengajuan', '>=', 6)
        ->where(function($query) {
            $query->where('t_detail_kta.jenis_pengajuan', '=', 0)
                ->orWhere('t_detail_kta.jenis_pengajuan', '=', 3);
        })
        ->select(['t_detail_kta.id as id_detail_kta', 't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 't_detail_kta.waktu_pengajuan', 't_app_kta.status_pengajuan',
                  't_kta.jenis_bu', 't_kta.no_kta'
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
        })

        ->editColumn('no_kta', function($no_kta){
            if(empty($no_kta->no_kta)) {
                return "<a class='btn btn-xs btn-primary'>Belum Terbit</a>";
            }

            return "<a class='btn btn-xs btn-primary'>".$no_kta->no_kta."</a>";
        })

        ->editColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i> Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di tolak oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpp</a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-search-plus'></i> Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di tolah oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu nomor kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selsai</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">unverified</a>';
            } elseif ($status_pengajuan->status_pengajuan === 2) {
                return '<a class="btn btn-xs btn-warning">verified</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">rejected</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">finish</a>';
            }
        })
        ->addColumn('action', function ($t_detail_kta) {
            return '
            <a href="#" class="btn btn-sm btn-default"  id="show-form-kta-afiliasi" data-id-detail-kta="'.$t_detail_kta->id_detail_kta.'"  title="Publish KTA for this member"><i class="fa fa-file-text"></i> Input Nomor KTA</a>
            ';
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'no_kta', 'status_pengajuan'])
        ->make(true);
    }

    public function publishKtaAfiliasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kta'  => 'required|max:50',
        ]);

        if(!$validator->fails()) {
           
                $getIdKta  = DetailKta::findOrfail($request->id_detail_kta);
                
                $kta = Kta::findOrFail($getIdKta->id_kta);
                $updateKTA = $kta->update([
                    'no_kta' => $request->no_kta,
                    'status_kta' => 0
                ]);
                if($updateKTA) {
                    $updateDetailKta = $getIdKta->update([
                        'tgl_terbit' => date('Y-m-d'),
                        'view_notifikasi' => 0
                    ]);
                    $historyApp = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)->first();
                    $updateHistoryApp = $historyApp->update([
                        'status_pengajuan' => 7,
                        'keterangan' => 'Nomor KTA telah di terbitkan untuk Badan Usaha anda.'
                    ]);

                }
                
                return response()->json(['success'=>'Nomor KTA telah berhasil di buat untuk anggota ini.']);
                
        } else {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
       
    }


    public function lokalKta()
    {
        return view('backend/dpn/content-pages/publish/lokal.lokal-page');
    }

    public function getAnggotaLokalFinal()
    {
        $anggotaBaru = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_kta.jenis_bu', '=', 'pmdn')
        ->where('t_detail_kta.is_inserted', '=', 4)
        ->where('t_app_kta.status_pengajuan', '>=', 6)
        ->where(function($query) {
            $query->where('t_detail_kta.jenis_pengajuan', '=', 0)
                ->orWhere('t_detail_kta.jenis_pengajuan', '=', 3);
        })
        ->select(['t_detail_kta.id as id_detail_kta', 't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 't_detail_kta.waktu_pengajuan', 't_app_kta.status_pengajuan',
                  't_kta.jenis_bu', 't_kta.no_kta'
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
        })

        ->editColumn('no_kta', function($no_kta){
            if(empty($no_kta->no_kta)) {
                return "<a class='btn btn-xs btn-primary'>Belum Terbit</a>";
            }

            return "<a class='btn btn-xs btn-primary'>".$no_kta->no_kta."</a>";
        })

        ->editColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i> Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di tolak oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpp</a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-search-plus'></i> Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di tolah oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu nomor kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selsai</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">unverified</a>';
            } elseif ($status_pengajuan->status_pengajuan === 2) {
                return '<a class="btn btn-xs btn-warning">verified</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">rejected</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">finish</a>';
            }
        })
        ->addColumn('action', function ($t_detail_kta) {
            $countPublishNoKTA = count(RoleShareConfirmation::
                                    leftjoin('t_invoice_role_share', 't_role_share_confirmation.id_invoice_role_share', 't_invoice_role_share.id')
                                    ->where('t_invoice_role_share.id_detail_kta', $t_detail_kta->id_detail_kta)
                                    ->get()
                                );
            if($countPublishNoKTA > 0){
                return '
                <a href="#" class="btn btn-sm btn-default"  id="show-form-kta-lokal" data-id-detail-kta="'.$t_detail_kta->id_detail_kta.'"  title="Publish KTA for this member"><i class="fa fa-file-text" ></i> Input Nomor KTA</a>
                ';
            } else {
                return '
                <a href="#" class="btn btn-sm btn-default"  id="" data-id-detail-kta="'.$t_detail_kta->id_detail_kta.'"  title="Publish KTA for this member" disabled><i class="fa fa-file-text" ></i> Input Nomor KTA</a>
                ';
            }
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'no_kta','status_pengajuan'])
        ->make(true);
    }

    public function publishKtaLokal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kta'  => 'required|max:50',
        ]);

        if(!$validator->fails()) {
           
                $getIdKta  = DetailKta::findOrfail($request->id_detail_kta);
                
                $kta = Kta::findOrFail($getIdKta->id_kta);
                $updateKTA = $kta->update([
                    'no_kta' => $request->no_kta,
                    'status_kta' => 0
                ]);
                if($updateKTA) {
                    $updateDetailKta = $getIdKta->update([
                        'tgl_terbit' => date('Y-m-d'),
                        'view_notifikasi' => 0
                    ]);
                    $historyApp = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)->first();
                    $updateHistoryApp = $historyApp->update([
                        'status_pengajuan' => 7,
                        'keterangan' => 'Nomor KTA telah di terbitkan untuk Badan Usaha anda.'
                    ]);

                }
                
                return response()->json(['success'=>'Nomor KTA telah berhasil di buat untuk anggota ini.']);
                
        } else {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
       
    }


    public function daftarUlangKta()
    {
        return view('backend/dpn/content-pages/publish/daftarulang.daftar-ulang-page');
    }


    public function getAnggotaDaftarUlang()
    {
        $anggotaBaru = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta',  '=', 't_detail_kta.id')
        ->where('t_detail_kta.jenis_pengajuan',  '=', 1)
        ->where('t_detail_kta.is_inserted', '=', 4)
        ->where('t_app_kta.status_pengajuan', '>=', 6)
        ->select(['t_detail_kta.id as id_detail_kta', 't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 't_detail_kta.waktu_pengajuan', 't_app_kta.status_pengajuan',
                  't_kta.jenis_bu', 't_kta.no_kta'
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
        })

        ->editColumn('no_kta', function($no_kta){
            if(empty($no_kta->no_kta)) {
                return "<a class='btn btn-xs btn-primary'>Belum Terbit</a>";
            }

            return "<a class='btn btn-xs btn-primary'>".$no_kta->no_kta."</a>";
        })

        ->editColumn('status_pengajuan', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-search-plus'></i> Di periksa oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 1) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di tolak oleh dpp</a>";
            }

            if($status_pengajuan->status_pengajuan === 2) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpp</a>";
            }
            if($status_pengajuan->status_pengajuan === 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-search-plus'></i> Di periksa oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di tolah oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu nomor kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selsai</a>";
            }
        })
        ->addColumn('status', function($status_pengajuan){
            if($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">unverified</a>';
            } elseif ($status_pengajuan->status_pengajuan === 2) {
                return '<a class="btn btn-xs btn-warning">verified</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">rejected</a>';
            }
            elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">finish</a>';
            }
        })
        ->addColumn('action', function ($t_detail_kta) {
            return '
            <a href="#" class="btn btn-sm btn-default"  id="show-form-kta-daftar-ulang" data-id-detail-kta="'.$t_detail_kta->id_detail_kta.'"  title="Publish KTA for this member"><i class="fa fa-file-text"></i> Input Nomor KTA</a>
            ';
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'status_pengajuan', 'no_kta'])
        ->make(true);
    }


    public function publishKtaDaftarUlang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kta'  => 'required|max:50',
        ]);

        if(!$validator->fails()) {
           
                $getIdKta  = DetailKta::findOrfail($request->id_detail_kta);
                
                $kta = Kta::findOrFail($getIdKta->id_kta);
                $updateKTA = $kta->update([
                    'no_kta' => $request->no_kta,
                    'status_kta' => 0
                ]);
                if($updateKTA) {
                    $updateDetailKta = $getIdKta->update([
                        'tgl_terbit' => date('Y-m-d'),
                        'view_notifikasi' => 0
                    ]);
                    $historyApp = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)->first();
                    $updateHistoryApp = $historyApp->update([
                        'status_pengajuan' => 7,
                        'keterangan' => 'Nomor KTA telah di terbitkan untuk Badan Usaha anda.'
                    ]);

                }
                
                return response()->json(['success'=>'Nomor KTA telah berhasil di buat untuk anggota ini.']);
                
        } else {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
       
    }

}
