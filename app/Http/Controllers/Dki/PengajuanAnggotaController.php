<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\RegistrationUsers;
use Ramsey\Uuid\Uuid;
use Notification;
use Validator;
use Image;
use DB;

class PengajuanAnggotaController extends Controller
{

    private $data;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npwp_bu' => 'required|max:21',
            'email_bu' => 'required|email|unique:t_registrasi_users|max:100',
            'nm_bu' => 'required|string|max:50',
            'bentuk_bu' => 'required|string',
            'status_bu' => 'required|string',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required_with:password|min:6|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $dataUser = [
                'npwp_bu'   => str_replace("-", "", str_replace(".", "", $request->input('npwp_bu'))),
                'email_bu'  => $request->input('email_bu'),
                'nm_bu'     => $request->input('nm_bu'),
                'bentuk_bu' => $request->input('bentuk_bu'),
                'status_bu' => $request->input('status_bu'),
                'password'  => bcrypt($request->input('password')),
                'remember_token' =>  Uuid::uuid4()->toString(),
                'email_verified_at' => date('Y-m-d H:i:s')
            ];
            if ($user = RegistrationUsers::create($dataUser)) {

                return response()->json([
                    'data' => $user,
                    'message' => 'Anggota Berhasil Terdaftar',
                    'status' => 200
                ], 200);
            }

            return response()->json([
                'data' => null,
                'message' => 'Anggota Gagal Terdaftar',
                'status' => 400
            ], 400);
        }
    }


    public function getAnggotaByIdDp()
    {
        
        $anggota = DB::table('t_registrasi_users')
                    ->join('t_kta', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                    ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                    ->select([
                        't_registrasi_users.*',
                        't_detail_kta.id as id_detail_kta'
                        ])
                    ->where('t_kta.id_dp', Request()->input('id_dp'))
                    ->where('t_detail_kta.is_inserted', '=', 4)
                    ->get();

        if(!empty($anggota)) {
            return response()->json([
                    'data' => [
                        'members' => $anggota
                    ],
                    'message' => 'Semua anggota berdasarkan provinsi',
                    'status' => 200
                    
                
            ], 200);
        }
        return response()->json([
            'data' => [
                'members' => null
            ],
            'message' => 'Semua anggota berdasarkan provinsi',
            'status' => 200
            
        
    ], 200);
    }
        



    public function infoUmumBadanUsaha(Request $request)
    {
        $checkLastKta = \App\Kta::where('id_registrasi_users', $request->id_registrasi_users)
                                ->orderBy('created_at', 'desc')
                                ->first();
                                
        
        if (!empty($checkLastKta) && $checkLastKta->status_kta == 0) {
            return response()->json([
                'message' => 'KTA Anda masih dalam status aktif',
                'status' => 403,
                'redirect' => redirect()->back()
            ], 403);
        } 
        


        $rules = array(
            'kualifikasi'  => 'required',
            'jenis_pengajuan' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $dataInfoBu = [
                'id'                  => Uuid::uuid4()->toString(),
                'id_registrasi_users' => $request->input('id_registrasi_users'),
                'id_dp'               => $request->input('id_dp'),
                'jenis_bu'            => 'pmdn',
                'kualifikasi'         => $request->input('kualifikasi'),
                'lokasi_pengurusan'   => 'DPP INKINDO',
                'no_kta'              => null,
                'status_kta'          => 1,
                'status_penataran'    => 0,
                'registration_until_date' => date('Y-m-d H:i:s', strtotime('+11 month'))
            ];

            if (\App\Kta::create($dataInfoBu)) {
                $getLastKta = DB::table('t_kta')->orderBy('created_at', 'DESC')->first();

                $detailKta = new \App\DetailKta;

                $detailKta->id = Uuid::uuid4()->toString();

                $detailKta->id_kta = $getLastKta->id;

                $detailKta->jenis_pengajuan = $request->input('jenis_pengajuan');

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
                    
                    $appKta->status_pengajuan = 3;

                    $appKta->tgl_status = date('Y/m/d H:i:s');

                    $appKta->keterangan = 'Dokumen anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.';

                    $appKta->save();


                    $this->data = [
                        'data' => [
                            'id_detail_kta' => $detailKta->id
                        ],
                        'message' => 'Berhasil menginput data info umum badan usaha',
                        'status' => 200,
                        'redirect' => [
                            'url' => route('registration.administrasi-bu'),
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
            'alamat'             => 'required|string|max:2000',
            'kd_pos'             => 'required|string|max:225',
            'kecamatan'          => 'required|string|max:225',
            'kota'               => 'required|string|max:225',
            'no_telp'            => 'required|string|max:225',
        ]);

        if (!$validator->fails()) {
            $dataAdministrasiBu = [
                'id_detail_kta'    => $request->id_detail_kta,
                'alamat'           => $request->alamat,
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
                        'url' => route('registration.pj-bu'),
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
        $validator = Validator::make($request->all(), [
            'nm_pjbu'                 => 'required|string|max:50',
            'kewarganegaraan'         => 'required|string|max:3',
            'nik'                     => 'max:17',
            'no_passport'                => 'max:12',
            'jabatan_pjbu'            => 'required',
            'pendidikan_formal_pjbu'  => 'required',
            // 'tempat'                  => 'required',
            // 'tgl_lahir'               => 'required',
            'alamat_pjbu'             => 'required|string|max:1000',
            'no_hp_pjbu'              => 'required|string|max:22',
            'email_pjbu'              => 'required|email|string|max:225',
            'no_npwp_pjbu'            => 'required|max:21',
            
        ]);

        if (!$validator->fails()) {
            $dataPjbu = [
                'id_detail_kta'    => $request->id_detail_kta,
                'nm_pjbu'          => $request->nm_pjbu,
                'kewarganegaraan'  => $request->kewarganegaraan,
                'nik'              => $request->nik,
                'no_passport'      => $request->no_passport,
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
                        'url' => route('registration.legalitas-bu'),
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
            // 'maksud_tujuan_akte'    => 'required',

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
                            'url' => route('registration.dokumen-bu'),
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
                            'url' => route('registration.dokumen-bu'),
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
                            'url' => redirect()->back(),
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
            'file_kta'                         => 'file|mimes:pdf|max:2048',
            'surat_permohonan_baru'            => 'file|mimes:pdf|max:2048',
            'surat_permohonan_daftar_ulang'    => 'file|mimes:pdf|max:2048',
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
            
            if(is_file($request->file('file_skdp_bu'))){
                $file_skdp_bu                 = $request->file('file_skdp_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if(is_file($request->file('file_siup'))){
                $file_siup                    = $request->file('file_siup')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if(is_file($request->file('file_tdp'))){
                $file_tdp                     = $request->file('file_tdp')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if(is_file($request->file('file_siujk'))){
                $file_siujk                   = $request->file('file_siujk')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if(is_file($request->file('file_nib'))){
                $file_nib                     = $request->file('file_nib')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if(is_file($request->file('file_kta'))){
            $file_kta                         = $request->file('file_kta')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if(is_file($request->file('surat_permohonan_baru'))) {
            $surat_permohonan_baru            = $request->file('surat_permohonan_baru')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            
            }
            if(is_file($request->file('surat_permohonan_daftar_ulang'))) {
            $surat_permohonan_daftar_ulang    = $request->file('surat_permohonan_daftar_ulang')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');    
            }
            
            $file = \App\DataDokumenPendukungBadanUsaha::create([
                'id_detail_kta'                    => $request->id_detail_kta,
                'file_ktp_pjbu'                    => substr($file_ktp_pjbu, 23),
                'file_npwp_pjbu'                   => substr($file_npwp_pjbu, 23) ,
                'file_foto_pjbu'                   => $name_foto_pjbu ,
                'file_npwp_bu'                     => substr($file_npwp_bu, 23) ,
                'file_ijazah_pjbu'                 => substr($file_ijazah_pjbu, 23),
                'file_akte_pendirian_perubahan_bu' => substr($file_akte_pendirian_perubahan_bu, 23) ,
                'file_sk_pendirian_perubahan_bu'   => substr($file_sk_pendirian_perubahan_bu, 23) ,
                'file_skdp_bu'                     => (is_file($request->file('file_skdp_bu')) ? substr($file_skdp_bu, 23) : null) ,
                'file_siup'                        => (is_file($request->file('file_siup')) ? substr($file_siup, 23) : null) ,
                'file_tdp'                         => (is_file($request->file('file_tdp')) ? substr($file_tdp, 23) : null) ,
                'file_nib'                         => (is_file($request->file('file_nib')) ? substr($file_nib, 23) : null) ,
                'file_siujk'                       => (is_file($request->file('file_siujk')) ? substr($file_siujk, 23) : null) ,
                'file_kta'                         => (is_file($request->file('file_kta')) ? substr($file_kta, 23) : null),
                'surat_permohonan_baru'            => (is_file($request->file('surat_permohonan_baru')) ? substr($surat_permohonan_baru, 23) : null),
                'surat_permohonan_daftar_ulang'    => (is_file($request->file('surat_permohonan_daftar_ulang')) ? substr($surat_permohonan_daftar_ulang, 23) : null),

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

                //Notification::send($council, new NotifyCouncil($notificationData));
                
                $this->data = [
                    'data' => [
                        'id_detail_kta' => $request->id_detail_kta
                    ],
                    'message' => 'Berhasil menginput data dokumen pendukung badan usaha',
                    'status' => 200,
                    'redirect' => [
                        'url' => redirect()->back(),
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
                        'url' => redirect()->back(),
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
