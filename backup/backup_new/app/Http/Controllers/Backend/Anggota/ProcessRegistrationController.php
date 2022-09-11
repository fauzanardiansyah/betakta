<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use App\UsersDppDpn;
use Ramsey\Uuid\Uuid;
use Notification;
use Validator;
use Session;
use Image;
use DB;

class ProcessRegistrationController extends Controller
{
    public function infoUmumBadanUsaha(Request $request)
    {
        $checkLastKta = \App\Kta::where('id_registrasi_users', Session::get('id_registrasi_user'))
                                ->orderBy('created_at', 'desc')
                                ->first();

        // update by Yudiana 22-12-2020
        $cekJenisPengajuan = count(\App\Kta::leftjoin('t_detail_kta', 't_kta.id', 't_detail_kta.id_kta')
                            ->where('id_registrasi_users', Session::get('id_registrasi_user'))
                            ->where('jenis_pengajuan', 0)
                            ->where('is_inserted', 4)
                            ->get());
        if($cekJenisPengajuan > 0) {
            return redirect()->route('anggota.registration')->with('preventJenisPengajuan', 'Pengajuan Baru Anda sudah ada dan sedang di proses');
        }
      
                                
        if($request->input('provinsi') == 17) {
            return redirect()->route('anggota.registration')->with('preventDKI', 'Sedang dalam Proses Integrasi DPN & DPP DKI');
        }
        if (!empty($checkLastKta) && $checkLastKta->status_kta == 0) {
            return redirect()->route('anggota.registration')->with('ktaStillActive', 'Nomor KTA anda masih aktif');
        } 


        $rules = array(
            'jenis_bu'  => 'required',
            'lokasi_pengurusan' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->fails()) {
            $dataInfoBu = [
                'id'                  => Uuid::uuid4()->toString(),
                'id_registrasi_users' => Session::get('id_registrasi_user'),
                'id_dp'               => $request->provinsi,
                'jenis_bu'            => $request->jenis_bu,
                'kualifikasi'         => ($request->jenis_bu == 'pmdn') ? $request->kualifikasi : "besar",
                'lokasi_pengurusan'   => $request->lokasi_pengurusan,
                'no_kta'              => null,
                'status_kta'          => 1,
                'status_penataran'    => 1,
                'registration_until_date' => date('Y-m-d H:i:s', strtotime('+11 month'))
            ];

            if (\App\Kta::create($dataInfoBu)) {
                $getLastKta = DB::table('t_kta')->orderBy('created_at', 'DESC')->first();

                $detailKta = new \App\DetailKta;

                $detailKta->id = Uuid::uuid4()->toString();

                $detailKta->id_kta = $getLastKta->id;

                $detailKta->jenis_pengajuan = 0;

                $detailKta->waktu_pengajuan = $getLastKta->created_at;

                $detailKta->tgl_terbit = null;

                $detailKta->masa_berlaku = date('Y').'-12-31';

                $detailKta->view_notifikasi = 0;

                $detailKta->view_notifikasi_dpp = 0;

                $detailKta->view_notifikasi_dpn = 0;

                $detailKta->is_inserted = false;

                if ($detailKta->save()) {
                    $getLastDetailKta = DB::table('t_detail_kta')->orderBy('created_at', 'DESC')->first();
                    
                    Session::put('id_detail_kta', $getLastDetailKta->id);

                    $appKta = new  \App\HistoryApprovalPengajuan;

                    $appKta->id_detail_kta = Session::get('id_detail_kta');
                    // JIka pengurusan oleh dpp maka akan di isi angka 0 dan jika pengurusan oleh dpn maka akan di isi anka 2
                    $appKta->status_pengajuan = $stsPengajuan = ($getLastKta->jenis_bu === 'pma') ? 3 : 0 ;

                    $appKta->tgl_status = date('Y/m/d H:i:s');

                    $appKta->keterangan = '';

                    $appKta->save();
                    
                    return redirect()->route('anggota.registration.formAdministrasiBadanUsaha');
                }
            }
            
            return redirect('/panel/anggota/registrasi-anggota');
        }

        return redirect('/panel/anggota/registrasi-anggota');
    }

    public function administrasiBadanUsaha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat_bu'          => 'required|string|max:1000',
            'kd_pos'             => 'required|string|max:30',
            'kecamatan'          => 'required|string|max:30',
            'kota'               => 'required|string|max:30',
            'no_telp'            => 'required|string|max:13',
            'no_fax'             => 'max:30',
            'website'            => 'max:40',
        ]);

        if (!$validator->fails()) {
            $dataAdministrasiBu = [
                'id_detail_kta'    => Session::get('id_detail_kta'),
                'alamat'           => $request->alamat_bu,
                'kd_pos'           => $request->kd_pos,
                'kecamatan'        => $request->kecamatan,
                'kota'             => $request->kota,
                'no_telp'          => $request->no_telp,
                'no_fax'           => $request->no_fax,
                'website'          => $request->website
            ];

            if (\App\DataAdministrasiBadanUsaha::create($dataAdministrasiBu)) {
                \App\DetailKta::whereId(Session::get('id_detail_kta')) ->update(['is_inserted' => 1]);
                return redirect()->route('anggota.registration.formPenanggungJawabBadanUsaha');
            } else {
                return redirect()->route('anggota.registration.formAdministrasiBadanUsaha');
            }
        } else {
            return redirect()->route('anggota.registration.formAdministrasiBadanUsaha')
            ->withErrors($validator);
        }
    }

    public function penanggungJawabBadanUsaha(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'nm_pjbu'                 => 'required|string|max:40',
            'kewarganegaraan'         => 'required|string|max:3',
            'nik'                     => 'string|max:17|nullable',
            'passport'                => 'string|max:12|nullable',
            'jabatan_pjbu'            => 'required|string|max:15',
            'pendidikan_formal_pjbu'  => 'required|string|max:10',
            'tempat'                  => 'required|max:50',
            'tgl_lahir'               => 'required|string|max:30',
            'alamat_pjbu'             => 'required|string|max:1000',
            'no_hp_pjbu'              => 'required|string|max:20',
            'email_pjbu'              => 'required|email|string|max:225',
            'no_npwp_pjbu'            => 'required|max:21',
            
        ]);

        if (!$validator->fails()) {
            $dataPjbu = [
                'id_detail_kta'    => Session::get('id_detail_kta'),
                'nm_pjbu'          => $request->nm_pjbu,
                'kewarganegaraan'  => $request->kewarganegaraan,
                'nik'              => $request->nik,
                'no_passport'      => $request->passport,
                'jabatan'          => $request->jabatan_pjbu,
                'pendidikan'       => $request->pendidikan_formal_pjbu,
                'tempat'           => $request->tempat,
                'tgl_lahir'        => $request->tgl_lahir,
                'alamat'           => $request->alamat_pjbu,
                'no_hp_pjbu'       => $request->no_hp_pjbu,
                'email_pjbu'       => $request->email_pjbu,
                'npwp_pjbu'        => $request->no_npwp_pjbu,
            ];

            if (\App\DataPenanggungJawabBadanUsaha::create($dataPjbu)) {
                \App\DetailKta::whereId(Session::get('id_detail_kta')) ->update(['is_inserted' => 2]);
                return redirect()->route('anggota.registration.formLegalitasBadanUsaha');
            } else {
                return redirect()->route('anggota.registration.formPenanggungJawabBadanUsaha');
            }
        } else {
            return redirect()->route('anggota.registration.formPenanggungJawabBadanUsaha')
            ->withErrors($validator);
        }
    }

    public function legalitasBadanUsaha(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'no_akte'               => 'required|max:50',
            'nm_notaris'            => 'required|max:50',
            'tgl_keluar_akte'       => 'required|max:50',
            'maksud_tujuan_akte'    => 'required|max:2000',
            'no_sk_pendirian'           => 'required|max:50',
            'tgl_sk_pendirian_keluar'   => 'required|max:50',

            'no_skdp'                  => 'max:50',
            'penerbit_skdp'            => 'max:50',
            'tgl_keluar_skdp'          => 'max:50',
            'masa_berlaku_skdp'        => 'max:50',

            'no_siup'            => 'max:50',
            'penerbit_siup'      => 'max:50',
            'tgl_keluar_siup'    => 'max:50',
            'masa_berlaku_siup'  => 'max:50',

            'no_tdp'           => 'max:50',
            'penerbit_tdp'     => 'max:50',
            'tgl_keluar_tdp'   => 'max:50',
            'masa_berlaku_tdp' => 'max:50',

            'no_nib'           => 'max:50',
            'tgl_keluar_nib'   => 'max:50',

        ]);
        

        if (!$validator->fails()) {
            if ($request->has('no_akte_perubahan') || $request->has('no_sk_perubahan')) {
                $legalitasBu = [
                            'id_detail_kta'    => Session::get('id_detail_kta'),
                            'no_akte'          => $request->no_akte,
                            'nm_notaris'       => $request->nm_notaris,
                            'tgl_keluar_akte'  => $request->tgl_keluar_akte,
                            'maksud_tujuan_akte' => $request->maksud_tujuan_akte,
        
                
                            'no_sk_pendirian'          => $request->no_sk_pendirian,
                            'tgl_sk_pendirian_keluar'  => $request->tgl_sk_pendirian_keluar,

                            'no_skdp'                  =>$request->no_skdp,
                            'penerbit_skdp'            => $request->penerbit_skdp,
                            'tgl_keluar_skdp'          =>$request->tgl_keluar_skdp,
                            'masa_berlaku_skdp'        =>$request->masa_berlaku_skdp,
                
                            'no_siup'            => $request->no_siup,
                            'penerbit_siup'      => $request->penerbit_siup,
                            'tgl_keluar_siup'    => $request->tgl_keluar_siup,
                            'masa_berlaku_siup'  => $request->masa_berlaku_siup,
                
                            'no_tdp'           => $request->no_tdp,
                            'penerbit_tdp'     => $request->penerbit_tdp,
                            'tgl_keluar_tdp'   => $request->tgl_keluar_tdp,
                            'masa_berlaku_tdp' => $request->masa_berlaku_tdp,
                
                            'no_nib'           => $request->no_nib,
                            'tgl_keluar_nib'   =>$request->tgl_keluar_nib,
                            
                        ];

                if ($idLastLegalitas = DB::table('t_legalitas_kta')->insertGetId($legalitasBu)) {
                    if ($request->has('no_akte_perubahan')) {
                        for ($i=0; $i<count($request->no_akte_perubahan); $i++) {
                            $detailLegalitasAkte = [
                                    'id_legalitas_bu' => $idLastLegalitas,
                                    'no_akte_perubahan' => $request->no_akte_perubahan[$i],
                                    'nm_notaris_perubahan' => $request->nm_notaris_perubahan[$i],
                                    'tgl_akte_perubahan_keluar' => $request->tgl_akte_perubahan_keluar[$i],
                                    'maksud_tujuan_akte_perubahan' => $request->maksud_tujuan_akte_perubahan[$i]
                
                                ];
                            \App\DataDetailLegalitas::insert($detailLegalitasAkte);
                        }
                    }
                   
                    if ($request->has('no_sk_perubahan')) {
                        for ($x=0; $x<count($request->no_sk_perubahan); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $idLastLegalitas,
                                'no_sk_perubahan' =>$request->no_sk_perubahan[$x],
                                'tgl_sk_perubahan_keluar' => $request->tgl_sk_perubahan_keluar[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasSk);
                        }
                    }


                    if ($request->has('nama_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $idLastLegalitas,
                                'nama_kbli' => $request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasSk);
                        }
                    }
                  

                    \App\DetailKta::whereId(Session::get('id_detail_kta')) ->update(['is_inserted' => 3]);

                    return redirect()->route('anggota.registration.formUploadDokumenPendukung');
                } else {
                    return redirect()->route('anggota.registration.formLegalitasBadanUsaha');
                }
            } else {
                $legalitasBu = [
                    'id_detail_kta'       => Session::get('id_detail_kta'),
                    'no_akte'             => $request->no_akte,
                    'nm_notaris'          => $request->nm_notaris,
                    'tgl_keluar_akte'     => $request->tgl_keluar_akte,
                    'maksud_tujuan_akte'  => $request->maksud_tujuan_akte,
        
                
                    'no_sk_pendirian'          => $request->no_sk_pendirian,
                    'tgl_sk_pendirian_keluar'  => $request->tgl_sk_pendirian_keluar,


                    'no_skdp'           =>$request->no_skdp,
                    'penerbit_skdp'     => $request->penerbit_skdp,
                    'tgl_keluar_skdp'   =>$request->tgl_keluar_skdp,
                    'masa_berlaku_skdp' =>$request->masa_berlaku_skdp,
        
                    'no_siup'           =>$request->no_siup,
                    'penerbit_siup'     =>$request->penerbit_siup,
                    'tgl_keluar_siup'   => $request->tgl_keluar_siup,
                    'masa_berlaku_siup' => $request->masa_berlaku_siup,
        
                    'no_tdp'           => $request->no_tdp,
                    'penerbit_tdp'     =>$request->penerbit_tdp,
                    'tgl_keluar_tdp'   =>$request->tgl_keluar_tdp,
                    'masa_berlaku_tdp' => $request->masa_berlaku_tdp,
        
                    'no_nib'           => $request->no_nib,
                    'tgl_keluar_nib'   =>$request->tgl_keluar_nib,
                ];

                if ($idLastLegalitas = \App\DataLegalitasBadanUsaha::create($legalitasBu)) {
                    if ($request->has('nama_kbli') && $request->has('no_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasKbli = [
                                'id_legalitas_bu' => $idLastLegalitas->id,
                                'nama_kbli' =>$request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasKbli);
                        }
                    }

                    \App\DetailKta::whereId(Session::get('id_detail_kta')) ->update(['is_inserted' => 3]);
                    return redirect()->route('anggota.registration.formUploadDokumenPendukung');
                } else {
                    return redirect()->route('anggota.registration.formLegalitasBadanUsaha');
                }
            }
        } else {
            return redirect()->route('anggota.registration.formLegalitasBadanUsaha')
            ->withErrors($validator);
        }
    }

    public function dokumenPendukung(Request $request)
    {
        $validator = Validator::make(Input::all(), [
                'file_ktp_pjbu'                    => 'required|file|mimes:pdf|max:2048',
                'file_npwp_pjbu'                   => 'required|file|mimes:pdf|max:2048',
                'file_foto_pjbu'                   => 'required|file|mimes:jpeg,jpg|max:2048',
                'file_npwp_bu'                     => 'required|file|mimes:pdf|max:2048',
                'file_ijazah_pjbu'                 => 'required|file|mimes:pdf|max:2048',
                'file_akte_pendirian_perubahan_bu' => 'required|file|mimes:pdf|max:8048',
                'file_sk_pendirian_perubahan_bu'   => 'required|file|mimes:pdf|max:8048',
                'file_skdp_bu'                     => 'file|mimes:pdf|max:2048',
                'file_siup'                        => 'file|mimes:pdf|max:2048',
                'file_tdp'                         => 'file|mimes:pdf|max:2048',
                'file_nib'                         => 'file|mimes:pdf|max:2048',
                'file_siujk'                       => 'file|mimes:pdf|max:2048',
                'surat_permohonan_baru'            => 'required|file|mimes:pdf|max:2048',
            ]);
    
        if (!$validator->fails()) {
            if ($request->hasFile('file_ktp_pjbu')) {
                $file_ktp_pjbu                     = $request->file('file_ktp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_npwp_pjbu')) {
                $file_npwp_pjbu                    = $request->file('file_npwp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_foto_pjbu')) {
                $name_foto_pjbu                   = Uuid::uuid4().'.'.$request->file_foto_pjbu->getClientOriginalExtension();
                $file_foto_pjbu                   = Image::make($request->file_foto_pjbu)->resize(142, 169)->save(public_path('storage/legalitas-files/'.$name_foto_pjbu));
            }
            if ($request->hasFile('file_npwp_bu')) {
                $file_npwp_bu                      = $request->file('file_npwp_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_ijazah_pjbu')) {
                $file_ijazah_pjbu                  = $request->file('file_ijazah_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_akte_pendirian_perubahan_bu')) {
                $file_akte_pendirian_perubahan_bu  = $request->file('file_akte_pendirian_perubahan_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_sk_pendirian_perubahan_bu')) {
                $file_sk_pendirian_perubahan_bu    = $request->file('file_sk_pendirian_perubahan_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_skdp_bu')) {
                $file_skdp_bu                      = $request->file('file_skdp_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_siup')) {
                $file_siup                         = $request->file('file_siup')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_tdp')) {
                $file_tdp                          = $request->file('file_tdp')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_nib')) {
                $file_nib                          = $request->file('file_nib')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_siujk')) {
                $file_siujk                        = $request->file('file_siujk')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
                
            $surat_permohonan_baru                 = $request->file('surat_permohonan_baru')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            

         
            $file = \App\DataDokumenPendukungBadanUsaha::create([
                'id_detail_kta'                    => Session::get('id_detail_kta'),
                'file_ktp_pjbu'                    => substr($file_ktp_pjbu, 23),
                'file_npwp_pjbu'                   => substr($file_npwp_pjbu, 23) ,
                'file_foto_pjbu'                   => $name_foto_pjbu ,
                'file_npwp_bu'                     => substr($file_npwp_bu, 23) ,
                'file_ijazah_pjbu'                 => substr($file_ijazah_pjbu, 23),
                'file_akte_pendirian_perubahan_bu' => substr($file_akte_pendirian_perubahan_bu, 23) ,
                'file_sk_pendirian_perubahan_bu'   => substr($file_sk_pendirian_perubahan_bu, 23) ,
                'file_skdp_bu'                     => (!empty($file_skdp_bu)) ? substr($file_skdp_bu, 23) : null,
                'file_siup'                        => (!empty($file_siup)) ? substr($file_siup, 23) : null ,
                'file_tdp'                         => (!empty($file_tdp)) ? substr($file_tdp, 23) : null ,
                'file_nib'                         => (!empty($file_nib)) ? substr($file_nib, 23) : null,
                'file_siujk'                       => (!empty($file_siujk)) ? substr($file_siujk, 23) : null,
                'surat_permohonan_baru'            => substr($surat_permohonan_baru, 23),
                ]);

            if ($file) {
                \App\DetailKta::whereId(Session::get('id_detail_kta')) ->update(['is_inserted' => 4]);
                \App\HistoryApprovalPengajuan::whereId_detail_kta(Session::get('id_detail_kta'))->update(['keterangan' => 'Dokumen anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.']);
                $user  = \App\DetailKta::with('kta')->whereId(Session::get('id_detail_kta'))->first();
                $council =  UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                
                $notificationData = [
                    'id_dp' => $user->kta->id_dp,
                    'message' => 'Anda memiliki 1 pengajuan baru'
                ];

                Notification::send($council, new NotifyCouncil($notificationData));
                
                return redirect()->route('anggota.status.main')->with('successRegistration', 'Berhasil melakukan registrasi anggota');
            // }
            } else {
                return redirect()->route('anggota.registration.formUploadDokumenPendukung');
            }
        } else {
            return redirect()->route('anggota.registration.formUploadDokumenPendukung')
                ->withErrors($validator);
        }
    }
}
