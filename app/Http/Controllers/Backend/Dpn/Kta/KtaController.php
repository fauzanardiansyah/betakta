<?php

namespace App\Http\Controllers\Backend\Dpn\Kta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Kta;
use App\DetailKta;
use App\HistoryApprovalPengajuan;
use Validator;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendKta;
use PDF;
use Session;

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

            if ($status_pengajuan->status_pengajuan == 10) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-pdf-o'></i>Menunggu Bukti Bayar Anggota</a>";
            }

            if($status_pengajuan->status_pengajuan === 8) {
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
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di tolah oleh dpn</a>";
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
        // dd('tes');
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
                ->orWhere('t_detail_kta.jenis_pengajuan', '=', 5)
                ->orWhere('t_detail_kta.jenis_pengajuan', '=', 3)
                ->orWhere('t_detail_kta.jenis_pengajuan', '=', 6);
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
            if($jenis_pengajuan->jenis_pengajuan === 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-level-up'></i> Pindah Dpp</a>";
            }
            if($jenis_pengajuan->jenis_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-level-up'></i> Naik Kualifikasi</a>";
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

            if ($status_pengajuan->status_pengajuan == 10) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-pdf-o'></i>Menunggu Bukti Bayar Anggota</a>";
            }

            if($status_pengajuan->status_pengajuan === 8) {
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
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-search-ban'></i> Di tolah oleh dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu invoice dpn</a>";
            }

            if($status_pengajuan->status_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu nomor kta</a>";
            }

            if($status_pengajuan->status_pengajuan === 7  or $status_pengajuan->status_pengajuan ===11) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
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
            <a href="#" class="btn btn-sm btn-default"  id="show-form-kta-lokal" data-id-detail-kta="'.$t_detail_kta->id_detail_kta.'"  title="Publish KTA for this member"><i class="fa fa-file-text"></i> Input Nomor KTA</a>
            ';
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan', 'no_kta','status_pengajuan'])
        ->make(true);
    }

    public function publishKtaLokal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kta'  => 'required|max:50',
        ]);
        // dd('tes');

        \DB::beginTransaction();
        try {    

        if(!$validator->fails()) {
           
                $getIdKta  = DetailKta::findOrfail($request->id_detail_kta);




                
                $kta = Kta::findOrFail($getIdKta->id_kta);
                $get_kualifikasi = $kta->kualifikasi;
                $kualifikasi =  $kta->kualifikasi;
                if($get_kualifikasi == 'kecil' and $getIdKta->jenis_pengajuan == 6)
                {
                    $kualifikasi =  'menengah';
                }
                elseif($get_kualifikasi == 'menengah' and $getIdKta->jenis_pengajuan == 6)
                {
                    $kualifikasi = 'besar';
                }
                
                $updateKTA = $kta->update([
                    'no_kta' => $request->no_kta,
                    'status_kta' => 0,
                    'kualifikasi'=>$kualifikasi
                ]);
                if($updateKTA) {
                    $updateDetailKta = $getIdKta->update([
                        'tgl_terbit' => date('Y-m-d'),
                        // 'tgl_terbit' => '2020-12-31',
                        'view_notifikasi' => 0
                    ]);
                    $historyApp = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)->first();
                    
                    if($getIdKta->jenis_pengajuan == 5)
                    {
                        $updateHistoryApp = $historyApp->update([
                            'status_pengajuan' => 11,
                            'keterangan' => 'Nomor KTA telah di terbitkan untuk Badan Usaha anda.'
                        ]);    
                    }
                    else
                    {
                        $updateHistoryApp = $historyApp->update([
                            'status_pengajuan' => 7,
                            'keterangan' => 'Nomor KTA telah di terbitkan untuk Badan Usaha anda.'
                        ]);
                    }
                    

                }

                $dpnSignature = DB::table('t_dp')->whereLevel(1)->first();
                       
                   
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
                     ->where('t_kta.id', $kta->id)
                     // ->where('t_kta.id_registrasi_users', Session::get('id_registrasi_user'))
                     ->first();

                    $data_email["nm_bu"] = $dataKta->nm_bu;
                    $data_email["npwp_bu"] = $dataKta->npwp_bu;
                    $data_email["no_kta"] = $dataKta->no_kta;
                    $data_email["province_name"] = $dataKta->province_name;
                    $data_email["no_telp"] = $dataKta->no_telp;
                    $data_email["no_fax"] = $dataKta->no_fax;
                    $data_email["email_bu"] = $dataKta->email_bu;
                    $data_email["website"] = $dataKta->website;
                    $data_email["alamat"] = $dataKta->alamat;
                    $data_email["kecamatan"] = $dataKta->kecamatan;
                    $data_email["kota"] = $dataKta->kota;
                    $data_email["nm_pjbu"] = $dataKta->nm_pjbu;
                    $data_email["file_foto_pjbu"] = $dataKta->file_foto_pjbu;
                    $data_email["masa_berlaku"] = $dataKta->masa_berlaku;
                    $data_email["tgl_terbit"] = $dataKta->tgl_terbit;
                    $data_email["ketua_bkka"] = $dataKta->ketua_bkka;
                    $data_email["sekretaris_bkka"] = $dataKta->sekretaris_bkka;
                    $data_email["ttd_sekretaris_bkka"] = $dataKta->ttd_sekretaris_bkka;
                    $data_email["ttd_ketua_bkka"] = $dataKta->ttd_ketua_bkka;
                    $data_email['ttd_ketum'] = $dpnSignature->ttd_ketum;
                    $data_email['nm_ketum'] = $dpnSignature->nm_ketum;
                    $data_email['ttd_sekjen']=$dpnSignature->ttd_sekjen;
                    $data_email['nm_sekjen']=$dpnSignature->nm_sekjen;     
                    $data_email['nm_ketua_provinsi']=$dataKta->nm_ketua_provinsi;     
                    $data_email['nm_sekretaris_provinsi']=$dataKta->nm_sekretaris_provinsi;     
                    $data_email['ttd_sekretaris_provinsi']=$dataKta->ttd_sekretaris_provinsi;     
                    $data_email['ttd_ketua_provinsi']=$dataKta->ttd_ketua_provinsi;     

                    $dpnSignature = DB::table('t_dp')->whereLevel(1)->first();


                    // $pdf = PDF::loadView('prints-template.kta_download', compact('dataKta','dpnSignature'))->setPaper('a4', 'landscape');
                    //             $pdf = PDF::loadView('prints-template.kta_download', compact('dataKta','dpnSignature'))->setPaper('a4', 'landscape');

                    // Mail::send('emails-template.backend.send-kta', $data_email, function($message)use($data_email, $pdf) {
                    //     // $message->to('ariefmanggalaputra25@gmail.com', 'ariefmanggalaputra25@gmail.com')
                    //     $message->to($data_email['email_bu'], $data_email['nm_bu'])
                    //             ->from('ktainkindo@gmail.com','INKINDO')
                    //             ->subject('Penerbitan KTA')
                    //             ->attachData($pdf->output(), "kta.pdf");
                    // });

                    // $asem['password'] = 'tes';
                    // Mail::to('ariefmanggalaputra25@gmail.com')
                    // ->send(new SendKta($data_email));
                
                \DB::commit();
                return response()->json(['success'=>'Nomor KTA telah berhasil di buat untuk anggota ini.']);

        } else {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }

        } catch (\Exception $e) { 
            return response()->json(['errors'=>$e->getMessage()], 422);
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
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
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
        // dd('tes');
        $validator = Validator::make($request->all(), [
            'no_kta'  => 'required|max:50',
        ]);


        \DB::beginTransaction();
        try {    
              
            if(!$validator->fails()) {
                
                    $getIdKta  = DetailKta::findOrfail($request->id_detail_kta);
                    
                    $kta = Kta::findOrFail($getIdKta->id_kta);
                    $updateKTA = $kta->update([
                        'no_kta' => $request->no_kta,
                        'status_kta' => 0
                    ]);
                        $updateDetailKta = $getIdKta->update([
                            'tgl_terbit' => date('Y-m-d'),
                            'view_notifikasi' => 0
                        ]);
                        $historyApp = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)->first();
                        $updateHistoryApp = $historyApp->update([
                            'status_pengajuan' => 7,
                            'keterangan' => 'Nomor KTA telah di terbitkan untuk Badan Usaha anda.'
                        ]);


                    $kta = DB::table('t_kta')
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
                     ->where('t_kta.id','a4bf61c4-8978-4503-8795-47a209e03dc9')
                     ->orderBy('t_kta.created_at')
                     ->first();
                    $dpnSignature = DB::table('t_dp')->whereLevel(1)->first();
                    // dd($signature);
        
                    
                        
                    $dataKta["nm_bu"] = $kta->nm_bu;
                    $dataKta["npwp_bu"] = $kta->npwp_bu;
                    $dataKta["no_kta"] = $kta->no_kta;
                    $dataKta["province_name"] = $kta->province_name;
                    $dataKta["no_telp"] = $kta->no_telp;
                    $dataKta["no_fax"] = $kta->no_fax;
                    $dataKta["email_bu"] = $kta->email_bu;
                    $dataKta["website"] = $kta->website;
                    $dataKta["alamat"] = $kta->alamat;
                    $dataKta["kecamatan"] = $kta->kecamatan;
                    $dataKta["kota"] = $kta->kota;
                    $dataKta["nm_pjbu"] = $kta->nm_pjbu;
                    $dataKta["file_foto_pjbu"] = $kta->file_foto_pjbu;
                    $dataKta["masa_berlaku"] = $kta->masa_berlaku;
                    $dataKta["tgl_terbit"] = $kta->tgl_terbit;
                    $dataKta["ketua_bkka"] = $kta->ketua_bkka;
                    $dataKta["sekretaris_bkka"] = $kta->sekretaris_bkka;
                    $dataKta["ketua_bkka"] = $kta->ketua_bkka;
                    $dataKta["ttd_sekretaris_bkka"] = $kta->ttd_sekretaris_bkka;
                    $dataKta["ttd_ketua_bkka"] = $kta->ttd_ketua_bkka;
                    $dataKta['ttd_ketum'] = $dpnSignature->ttd_ketum;
                    $dataKta['nm_ketum'] = $dpnSignature->nm_ketum;
                    $dataKta['ttd_sekjen']=$dpnSignature->ttd_sekjen;
                    $dataKta['nm_sekjen']=$dpnSignature->nm_sekjen;


                  

                \DB::commit();
                return response()->json(['success'=>'Nomor KTA telah berhasil di buat untuk anggota ini.']);
            }
            else
            {
                response()->json(['errors'=>$validator->errors()->all()], 422);  

            }
        } catch (\Exception $e) { 
            return response()->json(['errors'=>$e->getMessage()], 422);
        }
       
    }

}
