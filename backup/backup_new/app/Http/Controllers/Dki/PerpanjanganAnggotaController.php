<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerpanjanganAnggotaController extends Controller
{
    protected $id_kta;


    public function __construct()
    {
        $this->id_kta = Request()->input('id_kta');
    }

    public function administrasiBadanUsaha()
    {

        
        $dataAdministrasiBu = \App\DataAdministrasiBadanUsaha::whereIn('id_detail_kta', function($query){
                                        $query->select('id')
                                        ->from(with(new \App\DetailKta)->getTable())
                                        ->where('id_kta', $this->id_kta)
                                        ->orderBy('created_at','asc');
                                      })->orderBy('created_at', 'desc')->first();

        if($dataAdministrasiBu) {
            return response()->json([
                'data' => [
                    'administrasi_bu' => $dataAdministrasiBu
                ],
                'message' => 'Data form administrasi badan usaha',
                'status' => 200,
                'redirect' => [
                    'to' => 'Form edit penanggung jawab badan usaha',
                    'url' => route('perpanjangan.get.pj-bu', ['id_kta' => $this->id_kta])
                ]
            ], 200);
        }

        return response()->json([
            'data' => null,
            'message' => 'Data form administrasi badan usaha tidak di temukan',
            'status' => 404
        ], 404);

  
        
    }

    public function penanggungJawabBadanUsaha()
    {

        $dataPJBU = \App\DataPenanggungJawabBadanUsaha::whereIn('id_detail_kta', function($query){
                                        $query->select('id')
                                        ->from(with(new \App\DetailKta)->getTable())
                                        ->where('id_kta', $this->id_kta)
                                        ->orderBy('created_at','asc');
                                      })->first();
        if($dataPJBU) {
            return response()->json([
                'data' => $dataPJBU,
                'message' => 'Data form penanggung jawab badan usaha',
                'status' => 200,
                'redirect' => [
                    'to' => 'Form edit legalitas badan usaha',
                    'url' => route('perpanjangan.get.legalitas-bu', ['id_kta' => $this->id_kta])
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Data form penanggung jawab badan usaha tidak di temukan',
            'status' => 404
        ], 404);

    }

    public function formLegalitasBadanUsaha()
    {
        $id_detail_kta      = \App\DetailKta::where('id_kta', $this->id_kta)->first();

        if(!$id_detail_kta) {
            return response()->json([
                'message' => 'Data form legalitas badan usaha tidak di temukan',
                'status' => 404
            ], 404);
        }

        $legalitasBu        = \App\DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta->id);
        $dataLegalitasBu    = $legalitasBu->with('details')->get();

        if(count($dataLegalitasBu) > 0) {
            return response()->json([
                'data' => $dataLegalitasBu,
                'message' => 'Data form legalitas badan usaha',
                'status' => 200,
                'redirect' => [
                    'to' => 'Form edit dokumen pendukung badan usaha',
                    'url' => route('perpanjangan.get.dokumen-bu', ['id_kta' => $this->id_kta])
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Data form legalitas badan usaha tidak di temukan',
            'status' => 404
        ], 404);


    }

    public function formDokumenPendukung()
    {
        
        $dataDokumenPendukung = \App\DataDokumenPendukungBadanUsaha::whereIn('id_detail_kta', function($query){
            $query->select('id')
            ->from(with(new \App\DetailKta)->getTable())
            ->where('id_kta', $this->id_kta)
            ->orderBy('created_at','asc');
          })->select('*')->first();

          if($dataDokumenPendukung) {
            return response()->json([
                'data' => [
                    'id' => $dataDokumenPendukung->id,
                    'file_ktp_pjbu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_ktp_pjbu),
                    'file_foto_pjbu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_foto_pjbu),
                    'file_npwp_pjbu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_npwp_pjbu),
                    'file_ijazah_pjbu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_ijazah_pjbu),
                    'file_npwp_bu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_npwp_bu),
                    'file_akte_pendirian_perubahan_bu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_akte_pendirian_perubahan_bu),
                    'file_sk_pendirian_perubahan_bu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_sk_pendirian_perubahan_bu),
                    'file_skdp_bu' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_skdp_bu),
                    'file_siup' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_siup),
                    'file_tdp' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_tdp),
                    'file_nib' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_nib),
                    'file_kta' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_kta),
                    'surat_permohonan_baru' => asset('storage/legalitas-files/'. $dataDokumenPendukung->surat_permohonan_baru),
                    'surat_permohonan_perpanjang' => asset('storage/legalitas-files/'. $dataDokumenPendukung->surat_permohonan_perpanjang),
                    'surat_permohonan_daftar_ulang' => asset('storage/legalitas-files/'. $dataDokumenPendukung->surat_permohonan_daftar_ulang),
                    'dokumen_pemberhentian' => asset('storage/legalitas-files/'. $dataDokumenPendukung->dokumen_pemberhentian),
                    'file_siujk' => asset('storage/legalitas-files/'. $dataDokumenPendukung->file_siujk),
                    
                ],
                'message' => 'Data form dokumen pendukung badan usaha',
                'status' => 200,
            ], 200);
          }

          return response()->json([
            'message' => 'Data form dokumen pendukung badan usaha tidak di temukan',
            'status' => 404
        ], 404);
    }
}
