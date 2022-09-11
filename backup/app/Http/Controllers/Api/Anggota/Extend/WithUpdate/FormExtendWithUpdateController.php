<?php

namespace App\Http\Controllers\Api\Anggota\Extend\WithUpdate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DetailKta;
use App\DataLegalitasBadanUsaha;
use DB;

class FormExtendWithUpdateController extends Controller
{
    protected $idKta;

    public function formAdminstrasiBadanUsaha($idKta, $id_registrasi_user)
    {
        $this->idKta = $idKta;

        $dataUser = \App\RegistrationUsers::findOrFail($id_registrasi_user);
        $dataAdministrasiBu = \App\DataAdministrasiBadanUsaha::whereIn('id_detail_kta', function($query){
                                        $query->select('id')
                                        ->from(with(new \App\DetailKta)->getTable())
                                        ->where('id_kta', $this->idKta)
                                        ->orderBy('created_at','asc');
                                      })->orderBy('created_at', 'desc')->first();

        if($dataUser && $dataAdministrasiBu) {
            return response()->json([
                'data_user' => $dataUser,
                'data_administrasi_bu' =>  $dataAdministrasiBu,
                'message' => 'Data form administrasi badan usaha',
                'status' => 200,
                'redirect' => [
                    'to' => 'Form edit penanggung jawab badan usaha',
                    'url' => route('api.extend.form-pjbu', ['id_kta' => $idKta, 'id_registrasi_user' => $id_registrasi_user])
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Data form administrasi badan usaha tidak di temukan',
            'status' => 404
        ], 404);

  
        
    }

    public function formPenanggungJawabBadanUsaha($idKta, $id_registrasi_user)
    {
        $this->idKta = $idKta;

        $dataPJBU = \App\DataPenanggungJawabBadanUsaha::whereIn('id_detail_kta', function($query){
                                        $query->select('id')
                                        ->from(with(new \App\DetailKta)->getTable())
                                        ->where('id_kta', $this->idKta)
                                        ->orderBy('created_at','asc');
                                      })->first();
        if($dataPJBU) {
            return response()->json([
                'data' => $dataPJBU,
                'message' => 'Data form penanggung jawab badan usaha',
                'status' => 200,
                'redirect' => [
                    'to' => 'Form edit legalitas badan usaha',
                    'url' => route('api.extend.form-legality', ['id_kta' => $idKta, 'id_registrasi_user' => $id_registrasi_user])
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Data form penanggung jawab badan usaha tidak di temukan',
            'status' => 404
        ], 404);


        
    }

    public function formLegalitasBadanUsaha($idKta, $id_registrasi_user)
    {
        $this->idKta        = $idKta;
        $id_detail_kta      = DetailKta::where('id_kta', $this->idKta)->first();

        if(!$id_detail_kta) {
            return response()->json([
                'message' => 'Data form legalitas badan usaha tidak di temukan',
                'status' => 404
            ], 404);
        }

        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta->id);
        $dataLegalitasBu    = $legalitasBu->with('details')->get();

        if(count($dataLegalitasBu) > 0) {
            return response()->json([
                'data' => $dataLegalitasBu,
                'message' => 'Data form legalitas badan usaha',
                'status' => 200,
                'redirect' => [
                    'to' => 'Form edit dokumen pendukung badan usaha',
                    'url' => route('api.extend.form-documents', ['id_kta' => $idKta, 'id_registrasi_user' => $id_registrasi_user])
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Data form legalitas badan usaha tidak di temukan',
            'status' => 404
        ], 404);


    }

    public function formDokumenPendukung($idKta, $id_registrasi_user)
    {
        $this->idKta = $idKta;
        $dataDokumenPendukung = \App\DataDokumenPendukungBadanUsaha::whereIn('id_detail_kta', function($query){
            $query->select('id')
            ->from(with(new \App\DetailKta)->getTable())
            ->where('id_kta', $this->idKta)
            ->orderBy('created_at','asc');
          })->select('*')->first();

          if($dataDokumenPendukung) {
            return response()->json([
                'data' => $dataDokumenPendukung,
                'message' => 'Data form dokumen pendukung badan usaha',
                'status' => 200,
                'redirect' => [
                    'to' => 'Status pengajuan anggota',
                    'url' => route('api.status.get-status-member', ['id_registrasi_user' => $id_registrasi_user])
                ]
            ], 200);
          }

          return response()->json([
            'message' => 'Data form dokumen pendukung badan usaha tidak di temukan',
            'status' => 404
        ], 404);
    }
}
