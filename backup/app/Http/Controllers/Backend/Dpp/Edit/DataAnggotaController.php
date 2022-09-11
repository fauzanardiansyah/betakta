<?php

namespace App\Http\Controllers\Backend\Dpp\Edit;

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

class DataAnggotaController extends Controller
{
  
    public function editAnggota($id_detail_kta)
    {
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataLegalitasBu    = (!is_null($legalitasBu)) ? $legalitasBu->with('details')->get() : abort(404);
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();
        $akun               = DB::table('t_detail_kta')
                                  ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                                  ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                                  ->select('t_registrasi_users.*')
                                  ->where('t_detail_kta.id', '=', $id_detail_kta)
                                  ->first();
                                  

        return view('backend/dpp/content-pages/master-anggota.form-edit-data-anggota', compact('dataAdministrasiBu', 'dataPjbu', 'dataLegalitasBu', 'dataDokumenBu', 'dataDokumen', 'dataPemberhentian', 'akun'));
    }

    public function updateAdministrasiAnggota(Request $request)
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

            $updateDataBu = DataAdministrasiBadanUsaha::where('id', $request->id_form_administrasi_bu)->update($dataAdministrasiBu);
            
            if ($updateDataBu) {
                return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])->with('successUpdate', 'Data Administrasi Badan Usaha Berhasil Di Perbaharui');
            }
        } else {
            return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
            ->withErrors($validator)
            ->withInput();
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

            $updatePjbu = DataPenanggungJawabBadanUsaha::where('id', $request->id_form_pjbu)->update($dataPjbu);

            if ($updatePjbu) {
                return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])->with('successUpdate', 'Data Penanggung Jawab Badan Usaha Berhasil Di Perbaharui');
            }
        } else {
            return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
            ->withErrors($validator)
            ->withInput();
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

            'no_skdp'               => 'required',
            'penerbit_skdp'         => 'required',
            'tgl_keluar_skdp'       => 'required',
            'masa_berlaku_skdp'     => 'required',

            'no_siup'            => 'required',
            'penerbit_siup'      => 'required',
            'tgl_keluar_siup'    => 'required',
            'masa_berlaku_siup'  => 'required',

            'no_tdp'           => 'required',
            'penerbit_tdp'     => 'required',
            'tgl_keluar_tdp'   => 'required',
            'masa_berlaku_tdp' => 'required',

            'no_nib'             => 'required',
            'tgl_keluar_nib'     => 'required',
          

        ]);

        if (!$validator->fails()) {
            if ($request->has('no_akte_perubahan') || $request->has('no_sk_perubahan')) {
                $legalitasBu = [
                            'no_akte'          => $request->no_akte,
                            'nm_notaris'       => $request->nm_notaris,
                            'tgl_keluar_akte'  => $request->tgl_keluar_akte,
        
                
                            'no_sk_pendirian'          => $request->no_sk_pendirian,
                            // 'penerbit_sk_pendirian'    => $request->penerbit_sk_pendirian,
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
                            // 'penerbit_nib'     => $request->penerbit_nib,
                            'tgl_keluar_nib'   => $request->tgl_keluar_nib,
                            // 'masa_berlaku_nib' => $request->masa_berlaku_nib,
                        ];

                      

                        
                $updateDataBu = DataLegalitasBadanUsaha::where('id', $request->id_form_legalitas_bu)->first();
                        
                       
                if ($updateDataBu->update($legalitasBu)) {
                    if ($request->has('no_akte_perubahan')) {
                        for ($i=0; $i<count($request->no_akte_perubahan); $i++) {
                            $detailLegalitasAkte = [
                                    'id_legalitas_bu' => $updateDataBu->id,
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
                                'id_legalitas_bu' => $updateDataBu->id,
                                'no_sk_perubahan' =>$request->no_sk_perubahan[$x],
                                'penerbit_sk_perubahan' => $request->penerbit_sk_perubahan[$x],
                                'tgl_sk_perubahan_keluar' => $request->tgl_sk_perubahan_keluar[$x]
                            ];
    
                            \App\DataDetailLegalitas::insert($detailLegalitasSk);
                        }
                    }
                

                    return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                         ->with('successUpdate', 'Data Legalitas Badan Usaha Berhasil Di Perbaharui');
                } else {
                    return redirect()
                          ->back()
                          ->with('failedUpdate', 'Data Legalitas Badan Usaha Gagal Di Perbaharui');
                }
            } else {
                $legalitasBu = [
        
                    'no_akte'                   => $request->no_akte,
                    'nm_notaris'              => $request->nm_notaris,
                    'tgl_keluar_akte'       => $request->tgl_keluar_akte,

                    'no_sk_pendirian'              => $request->no_sk_pendirian,
                    // 'penerbit_sk_pendirian'     =>$request->penerbit_sk_pendirian,
                    'tgl_sk_pendirian_keluar'  =>$request->tgl_sk_pendirian_keluar,

                    'no_skdp'                  =>$request->no_skdp,
                    'penerbit_skdp'         => $request->penerbit_skdp,
                    'tgl_keluar_skdp'      =>$request->tgl_keluar_skdp,
                    'masa_berlaku_skdp'   =>$request->masa_berlaku_skdp,
        
                    'no_siup'         =>$request->no_siup,
                    'penerbit_siup'         =>$request->penerbit_siup,
                    'tgl_keluar_siup'         => $request->tgl_keluar_siup,
                    'masa_berlaku_siup'         => $request->masa_berlaku_siup,
        
                    'no_tdp'         => $request->no_tdp,
                    'penerbit_tdp'         =>$request->penerbit_tdp,
                    'tgl_keluar_tdp'         =>$request->tgl_keluar_tdp,
                    'masa_berlaku_tdp'         => $request->masa_berlaku_tdp,
        
                    'no_nib'         => $request->no_nib,
                    // 'penerbit_nib'         => $request->penerbit_nib,
                    'tgl_keluar_nib'         =>$request->tgl_keluar_nib,
                    // 'masa_berlaku_nib'         => $request->masa_berlaku_nib,
                ];

                $updateDataBu = DataLegalitasBadanUsaha::where('id', $request->id_form_legalitas_bu)->first();
              
                if ($updateDataBu->update($legalitasBu)) {
                    return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                         ->with('successUpdate', 'Data Legalitas Badan Usaha Berhasil Di Perbaharui');
                } else {
                    return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                          ->with('failedUpdate', 'Data Legalitas Badan Usaha Gagal Di Perbaharui');
                }
            }
        } else {
            return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
            ->withErrors($validator)
            ->withInput();
        }
    }
    
    public function dokumenPendukung(Request $request)
    {
        $dataDokumen = DataDokumenPendukungBadanUsaha::where('id_detail_kta', $request->id_detail_kta)->first();
        $validator = Validator::make(Input::all(), [
                'file_ktp_pjbu'                   => 'file|mimes:pdf|max:2048',
                'file_npwp_pjbu'                  => 'file|mimes:pdf|max:2048',
                'file_foto_pjbu'                  => 'file|mimes:jpeg,jpg|max:2048',
                'file_npwp_bu'                    => 'file|mimes:pdf|max:2048',
                'file_ijazah_pjbu'                => 'file|mimes:pdf|max:2048',
                'file_akte_pendirian_perubahan_bu'=> 'file|mimes:pdf|max:8048',
                'file_sk_pendirian_perubahan_bu'  => 'file|mimes:pdf|max:8048',
                'file_skdp_bu'                    => 'file|mimes:pdf|max:2048',
                'file_siup'                       => 'file|mimes:pdf|max:2048',
                'file_tdp'                        => 'file|mimes:pdf|max:2048',
                'file_nib'                        => 'file|mimes:pdf|max:2048',
                'file_kta'                        => 'file|mimes:pdf|max:2048',
                'surat_permohonan_baru'           => 'file|mimes:pdf|max:2048',
                'surat_permohonan_daftar_ulang'   => 'file|mimes:pdf|max:2048',
                'surat_permohonan_perpanjang'     => 'file|mimes:pdf|max:2048',
                'dokumen_pemberhentian'           => 'file|mimes:pdf|max:2048',
                
            ]);
    
        if (!$validator->fails()) {
            
            if($request->hasFile('file_ktp_pjbu')):
            $file_ktp_pjbu                     = $request->file('file_ktp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_npwp_pjbu')):
            $file_npwp_pjbu                    = $request->file('file_npwp_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_foto_pjbu')):
            $name_foto_pjbu                    = Uuid::uuid4().'.'.$request->file_foto_pjbu->getClientOriginalExtension();
            $file_foto_pjbu                    = Image::make($request->file_foto_pjbu)->resize(142, 169)->save(public_path('storage/legalitas-files/'.$name_foto_pjbu));
            endif;
            if($request->hasFile('file_npwp_bu')):
            $file_npwp_bu                      = $request->file('file_npwp_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_ijazah_pjbu')):
            $file_ijazah_pjbu                  = $request->file('file_ijazah_pjbu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_akte_pendirian_perubahan_bu')):
            $file_akte_pendirian_perubahan_bu  = $request->file('file_akte_pendirian_perubahan_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_sk_pendirian_perubahan_bu')):
            $file_sk_pendirian_perubahan_bu    = $request->file('file_sk_pendirian_perubahan_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_skdp_bu')):
            $file_skdp_bu                      = $request->file('file_skdp_bu')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_siup')):
            $file_siup                         = $request->file('file_siup')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_tdp')):
            $file_tdp                          = $request->file('file_tdp')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_nib')):
            $file_nib                          = $request->file('file_nib')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            if($request->hasFile('file_kta')):
            $file_kta                          = $request->file('file_kta')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;   
            
            if($request->hasFile('surat_permohonan_baru')):
                $surat_permohonan_baru         = $request->file('surat_permohonan_baru')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;
            
            if($request->hasFile('surat_permohonan_daftar_ulang')):
                $surat_permohonan_daftar_ulang = $request->file('surat_permohonan_daftar_ulang')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;   

            if($request->hasFile('surat_permohonan_perpanjang')):
                $surat_permohonan_perpanjang   = $request->file('surat_permohonan_perpanjang')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;   

            if($request->hasFile('dokumen_pemberhentian')):
                $file_kdokumen_pemberhentianta = $request->file('dokumen_pemberhentian')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
            endif;   
                   
            $dataDokumenPendukung = [
                    'file_ktp_pjbu'                    => ($request->hasFile('file_ktp_pjbu')) ? substr($file_ktp_pjbu, 23) : $dataDokumen->file_ktp_pjbu,
                    'file_npwp_pjbu'                   => ($request->hasFile('file_npwp_pjbu')) ? substr($file_npwp_pjbu, 23): $dataDokumen->file_npwp_pjbu ,
                    'file_foto_pjbu'                   => ($request->hasFile('file_foto_pjbu')) ? $name_foto_pjbu : $dataDokumen->file_foto_pjbu ,
                    'file_npwp_bu'                     => ($request->hasFile('file_npwp_bu')) ? substr($file_npwp_bu, 23) : $dataDokumen->file_npwp_bu ,
                    'file_ijazah_pjbu'                 => ($request->hasFile('file_ijazah_pjbu')) ? substr($file_ijazah_pjbu, 23) : $dataDokumen->file_ijazah_pjbu ,
                    'file_akte_pendirian_perubahan_bu' => ($request->hasFile('file_akte_pendirian_perubahan_bu')) ? substr($file_akte_pendirian_perubahan_bu, 23) : $dataDokumen->file_akte_pendirian_perubahan_bu ,
                    'file_sk_pendirian_perubahan_bu'   => ($request->hasFile('file_sk_pendirian_perubahan_bu')) ? substr($file_sk_pendirian_perubahan_bu, 23) : $dataDokumen->file_sk_pendirian_perubahan_bu ,
                    'file_skdp_bu'                     => ($request->hasFile('file_skdp_bu')) ? substr($file_skdp_bu, 23) : $dataDokumen->file_skdp_bu,
                    'file_siup'                        => ($request->hasFile('file_siup')) ? substr($file_siup, 23) : $dataDokumen->file_siup ,
                    'file_tdp'                         => ($request->hasFile('file_tdp')) ? substr($file_tdp, 23) : $dataDokumen->file_tdp,
                    'file_nib'                         => ($request->hasFile('file_nib')) ? substr($file_nib, 23): $dataDokumen->file_nib,
                    'file_nib'                         => ($request->hasFile('file_nib')) ? substr($file_nib, 23): $dataDokumen->file_nib,
                    'file_kta'                         => ($request->hasFile('file_kta')) ? substr($file_kta, 23): $dataDokumen->file_kta,

                    'surat_permohonan_baru'            => ($request->hasFile('surat_permohonan_baru')) ? substr($surat_permohonan_baru, 23): $dataDokumen->surat_permohonan_baru,
                    'surat_permohonan_daftar_ulang'    => ($request->hasFile('surat_permohonan_daftar_ulang')) ? substr($surat_permohonan_daftar_ulang, 23): $dataDokumen->surat_permohonan_daftar_ulang,
                    'surat_permohonan_perpanjang'      => ($request->hasFile('surat_permohonan_perpanjang')) ? substr($surat_permohonan_perpanjang, 23): $dataDokumen->surat_permohonan_perpanjang,
                    'dokumen_pemberhentian'            => ($request->hasFile('dokumen_pemberhentian')) ? substr($dokumen_pemberhentian, 23): $dataDokumen->dokumen_pemberhentian,
                ];

            $file = DataDokumenPendukungBadanUsaha::where('id', $request->id_form_dokumen_bu)->first();
            if($file->update($dataDokumenPendukung)) {
                return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                ->with('successUpdate', 'Data Dokumen Badan Usaha Berhasil Di Perbaharui');
                } else {
                    return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                            ->with('failedUpdate', 'Data Dokumen Badan Usaha Gagal Di Perbaharui');
           }

        } else {
            return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                ->withErrors($validator)
                ->withInput()
                ->with('failedUpdate', 'Data Dokumen Badan Usaha Gagal Di Perbaharui');
        }
    }

    public function accountAnggota(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'npwp_bu'   => 'required|string|max:30',
            'email_bu'  => 'required|string|max:100',
            'nm_bu'     => 'required|string|max:100',
            'bentuk_bu' => 'required|string',
            'status_bu' => 'required|string'
            
        ]);

        if ($validator->fails()) {
            return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
            ->withErrors($validator)
            ->withInput();
        } else {
            $dataUser = [
                'npwp_bu'   => $request->npwp_bu,
                'email_bu'  => $request->email_bu,
                'nm_bu'     => $request->nm_bu,
                'bentuk_bu' => $request->bentuk_bu,
                'status_bu' => $request->status_bu,
        
            ];

            $akun = RegistrationUsers::whereId($request->t_registrasi_users_id);
            if($akun->update($dataUser)) {  
     
                return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                       ->with('successUpdate', 'Berhasil Merubah Akun Anggota');
            } else {
                return redirect()->route('dpp.edit.documents', ['id_detail_kta' => $request->id_detail_kta])
                ->with('failedUpdate', 'Gagal Merubah Akun Anggota');
            }

            
        }
    }

}
