<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;


class ReRegistrationController extends Controller
{
    public function index()
    {
        $allDPP = DB::table('t_dp')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->select('t_dp.id', 'provinsi.name')
            ->orderBy('t_dp.id', 'DESC')
            ->get();

        return view('backend/anggota/content-pages/re-registration.registration-page', compact('allDPP'));
    }

    public function formAdminstrasiBadanUsaha()
    {
        $dataUser = \App\RegistrationUsers::findOrFail(Session::get('id_registrasi_user'));
        
        return view('backend/anggota/content-pages/re-registration.formBadanUsaha', compact('dataUser'));
    }

    public function formPenanggungJawabBadanUsaha()
    {
        return view('backend/anggota/content-pages/re-registration.formPenanggungJawabBadanUsaha');
    }

    public function formLegalitasBadanUsaha()
    {
        return view('backend/anggota/content-pages/re-registration.formLegalitasBadanUsaha');
    }

    public function formDokumenPendukung()
    {
        return view('backend/anggota/content-pages/re-registration.formDokumenPendukung');
    }
}
