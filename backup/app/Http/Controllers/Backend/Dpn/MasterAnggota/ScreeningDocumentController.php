<?php

namespace App\Http\Controllers\Backend\Dpn\MasterAnggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataAdministrasiBadanUsaha;
use App\DataPenanggungJawabBadanUsaha;
use App\DataLegalitasBadanUsaha;
use App\DataDetailLegalitas;
use App\PemberhentianAnggota;
use Session;
use DB;

class ScreeningDocumentController extends Controller
{
    public function showDocumentAnggotaBaru($id_detail_kta)
    {
        $id_detail_kta      = $id_detail_kta;
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta);
        $dataLegalitasBu    = $legalitasBu->with('details')->get();
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta', 't_kta.jenis_bu', 't_kta.status_kta',  't_app_kta.*')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();
       
        return view('backend/dpn/content-pages/master-anggota.screening', compact('dataAdministrasiBu', 'dataPjbu', 'dataLegalitasBu', 'dataDokumenBu', 'dataDokumen', 'dataPemberhentian', 'id_detail_kta'));
    }


    public function showDocumenPemberhentiantAnggota($id_detail_kta)
    {
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataLegalitasBu    = $legalitasBu->with('details')->get();
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();
        $dataPemberhentian = PemberhentianAnggota::where('id_detail_kta', $id_detail_kta)->first();
    
        return view('backend/dpn/content-pages/master-anggota.screening-pemberhentian', compact('dataAdministrasiBu', 'dataPjbu', 'dataLegalitasBu', 'dataDokumenBu', 'dataDokumen', 'dataPemberhentian'));
    }


    public function downloadFileDocument($file_name)
    {
        $file_path = public_path('storage/legalitas-files/'.$file_name);
        return response()->download($file_path);
    }

    public function downloadFileDocumentPemberhentian($file_name)
    {
        $file_path = public_path('storage/dokumen-pemberhentian/'.$file_name);
        return response()->download($file_path);
    }
}
