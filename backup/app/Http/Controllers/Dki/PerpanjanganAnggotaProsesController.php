<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataAdministrasiBadanUsaha;
use App\DataPenanggungJawabBadanUsaha;
use App\DataLegalitasBadanUsaha;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use Validator;
use Notification;
use Image;

class PerpanjanganAnggotaProsesController extends Controller
{
    public function administrasiBadanUsaha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat_bu'          => 'required',
            'kd_pos'             => 'required',
            'kecamatan'          => 'required',
            'kota'               => 'required',
            'no_telp'            => 'required',
        ]);

        if (!$validator->fails()) {
            $dataAdministrasiBu = [
                'alamat'           => $request->alamat_bu,
                'kd_pos'           => $request->kd_pos,
                'kecamatan'        => $request->kecamatan,
                'kota'             => $request->kota,
                'no_telp'          => $request->no_telp,
                'no_fax'           => $request->no_fax,
                'website'          => $request->website
            ];

            $updateDataBu = DataAdministrasiBadanUsaha::where('id', $request->id_form_administrasi_bu)
            ->update($dataAdministrasiBu);
            

          
            
            if ($updateDataBu) {
                return response()->json([
                    'message' => 'Berhasil merubah data administrasi badan usaha',
                    'status' => 200,
                    'redirect' => [
                        'to' => 'Ubah penanggung jawab badan usaha',
                        'url' => route('perpanjangan.post.pj-bu'),
                        'method' => 'PATCH'
                    ]
               ], 200);
            }

            return response()->json([
                'message' => 'Gagal merubah data administrasi badan usaha',
                'status' => 400,
                'redirect' => [
                    'url' => redirect()->back(),
                    'method' => 'PATCH'
                ]
           ], 400);
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Gagal merubah data administrasi badan usaha',
                'status' => 400,
                'redirect' => [
                    'url' => redirect()->back(),
                    'method' => 'PATCH'
                ]
           ], 400);
        }
    }


    public function penanggungJawabBadanUsaha(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'nm_pjbu'                 => 'required',
            'kewarganegaraan'         => 'required',
            'nik'                     => 'max:17',
            'passport'                => 'max:12',
            'jabatan_pjbu'            => 'required',
            'pendidikan_formal_pjbu'  => 'required',
            'alamat_pjbu'             => 'required',
            'no_hp_pjbu'              => 'required',
            'email_pjbu'              => 'required|email',
            'no_npwp_pjbu'            => 'required|max:21',
            
        ]);

        if (!$validator->fails()) {
            $dataPjbu = [
                'nm_pjbu'          => $request->nm_pjbu,
                'kewarganegaraan'  => $request->kewarganegaraan,
                'nik'              => $request->nik,
                'no_passport'      => $request->passport,
                'jabatan'          => $request->jabatan_pjbu,
                'pendidikan'       => $request->pendidikan_formal_pjbu,
                'alamat'           => $request->alamat_pjbu,
                'no_hp_pjbu'       => $request->no_hp_pjbu,
                'email_pjbu'       => $request->email_pjbu,
                'npwp_pjbu'        => $request->no_npwp_pjbu,
            ];

            $updatePjbu = DataPenanggungJawabBadanUsaha::where('id', $request->id_form_pjbu)->update($dataPjbu);

            if ($updatePjbu) {
                return response()->json([
                    'message' => 'Berhasil merubah data penanggung jawab badan usaha',
                    'status' => 200,
                    'redirect' => [
                        'to' => 'Ubah legalitas badan usaha',
                        'url' => route('perpanjangan.post.legalitas-bu'),
                        'method' => 'PATCH'
                    ]
               ], 200);
            } else {
                return response()->json([
                    'message' => 'Gagal merubah data penanggung jawab badan usaha',
                    'status' => 400,
                    'redirect' => [
                        'url' => redirect()->back(),
                        'method' => 'PATCH'
                    ]
               ], 400);
            }
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Gagal merubah data penanggung jawab badan usaha',
                'status' => 400,
                'redirect' => [
                    'url' => redirect()->back(),
                    'method' => 'PATCH'
                ]
           ], 400);
        }
    }


    public function legalitasBadanUsaha(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'no_akte'               => 'required',
            'nm_notaris'            => 'required',
            'tgl_keluar_akte'       => 'required',
           

            'no_sk_pendirian'           => 'required',
            'tgl_sk_pendirian_keluar'   => 'required',
        ]);

        if (!$validator->fails()) {
            if ($request->has('no_akte_perubahan') || $request->has('no_sk_perubahan')) {
                $legalitasBu = [
                    'no_akte'          => $request->no_akte,
                    'nm_notaris'       => $request->nm_notaris,
                    'tgl_keluar_akte'  => $request->tgl_keluar_akte,
                   

        
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

                      

                        
                $updateDataBu = DataLegalitasBadanUsaha::where('id', $request->id_form_legalitas_bu)->first();
                        
                       
                if ($updateDataBu->update($legalitasBu)) {
                    if ($request->has('no_akte_perubahan')) {
                        for ($i=0; $i<count($request->no_akte_perubahan); $i++) {
                            $detailLegalitasAkte = [
                                    'id_legalitas_bu' => $request->id_form_legalitas_bu,
                                    'no_akte_perubahan' => $request->no_akte_perubahan[$i],
                                    'nm_notaris_perubahan' => $request->nm_notaris_perubahan[$i],
                                    'tgl_akte_perubahan_keluar' => $request->tgl_akte_perubahan_keluar[$i],
                                    
                
                                ];
                            \App\DataDetailLegalitas::insert($detailLegalitasAkte);
                        }
                    }
                   
                    if ($request->has('no_sk_perubahan')) {
                        for ($x=0; $x<count($request->no_sk_perubahan); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $request->id_form_legalitas_bu,
                                'no_sk_perubahan' =>$request->no_sk_perubahan[$x],
                                'tgl_sk_perubahan_keluar' => $request->tgl_sk_perubahan_keluar[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasSk);
                        }
                    }

                    if ($request->has('nama_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $request->id_form_legalitas_bu,
                                'nama_kbli' => $request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasSk);
                        }
                    }

                
                    return response()->json([
                        'message' => 'Berhasil merubah data legalitas badan usaha',
                        'status' => 200,
                        'redirect' => [
                            'url' => route('api.extend.process-documents'),
                            'method' => 'PUT'
                        ]
                   ], 200);
                } else {
                    return response()->json([
                        'message' => 'Gagal merubah data legalitas badan usaha',
                        'status' => 400,
                        'redirect' => [
                            'url' => redirect()->back(),
                            'method' => 'PUT'
                        ]
                   ], 400);
                }
            } else {
                $legalitasBu = [
        
                    'no_akte'             => $request->no_akte,
                    'no_akte'             => $request->no_akte,
                    'nm_notaris'          => $request->nm_notaris,
                    'tgl_keluar_akte'     => $request->tgl_keluar_akte,
                   
        
                
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

                $updateDataBu = DataLegalitasBadanUsaha::where('id', $request->id_form_legalitas_bu)->first();
              
                if ($updateDataBu->update($legalitasBu)) {
                    if ($request->has('nama_kbli') && $request->has('no_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasKbli = [
                                'id_legalitas_bu' => $request->id_form_legalitas_bu,
                                'nama_kbli' =>$request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasKbli);
                        }
                    }
                    return response()->json([
                        'message' => 'Berhasil merubah data legalitas badan usaha',
                        'status' => 200,
                        'redirect' => [
                            'url' => route('api.extend.process-documents'),
                            'method' => 'PATCH'
                        ]
                   ], 200);
                } else {
                    return response()->json([
                        'message' => 'Gagal merubah data legalitas badan usaha',
                        'status' => 400,
                        'redirect' => [
                            'url' => redirect()->back(),
                            'method' => 'PATCH'
                        ]
                   ], 400);
                }
            }
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Gagal merubah data legalitas badan usaha',
                'status' => 400,
                'redirect' => [
                    'url' => redirect()->back(),
                    'method' => 'PATCH'
                ]
           ], 400);
        }
    }


    public function dokumenPendukung(Request $request)
    {
        $validator = Validator::make(Input::all(), [
                'file_ktp_pjbu'                   => 'file|mimes:pdf|max:2048',
                'file_npwp_pjbu'                  => 'file|mimes:pdf|max:2048',
                'file_foto_pjbu'                  => 'file|mimes:jpeg,jpg|max:2048',
                'file_npwp_bu'                    => 'file|mimes:pdf|max:2048',
                'file_akte_pendirian_perubahan_bu'=> 'file|mimes:pdf|max:8048',
                'file_sk_pendirian_perubahan_bu'  => 'file|mimes:pdf|max:8048',
                'file_skdp_bu'                    => 'file|mimes:pdf|max:2048',
                'file_siup'                       => 'file|mimes:pdf|max:2048',
                'file_tdp'                        => 'file|mimes:pdf|max:2048',
                'file_nib'                        => 'file|mimes:pdf|max:2048',
                'file_kta'                        => 'required|file|mimes:pdf|max:2048',
                'surat_permohonan_perpanjang'     => 'required|file|mimes:pdf|max:2048',
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
          
            $file_kta                              = $request->file('file_kta')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $surat_permohonan_perpanjang           = $request->file('surat_permohonan_perpanjang')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            
            $dataDokumenPendukung = [
                    'file_ktp_pjbu'                    => ($request->hasFile('file_ktp_pjbu')) ? substr($file_ktp_pjbu, 23) : $request->old_file_ktp_pjbu,
                    'file_npwp_pjbu'                   => ($request->hasFile('file_npwp_pjbu')) ? substr($file_npwp_pjbu, 23) : $request->old_file_npwp_pjbu ,
                    'file_foto_pjbu'                   => ($request->hasFile('file_foto_pjbu')) ? $name_foto_pjbu : $request->old_file_foto_pjbu ,
                    'file_npwp_bu'                     => ($request->hasFile('file_npwp_bu')) ? substr($file_npwp_bu, 23) : $request->old_file_npwp_bu,
                    'file_akte_pendirian_perubahan_bu' => ($request->hasFile('file_akte_pendirian_perubahan_bu')) ? substr($file_akte_pendirian_perubahan_bu, 23) : $request->old_file_akte_pendirian_perubahan_bu ,
                    'file_sk_pendirian_perubahan_bu'   => ($request->hasFile('file_sk_pendirian_perubahan_bu')) ? substr($file_sk_pendirian_perubahan_bu, 23) : $request->old_file_sk_pendirian_perubahan_bu ,
                    'file_skdp_bu'                     => ($request->hasFile('file_skdp_bu')) ? substr($file_skdp_bu, 23) : $request->old_file_skdp_bu,
                    'file_siup'                        => ($request->hasFile('file_siup')) ? substr($file_siup, 23) : $request->old_file_skdp_bu ,
                    'file_tdp'                         => ($request->hasFile('file_tdp')) ? substr($file_tdp, 23) : $request->old_file_siup ,
                    'file_nib'                         => ($request->has('file_nib')) ? substr($file_nib, 23) : $request->old_file_file_nib,
                    'file_kta'                         => substr($file_kta, 23),
                    'surat_permohonan_perpanjang'      => substr($surat_permohonan_perpanjang, 23)
                ];

            $file = \App\DataDokumenPendukungBadanUsaha::where('id', $request->id_form_dokumen_bu)->first();

            if ($file->update($dataDokumenPendukung)) {
                $detailKta = \App\DetailKta::find($file->id_detail_kta);
        
                $detailKta->jenis_pengajuan = 3;

                $detailKta->waktu_pengajuan = date('Y-m-d H:i:s');

                $detailKta->masa_berlaku    = (substr($detailKta->masa_berlaku, 0, 4)+1).'-12-31';

                $detailKta->view_notifikasi = 0;

                if ($detailKta->save() === true) {
                    $kta = \App\Kta::find($detailKta->id_kta);
        
                    $appKta  = \App\HistoryApprovalPengajuan::whereId_detail_kta($file->id_detail_kta)->first();
                        
                    $appKta->tgl_status = date('Y-m-d H:i:s');
        
                    $appKta->status_pengajuan  = 3 ;
        
                    $appKta->keterangan = "Dokumen pengajuan perpanjangan anda telah memasuki fase 'Screening' oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya";
                        
                    $appKta->save();
                }


                $user  = \App\DetailKta::with('kta')->whereId($file->id_detail_kta)->first();
                
                $council =  \App\UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                    
 
                return response()->json([
                    'message' => 'Berhasil merubah data dokumen pendukung dan melakukan pengajuan perpanjangan Kartu Tanda Anggota badan usaha',
                    'status' => 200,
               ], 200);
            } else {
                return response()->json([
                    'message' => 'Gagal melakukan pengajuan perpanjangan Kartu Tanda Anggota badan usaha',
                    'status' => 400,
                    'redirect' => [
                        'url' => redirect()->back(),
                        'method' => 'PUT'
                    ]
               ], 400);
            }
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Gagal merubah data dokumen badan usaha',
                'status' => 400,
                'redirect' => [
                    'url' => redirect()->back(),
                    'method' => 'PATCH'
                ]
           ], 400);
        }
    }
}
