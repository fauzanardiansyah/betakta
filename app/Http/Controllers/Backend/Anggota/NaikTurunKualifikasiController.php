<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use \App\Helpers\LocalDate;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Input;

class NaikTurunKualifikasiController extends Controller
{

    #==========
        /* Naik Kualifikasi */
    #=========  


    public function index_naik_kualifikasi()
    {
        $kta =  DB::table('t_kta as a')
            ->join('t_registrasi_users as b', 'a.id_registrasi_users', '=', 'b.id')
            ->where('id_registrasi_users',Session::get('id_registrasi_user'))
            ->whereNotNull('a.no_kta')
            ->first();
    

        $allDPP = DB::table('t_dp')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->select('t_dp.id', 'provinsi.name')
            ->orderBy('t_dp.id', 'DESC')
            ->get();

        return view('backend/anggota/content-pages/naik_turun_kualifikasi.index_naik_kualifikasi', compact('allDPP','kta'));
    }

	

    
    public function form_badan_usaha_naik(Request $request)
    {

            
            $dataUser = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->join('t_administrasi_kta as tak','tdk.id','tak.id_detail_kta')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
            // dd($dataUser);
            
            return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_badan_usaha_naik', compact('dataUser'));
    }

    public function form_penanggung_jawab_naik(Request $request)
    {

        // dd('tes');

        // dd($request->all());

        $checkLastKta = \App\Kta::where('id_registrasi_users', Session::get('id_registrasi_user'))
                                ->orderBy('created_at', 'desc')
                                ->first();
        $get_detail = \App\Helpers\LocalDate::get_detail_kta();

        

        if($request->provinsi_tujuan == $get_detail->id_dp)
        {
            return redirect()->back()->with('get_exist_dpp', 'Nomor KTA anda masih aktif');
        }
        
        if (empty($checkLastKta)) {
            return redirect()->back()->with('validasi_kta_kosong', 'Nomor KTA anda masih aktif');
        } 


        $validator = \Validator::make($request->all(), [
            'alamat_bu'          => 'required|string|max:1000',
            'kd_pos'             => 'required|string|max:30',
            'kecamatan'          => 'required|string|max:30',
            'kota'               => 'required|string|max:30',
            'no_telp'            => 'required|string|max:13',
            'no_fax'             => 'max:30',
            'website'            => 'max:40',
        ]);

        $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
        
        if (!$validator->fails()) 
        {
            $data_naik = [
                'jenis_pengajuan'=>'6',
                'waktu_pengajuan'   => date('Y-m-d H:i:s'),
            ];

            \App\DetailKta::where('id',$get_detail->id)->update($data_naik);



            $appKta['id_detail_kta'] = $get_detail->id;
            
            $appKta['status_pengajuan'] =  0 ;

            $appKta['tgl_status'] = date('Y-m-d H:i:s');

            $appKta['keterangan'] = 'Dokumen "Naik Kualifikasi"  anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.';

            \App\HistoryApprovalPengajuan::where('id_detail_kta',$get_detail->id)->update($appKta);


             $dataAdministrasiBu = [
                'alamat'           => $request->alamat_bu,
                'kd_pos'           => $request->kd_pos,
                'kecamatan'        => $request->kecamatan,
                'kota'             => $request->kota,
                'no_telp'          => $request->no_telp,
                'no_fax'           => $request->no_fax,
                'website'          => $request->website
            ];

            \App\DataAdministrasiBadanUsaha::where('id_detail_kta',$get_detail->id)->update($dataAdministrasiBu);

            $dataUser = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->join('t_pj_kta as tak','tdk.id','tak.id_detail_kta')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
            // dd($dataUser);
            return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_penanggung_jawab_naik',compact('dataUser'));
        } else {
            // dd('tes1');
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        
    }


    public function form_legalitas_naik(Request $request)
    {   
        
        // dd($request->all());
        $validator = \Validator::make(Input::all(), [
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

        $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();

        if (!$validator->fails()) {
            $dataPjbu = [
                'id_detail_kta'    => $get_data->id,
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

            // dd($get_data->id);
            $update = \App\DataPenanggungJawabBadanUsaha::where('id_detail_kta',$get_data->id)
            ->update($dataPjbu);


            $dataUser = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->join('t_legalitas_kta as tak','tdk.id','tak.id_detail_kta')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
            // dd($dataUser);



            return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_legalitas_naik',compact('dataUser'));
            
        } else {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }



    }


    public function form_dokumen_pendukung_naik(Request $request)
    {
          $validator = \Validator::make(Input::all(), [
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
        
        $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();


            // dd($dataUser);

        if (!$validator->fails()) {
            if ($request->has('no_akte_perubahan') || $request->has('no_sk_perubahan')) {
                $legalitasBu = [
                            
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

                if ($idLastLegalitas = DB::table('t_legalitas_kta')->where('id_detail_kta',$get_data->id)->update($legalitasBu)) {
                    if ($request->has('no_akte_perubahan')) {
                        for ($i=0; $i<count($request->no_akte_perubahan); $i++) {
                            $detailLegalitasAkte = [
                                    'id_legalitas_bu' => $idLastLegalitas,
                                    'no_akte_perubahan' => $request->no_akte_perubahan[$i],
                                    'nm_notaris_perubahan' => $request->nm_notaris_perubahan[$i],
                                    'tgl_akte_perubahan_keluar' => $request->tgl_akte_perubahan_keluar[$i],
                                    'maksud_tujuan_akte_perubahan' => $request->maksud_tujuan_akte_perubahan[$i]
                
                                ];
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasAkte);
                        }
                    }
                   
                    if ($request->has('no_sk_perubahan')) {
                        for ($x=0; $x<count($request->no_sk_perubahan); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $idLastLegalitas,
                                'no_sk_perubahan' =>$request->no_sk_perubahan[$x],
                                'tgl_sk_perubahan_keluar' => $request->tgl_sk_perubahan_keluar[$x]
                            ];
    
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasSk);
                        }
                    }


                    if ($request->has('nama_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $idLastLegalitas,
                                'nama_kbli' => $request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasSk);
                        }
                    }
                  
                    return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_pendukung_naik');
                } else {
                    return redirect()->route('anggota.naik_turun_kualifikasi.form_legalitas_naik');
                }
            } else {
                $legalitasBu = [
                    // 'id_detail_kta'       => Session::get('id_detail_kta'),
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

                if ($idLastLegalitas = \App\DataLegalitasBadanUsaha::where('id_detail_kta',$get_data->id)->update($legalitasBu)) {
                    if ($request->has('nama_kbli') && $request->has('no_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasKbli = [
                                'id_legalitas_bu' => $idLastLegalitas->id,
                                'nama_kbli' =>$request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasKbli);
                        }
                    }

                    // \App\DetailKta::whereId(Session::get('id_detail_kta')) ->update(['is_inserted' => 3]);
                    // return redirect()->route('anggota.registration.formUploadDokumenPendukung');
                    return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_pendukung_naik');
                } else {
                    return redirect()->route('anggota.naik_turun_kualifikasi.form_legalitas_naik');
                }
            }
        } else {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        // return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_pendukung_naik');
    }


    public function action_naik_kualifikasi(Request $request)
    {
        // dd('tes');
        $validator = \Validator::make(Input::all(), [
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
                
            ]);

          $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
        
        if (!$validator->fails()) 
        {
            if ($request->hasFile('file_ktp_pjbu')) {
                $file_ktp_pjbu                     = $request->file('file_ktp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_npwp_pjbu')) {
                $file_npwp_pjbu                    = $request->file('file_npwp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_foto_pjbu')) {
                $name_foto_pjbu                   = Uuid::uuid4().'.'.$request->file_foto_pjbu->getClientOriginalExtension();
                $file_foto_pjbu                   = \Image::make($request->file_foto_pjbu)->resize(142, 169)->save(public_path('storage/legalitas-files/'.$name_foto_pjbu));
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
         
             \App\DataDokumenPendukungBadanUsaha::where('id_detail_kta',$get_data->id)->update([
                'id_detail_kta'                    => $get_data->id,
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
                // 'surat_permohonan_baru'            => substr($surat_permohonan_baru, 23),
                ]);


                // \App\DetailKta::whereId($get_data->id) ->update(['is_inserted' => 4]);
                \App\HistoryApprovalPengajuan::whereId_detail_kta($get_data->id)->update(['keterangan' => 'Dokumen anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.']);
                \App\InvoicePengajuanKta::where('id_detail_kta',$get_data->id)->where('jenis_pengajuan',6)->update(['status_pembayaran' => 0,'jml_tagihan'=>0,'jml_tagihan_naik'=>0]);
                $user  = \App\DetailKta::with('kta')->whereId($get_data->id)->first();
                $council =  \App\UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                
                $notificationData = [
                    'id_dp' => $user->kta->id_dp,
                    'message' => 'Anda memiliki 1 edit data baru'
                ];


                
                return redirect()->route('anggota.status.main')->with('successEdit', 'Berhasil melakukan registrasi anggota');
            
        } else {
            
               return redirect()->route('anggota.naik_turun_kualifikasi.form_dokumen_pendukung_naik')->withErrors($validator)
                ->withInput();
        }
    }



    #==========
        /* Turun Kualifikasi */
    #=========  

    public function index_turun_kualifikasi()
    {

    
        $kta =  DB::table('t_kta as a')
            ->join('t_registrasi_users as b', 'a.id_registrasi_users', '=', 'b.id')
            ->where('id_registrasi_users',Session::get('id_registrasi_user'))
            ->whereNotNull('a.no_kta')
            ->first();
    

        $allDPP = DB::table('t_dp')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->select('t_dp.id', 'provinsi.name')
            ->orderBy('t_dp.id', 'DESC')
            ->get();

        return view('backend/anggota/content-pages/naik_turun_kualifikasi.index_turun_kualifikasi', compact('allDPP','kta'));
    }

    
    public function form_badan_usaha_turun(Request $request)
    {           
            
            $dataUser = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->join('t_administrasi_kta as tak','tdk.id','tak.id_detail_kta')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
            
            
            return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_badan_usaha_turun', compact('dataUser'));
    }

    public function form_penanggung_jawab_turun(Request $request)
    {
        // dd('tes');


        $checkLastKta = \App\Kta::where('id_registrasi_users', Session::get('id_registrasi_user'))
                                ->orderBy('created_at', 'desc')
                                ->first();
        $get_detail = \App\Helpers\LocalDate::get_detail_kta();


        if($request->provinsi_tujuan == $get_detail->id_dp)
        {
            return redirect()->back()->with('get_exist_dpp', 'Nomor KTA anda masih aktif');
        }
        
        if (empty($checkLastKta)) {
            return redirect()->back()->with('validasi_kta_kosong', 'Nomor KTA anda masih aktif');
        } 


        $validator = \Validator::make($request->all(), [
            'alamat_bu'          => 'required|string|max:1000',
            'kd_pos'             => 'required|string|max:30',
            'kecamatan'          => 'required|string|max:30',
            'kota'               => 'required|string|max:30',
            'no_telp'            => 'required|string|max:13',
            'no_fax'             => 'max:30',
            'website'            => 'max:40',
        ]);

        $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
        
        if (!$validator->fails()) 
        {
            // dd('tes');

            $data_pindah = [
                'jenis_pengajuan'=>'7',
                'waktu_pengajuan'   => date('Y-m-d H:i:s'),
            ];

            \App\DetailKta::where('id',$get_detail->id)->update($data_pindah);


            $appKta['id_detail_kta'] = $get_detail->id;
            
            $appKta['status_pengajuan'] =  0 ;

            $appKta['tgl_status'] = date('Y-m-d H:i:s');

            $appKta['keterangan'] = 'Dokumen "Turun Kualifikasi"  anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.';

            \App\HistoryApprovalPengajuan::where('id_detail_kta',$get_detail->id)->update($appKta);


            $dataAdministrasiBu = [
                'alamat'           => $request->alamat_bu,
                'kd_pos'           => $request->kd_pos,
                'kecamatan'        => $request->kecamatan,
                'kota'             => $request->kota,
                'no_telp'          => $request->no_telp,
                'no_fax'           => $request->no_fax,
                'website'          => $request->website
            ];

            \App\DataAdministrasiBadanUsaha::where('id_detail_kta',$get_detail->id)->update($dataAdministrasiBu);

             $dataUser = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->join('t_pj_kta as tak','tdk.id','tak.id_detail_kta')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();

            return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_penanggung_jawab_turun',compact('dataUser'));
        } else {
            // dd('tes1');
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        
    }


    public function form_legalitas_turun(Request $request)
    {

        $validator = \Validator::make(Input::all(), [
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

        $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();

        if (!$validator->fails()) {
            $dataPjbu = [
                'id_detail_kta'    => $get_data->id,
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
            $update = \App\DataPenanggungJawabBadanUsaha::where('id_detail_kta',$get_data->id)
            ->update($dataPjbu);



            
            $dataUser = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->join('t_legalitas_kta as tak','tdk.id','tak.id_detail_kta')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
            // dd($dataUser);


            return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_legalitas_turun',compact('dataUser'));
            
        } else {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }



    }


    public function form_dokumen_pendukung_turun(Request $request)
    {

        $validator = \Validator::make(Input::all(), [
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
        
        $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();

        if (!$validator->fails()) {
            if ($request->has('no_akte_perubahan') || $request->has('no_sk_perubahan')) {
                $legalitasBu = [
                            
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

                if ($idLastLegalitas = DB::table('t_legalitas_kta')->where('id_detail_kta',$get_data->id)->update($legalitasBu)) {
                    if ($request->has('no_akte_perubahan')) {
                        for ($i=0; $i<count($request->no_akte_perubahan); $i++) {
                            $detailLegalitasAkte = [
                                    'id_legalitas_bu' => $idLastLegalitas,
                                    'no_akte_perubahan' => $request->no_akte_perubahan[$i],
                                    'nm_notaris_perubahan' => $request->nm_notaris_perubahan[$i],
                                    'tgl_akte_perubahan_keluar' => $request->tgl_akte_perubahan_keluar[$i],
                                    'maksud_tujuan_akte_perubahan' => $request->maksud_tujuan_akte_perubahan[$i]
                
                                ];
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasAkte);
                        }
                    }
                   
                    if ($request->has('no_sk_perubahan')) {
                        for ($x=0; $x<count($request->no_sk_perubahan); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $idLastLegalitas,
                                'no_sk_perubahan' =>$request->no_sk_perubahan[$x],
                                'tgl_sk_perubahan_keluar' => $request->tgl_sk_perubahan_keluar[$x]
                            ];
    
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasSk);
                        }
                    }


                    if ($request->has('nama_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasSk = [
                                'id_legalitas_bu' => $idLastLegalitas,
                                'nama_kbli' => $request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasSk);
                        }
                    }
                  

                    return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_pendukung_turun');
                } else {
                    return redirect()->route('anggota.naik_turun_kualifikasi.form_legalitas_turun');
                }
            } else {
                $legalitasBu = [
                    // 'id_detail_kta'       => Session::get('id_detail_kta'),
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

                if ($idLastLegalitas = \App\DataLegalitasBadanUsaha::where('id_detail_kta',$get_data->id)->update($legalitasBu)) {
                    if ($request->has('nama_kbli') && $request->has('no_kbli')) {
                        for ($x=0; $x<count($request->nama_kbli); $x++) {
                            $detailLegalitasKbli = [
                                'id_legalitas_bu' => $idLastLegalitas->id,
                                'nama_kbli' =>$request->nama_kbli[$x],
                                'no_kbli' => $request->no_kbli[$x]
                            ];
    
                            \App\DataDetailLegalitas::where('id_detail_kta',$get_data->id)->update($detailLegalitasKbli);
                        }
                    }

                    return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_pendukung_turun');
                } else {
                    return redirect()->route('anggota.naik_turun_kualifikasi.form_legalitas_turun');
                }
            }
        } else {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        // return view('backend/anggota/content-pages/naik_turun_kualifikasi.form_pendukung_turun');
    }


    public function action_turun_kualifikasi(Request $request)
    {

        $validator = \Validator::make(Input::all(), [
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
                
            ]);

          $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();
        
        if (!$validator->fails()) 
        {
            if ($request->hasFile('file_ktp_pjbu')) {
                $file_ktp_pjbu                     = $request->file('file_ktp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_npwp_pjbu')) {
                $file_npwp_pjbu                    = $request->file('file_npwp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            }
            if ($request->hasFile('file_foto_pjbu')) {
                $name_foto_pjbu                   = Uuid::uuid4().'.'.$request->file_foto_pjbu->getClientOriginalExtension();
                $file_foto_pjbu                   = \Image::make($request->file_foto_pjbu)->resize(142, 169)->save(public_path('storage/legalitas-files/'.$name_foto_pjbu));
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
                

         
             \App\DataDokumenPendukungBadanUsaha::where('id_detail_kta',$get_data->id)->update([
                'id_detail_kta'                    => $get_data->id,
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
                // 'surat_permohonan_baru'            => substr($surat_permohonan_baru, 23),
                ]);


                \App\HistoryApprovalPengajuan::whereId_detail_kta($get_data->id)->update(['keterangan' => 'Dokumen anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.']);
                $user  = \App\DetailKta::with('kta')->whereId($get_data->id)->first();
                $council =  \App\UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                
                $notificationData = [
                    'id_dp' => $user->kta->id_dp,
                    'message' => 'Anda memiliki 1 edit data baru' 
                ];


                
                return redirect()->route('anggota.status.main')->with('successEdit', 'Berhasil melakukan registrasi anggota');
            
        } else {
            
               return redirect()->route('anggota.naik_turun_kualifikasi.form_dokumen_pendukung_turun')->withErrors($validator)
                ->withInput();
        }
    }

    
}


 