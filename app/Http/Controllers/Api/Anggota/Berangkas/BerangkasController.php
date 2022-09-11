<?php

namespace App\Http\Controllers\Api\Anggota\Berangkas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BerangkasController extends Controller
{
    public function index($id_registrasi_user)
    {
        $dataDokumen = DB::table('t_dokumen_kta')
                         ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                         ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                         ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                         ->select('t_dokumen_kta.*', 't_kta.no_kta')
                         ->where('t_registrasi_users.id', '=', $id_registrasi_user)
                         ->orderBy('t_dokumen_kta.id', 'DESC')
                         ->limit(1)
                         ->first();
        
        if (!empty($dataDokumen)) {
            $data = [
                'data' => [
                    "id_detail_kta" => $dataDokumen->id_detail_kta,
                    "file_ktp_pjbu" => url('storage/legalitas-files/'. $dataDokumen->file_ktp_pjbu),
                    "file_foto_pjbu" => url('storage/legalitas-files/'. $dataDokumen->file_foto_pjbu),
                    "file_npwp_pjbu" => url('storage/legalitas-files/'. $dataDokumen->file_npwp_pjbu),
                    "file_ijazah_pjbu" => url('storage/legalitas-files/'. $dataDokumen->file_ijazah_pjbu),
                    "file_npwp_bu" => url('storage/legalitas-files/'. $dataDokumen->file_npwp_bu),
                    "file_akte_pendirian_perubahan_bu" => url('storage/legalitas-files/'. $dataDokumen->file_akte_pendirian_perubahan_bu),
                    "file_sk_pendirian_perubahan_bu" => url('storage/legalitas-files/'. $dataDokumen->file_sk_pendirian_perubahan_bu),
                    "file_skdp_bu" => url('storage/legalitas-files/'. $dataDokumen->file_skdp_bu),
                    "file_siup" => url('storage/legalitas-files/'. $dataDokumen->file_siup),
                    "file_tdp" => url('storage/legalitas-files/'. $dataDokumen->file_tdp),
                    "file_nib" => url('storage/legalitas-files/'. $dataDokumen->file_nib),
                    "file_kta" => url('storage/legalitas-files/'. $dataDokumen->file_kta),
                    "surat_permohonan_baru" => url('storage/legalitas-files/'. $dataDokumen->surat_permohonan_baru),
                    "surat_permohonan_perpanjang" => url('storage/legalitas-files/'. $dataDokumen->surat_permohonan_perpanjang),
                    "surat_permohonan_daftar_ulang" => url('storage/legalitas-files/'. $dataDokumen->surat_permohonan_daftar_ulang),
                    "no_kta" => $dataDokumen->no_kta
                ],
                'message' => 'Data dokumen anggota',
                'status' => 200
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Data dokumen anggota tidak di temukan',
                'status' => 404
            ];

            return response()->json($data, 404);
        }
    }
}
