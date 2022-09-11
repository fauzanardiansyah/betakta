<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DetailKta;
use App\DataLegalitasBadanUsaha;
use Session;
use DB;

class FormUpdateAndExtendController extends Controller
{
    protected $idKta;

    public function formAdminstrasiBadanUsaha($idKta)
    {
        $this->idKta = $idKta;

        $dataUser = \App\RegistrationUsers::findOrFail(Session::get('id_registrasi_user'));
        $dataAdministrasiBu = \App\DataAdministrasiBadanUsaha::whereIn('id_detail_kta', function($query){
                                        $query->select('id')
                                        ->from(with(new \App\DetailKta)->getTable())
                                        ->where('id_kta', $this->idKta)
                                        ->orderBy('created_at','asc');
                                      })->orderBy('created_at', 'desc')->first();

  
        return view('backend/anggota/content-pages/members_update.formBadanUsaha', compact('dataUser', 'dataAdministrasiBu'));
    }

    public function formPenanggungJawabBadanUsaha($idKta)
    {
        $this->idKta = $idKta;

        $dataPJBU = \App\DataPenanggungJawabBadanUsaha::whereIn('id_detail_kta', function($query){
                                        $query->select('id')
                                        ->from(with(new \App\DetailKta)->getTable())
                                        ->where('id_kta', $this->idKta)
                                        ->orderBy('created_at','asc');
                                      })->first();


        return view('backend/anggota/content-pages/members_update.formPenanggungJawabBadanUsaha', compact('dataPJBU'));
    }

    public function formLegalitasBadanUsaha($idKta)
    {
        $this->idKta        = $idKta;
        $id_detail_kta      = DetailKta::where('id_kta', $this->idKta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta->id);
        $dataLegalitasBu    = $legalitasBu->with('details')->get();

        return view('backend/anggota/content-pages/members_update.formLegalitasBadanUsaha', compact('dataLegalitasBu'));
    }

    public function formDokumenPendukung($idKta)
    {
        $this->idKta = $idKta;
        $dataDokumenPendukung = \App\DataDokumenPendukungBadanUsaha::whereIn('id_detail_kta', function($query){
            $query->select('id')
            ->from(with(new \App\DetailKta)->getTable())
            ->where('id_kta', $this->idKta)
            ->orderBy('created_at','asc');
          })->select('*')->first();

          

        return view('backend/anggota/content-pages/members_update.formDokumenPendukung', compact('dataDokumenPendukung'));
    }
}
