<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataDokumenPendukungBadanUsaha;
use Session;
use DB;

class BerangkasController extends Controller
{
    /**
     * Berangkas page
     *
     * @return void
     */
    public function index()
    {
        $dataDokumen = DB::table('t_dokumen_kta')
                         ->join('t_detail_kta','t_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                         ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                         ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                         ->select('t_dokumen_kta.*', 't_kta.no_kta')
                         ->where('t_registrasi_users.id', '=', Session::get('id_registrasi_user'))
                         ->orderBy('t_dokumen_kta.id', 'DESC')
                         ->limit(1)
                         ->first();
                       
        return view('backend/anggota/content-pages/berangkas.main-berangkas', compact('dataDokumen'));
    }

    /**
     * Download the files member
     *
     * @param String $file_name
     * @return void
     */
    public function downloadFileDocument($file_name)
    {
        $file_path = public_path('storage/legalitas-files/'.$file_name);
        return response()->download($file_path);
    }

}
