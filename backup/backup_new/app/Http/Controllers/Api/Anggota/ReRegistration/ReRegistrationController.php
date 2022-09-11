<?php

namespace App\Http\Controllers\Api\Anggota\ReRegistration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use Ramsey\Uuid\Uuid;
use Notification;
use Validator;
use Image;
use DB;

class ReRegistrationController extends Controller
{

    private $data;


    public function infoUmumBadanUsaha(Request $request)
    {
        $checkLastKta = \App\Kta::where('id_registrasi_users', $request->id_registrasi_users)
                                ->orderBy('created_at', 'desc')
                                ->first();
                                
        
        if (!empty($checkLastKta) && $checkLastKta->status_kta == 0) {
            return redirect()->back()->with('ktaStillActive', 'Nomor KTA anda masih aktif');
        } 
        


        $rules = array(
            'jenis_bu'  => 'required',
            'lokasi_pengurusan' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->fails()) {
            $dataInfoBu = [
                'id'                  => Uuid::uuid4()->toString(),
                'id_registrasi_users' => $request->id_registrasi_users,
                'id_dp'               => $request->id_dp,
                'jenis_bu'            => $request->jenis_bu,
                'kualifikasi'         => ($request->jenis_bu == 'pmdn') ? $request->kualifikasi : "besar",
                'lokasi_pengurusan'   => $request->lokasi_pengurusan,
                'no_kta'              => null,
                'status_kta'          => 1,
                'status_penataran'    => 1
            ];

            if (\App\Kta::create($dataInfoBu)) {
                $getLastKta = DB::table('t_kta')->orderBy('created_at', 'DESC')->first();

                $detailKta = new \App\DetailKta;

                $detailKta->id = Uuid::uuid4()->toString();

                $detailKta->id_kta = $getLastKta->id;

                $detailKta->jenis_pengajuan = 1;

                $detailKta->waktu_pengajuan = $getLastKta->created_at;

                $detailKta->tgl_terbit = null;

                $detailKta->masa_berlaku = date('Y').'-12-31';

                $detailKta->view_notifikasi = 0;

                $detailKta->view_notifikasi_dpp = 0;

                $detailKta->view_notifikasi_dpn = 0;

                $detailKta->is_inserted = false;

                if ($detailKta->save()) {
                    $getLastDetailKta = DB::table('t_detail_kta')->orderBy('created_at', 'DESC')->first();
                
                    $appKta = new  \App\HistoryApprovalPengajuan;

                    $appKta->id_detail_kta = $getLastDetailKta->id;
                    // JIka pengurusan oleh dpp maka akan di isi angka 0 dan jika pengurusan oleh dpn maka akan di isi anka 2
                    $appKta->status_pengajuan = $stsPengajuan = ($getLastKta->jenis_bu === 'pma') ? 3 : 0 ;

                    $appKta->tgl_status = date('Y/m/d H:i:s');

                    $appKta->keterangan = '';

                    $appKta->save();


                    $this->data = [
                        'data' => [
                            'id_detail_kta' => $detailKta->id
                        ],
                        'message' => 'Berhasil menginput data info umum badan usaha',
                        'status' => 200,
                        'redirect' => [
                            'url' => route('api.re-registration.administration-bu'),
                            'method' => 'POST'
                        ]
                    ];

                    return response()->json($this->data, 200);
                    
                    
                }                
            }

            $this->data = [
                'message' => 'Gagal menginput data info umum badan usaha',
                'status' => 400,
                'redirect' => redirect()->back()
            ];
            
            return response()->json($this->data, 400);
            
           
        }

        return response()->json([
            'errors' => $validator->errors()->all() 
        ]);
    }



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
                'id_detail_kta'    => $request->id_detail_kta,
                'alamat'           => $request->alamat_bu,
                'kd_pos'           => $request->kd_pos,
                'kecamatan'        => $request->kecamatan,
                'kota'             => $request->kota,
                'no_telp'          => $request->no_telp,
                'no_fax'           => $request->no_fax,
                'website'          => $request->website
            ];

            if (\App\DataAdministrasiBadanUsaha::create($dataAdministrasiBu)) {
                \App\DetailKta::whereId($request->id_detail_kta) ->update(['is_inserted' => 1]);
                $this->data = [
                    'data' => [
                        'id_detail_kta' => $request->id_detail_kta
                    ],
                    'message' => 'Berhasil menginput data administrasi badan usaha',
                    'status' => 200,
                    'redirect' => [
                        'url' => route('api.re-registration.pjbu'),
                        'method' => 'POST'
                    ]
                ];

                return response()->json($this->data, 200);
            } else {
                $this->data = [
                    'message' => 'Gagal menginput data administrasi badan usaha',
                    'status' => 400,
                    'redirect' => redirect()->back()
                ];
                
                return response()->json($this->data, 400);
            }
        } else {
            return response()->json([
                'errors' => $validator->errors()->all() 
            ]);
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
            'tempat'                  => 'required',
            'tgl_lahir'               => 'required',
            'alamat_pjbu'             => 'required',
            'no_hp_pjbu'              => 'required',
            'email_pjbu'              => 'required|email',
            'no_npwp_pjbu'            => 'required|max:21',
            
        ]);

        if (!$validator->fails()) {
            $dataPjbu = [
                'id_detail_kta'    => $request->id_detail_kta,
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
                \App\DetailKta::whereId($request->id_detail_kta) ->update(['is_inserted' => 2]);
                $this->data = [
                    'data' => [
                        'id_detail_kta' => $request->id_detail_kta
                    ],
                    'message' => 'Berhasil menginput data penanggung jawab badan usaha',
                    'status' => 200,
                    'redirect' => [
                        'url' => route('api.re-registration.legality'),
                        'method' => 'POST'
                    ]
                ];

                return response()->json($this->data, 200);
               
            } else {
                $this->data = [
                    'message' => 'Gagal menginput data  penanggung jawab badan usaha',
                    'status' => 400,
                    'redirect' => redirect()->back()
                ];
                
                return response()->json($this->data, 400);
            }
        } else {
            return response()->json([
                'errors' => $validator->errors()->all() 
            ]);
        }
    }



    public function legalitasBadanUsaha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_akte'               => 'required',
            'nm_notaris'            => 'required',
            'tgl_keluar_akte'       => 'required',
            'maksud_tujuan_akte'    => 'required',

            'no_sk_pendirian'           => 'required',
            'tgl_sk_pendirian_keluar'   => 'required',

        ]);

        if (!$validator->fails()) {
            if ($request->has('no_akte_perubahan') || $request->has('no_sk_perubahan')) {
                $legalitasBu = [
                        'id_detail_kta'    => $request->id_detail_kta,
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
                            $detailLegalitasKbli = [
                                'id_legalitas_bu' => $idLastLegalitas,
                                'nama_kbli' => $request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasKbli);
                        }
                    }
                  

                    \App\DetailKta::whereId($request->id_detail_kta) ->update(['is_inserted' => 3]);

                    $this->data = [
                        'data' => [
                            'id_detail_kta' => $request->id_detail_kta
                        ],
                        'message' => 'Berhasil menginput data legalitas badan usaha',
                        'status' => 200,
                        'redirect' => [
                            'url' => route('api.registration.documents'),
                            'method' => 'POST'
                        ]
                    ];
                    
                    return response()->json($this->data, 200);
                } else {
                    $this->data = [
                        'message' => 'Gagal menginput data  legalitas badan usaha',
                        'status' => 400,
                        'redirect' => redirect()->back()
                    ];
                    
                    return response()->json($this->data, 400);
                }
            } else {
                $legalitasBu = [
                    'id_detail_kta'       => $request->id_detail_kta,
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
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $idLastLegalitas->id,
                                'nama_kbli' =>$request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasSk);
                        }
                    }

                    \App\DetailKta::whereId($request->id_detail_kta) ->update(['is_inserted' => 3]);
                    $this->data = [
                        'data' => [
                            'id_detail_kta' => $request->id_detail_kta
                        ],
                        'message' => 'Berhasil menginput data legalitas badan usaha',
                        'status' => 200,
                        'redirect' => [
                            'url' => route('api.re-registration.documents'),
                            'method' => 'POST'
                        ]
                    ];
                    return response()->json($this->data, 200);
                } else {
                    $this->data = [
                        'data' => [
                            'id_detail_kta' => $request->id_detail_kta
                        ],
                        'message' => 'Gagal menginput data legalitas badan usaha',
                        'status' => 400,
                        'redirect' => [
                            'url' => route('api.re-registration.documents'),
                            'method' => 'POST'
                        ]
                    ];
                    return response()->json($this->data, 400);
                }
            }
        } else {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }
    }



    public function dokumenPendukung(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
            'file_kta'                         => 'required|file|mimes:pdf|max:2048',
            'surat_permohonan_daftar_ulang'    => 'required|file|mimes:pdf|max:2048',
        ]);

        if (!$validator->fails()) {
            $file_ktp_pjbu                    = $request->file('file_ktp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_npwp_pjbu                   = $request->file('file_npwp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $name_foto_pjbu                   = Uuid::uuid4().'.'.$request->file_foto_pjbu->getClientOriginalExtension();
            $file_foto_pjbu                   = Image::make($request->file_foto_pjbu)->resize(142, 169)->save(public_path('storage/legalitas-files/'.$name_foto_pjbu));
            $file_npwp_bu                     = $request->file('file_npwp_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_ijazah_pjbu                 = $request->file('file_ijazah_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_akte_pendirian_perubahan_bu = $request->file('file_akte_pendirian_perubahan_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_sk_pendirian_perubahan_bu   = $request->file('file_sk_pendirian_perubahan_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_skdp_bu                     = $request->file('file_skdp_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_siup                        = $request->file('file_siup')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_tdp                         = $request->file('file_tdp')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_nib                         = $request->file('file_nib')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_siujk                       = $request->file('file_siujk')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $file_kta                         = $request->file('file_kta')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            $surat_permohonan_daftar_ulang    = $request->file('surat_permohonan_daftar_ulang')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            
            $file = \App\DataDokumenPendukungBadanUsaha::create([
                'id_detail_kta'                    => $request->id_detail_kta,
                'file_ktp_pjbu'                    => substr($file_ktp_pjbu, 23),
                'file_npwp_pjbu'                   => substr($file_npwp_pjbu, 23) ,
                'file_foto_pjbu'                   => $name_foto_pjbu ,
                'file_npwp_bu'                     => substr($file_npwp_bu, 23) ,
                'file_ijazah_pjbu'                 => substr($file_ijazah_pjbu, 23),
                'file_akte_pendirian_perubahan_bu' => substr($file_akte_pendirian_perubahan_bu, 23) ,
                'file_sk_pendirian_perubahan_bu'   => substr($file_sk_pendirian_perubahan_bu, 23) ,
                'file_skdp_bu'                     => substr($file_skdp_bu, 23),
                'file_siup'                        => substr($file_siup, 23) ,
                'file_tdp'                         => substr($file_tdp, 23) ,
                'file_nib'                         => substr($file_nib, 23),
                'file_siujk'                       => substr($file_siujk, 23),
                'file_kta'                         => substr($file_kta, 23),
                'surat_permohonan_daftar_ulang'    => substr($surat_permohonan_daftar_ulang, 23),

            ]);
            
            if ($file) {
                \App\DetailKta::whereId($request->id_detail_kta) ->update(['is_inserted' => 4]);
                \App\HistoryApprovalPengajuan::whereId_detail_kta($request->id_detail_kta)->update(['keterangan' => 'Dokumen anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.']);
                $user  = \App\DetailKta::with('kta')->whereId($request->id_detail_kta)->first();
                $council =  \App\UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                
                $notificationData = [
                    'id_dp' => $user->kta->id_dp,
                    'message' => 'Anda memiliki 1 pengajuan baru'
                ];

                Notification::send($council, new NotifyCouncil($notificationData));
                
                $this->data = [
                    'data' => [
                        'id_detail_kta' => $request->id_detail_kta
                    ],
                    'message' => 'Berhasil menginput data dokumen pendukung badan usaha',
                    'status' => 200,
                    'redirect' => [
                        'url' => route('api.re-registration.documents'),
                        'method' => 'POST'
                    ]
                ];
                return response()->json($this->data, 200);
    
            } else {
                $this->data = [
                    'data' => [
                        'id_detail_kta' => $request->id_detail_kta
                    ],
                    'message' => 'Gagal menginput data dokumen pendukung badan usaha',
                    'status' => 400,
                    'redirect' => [
                        'url' => route('api.re-registration.documents'),
                        'method' => 'POST'
                    ]
                ];
                return response()->json($this->data, 400);
    
            }
        } else {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
        }
    }

}
