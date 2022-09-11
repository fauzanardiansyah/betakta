<?php

namespace App\Http\Controllers\Backend\Dpp\MasterAnggota;

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
        $dataLegalitasBu        = DataLegalitasBadanUsaha::with('details')->where('id_detail_kta', $id_detail_kta)->get();
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta', 't_kta.status_kta', 't_app_kta.*')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();



       
        return view('backend/dpp/content-pages/master-anggota.screening', compact('dataAdministrasiBu', 'dataPjbu', 'legalitasBu', 'dataLegalitasBu', 'dataDokumen', 'id_detail_kta'));
    }



    public function showDocumenPemberhentiantAnggota($id_detail_kta)
    {
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataLegalitasBu        = DataLegalitasBadanUsaha::with('details')->where('id_detail_kta', $id_detail_kta)->get();
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta', 't_app_kta.*')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();
        $dataPemberhentian = PemberhentianAnggota::where('id_detail_kta', $id_detail_kta)->first();
    
        return view('backend/dpp/content-pages/master-anggota.screening-pemberhentian', compact('dataAdministrasiBu', 'dataPjbu', 'dataLegalitasBu', 'dataDokumen', 'dataPemberhentian','id_detail_kta'));
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


    public function showDocumentPindahAnggota($id_detail_kta)
    {
        // dd('tes');
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataLegalitasBu        = DataLegalitasBadanUsaha::with('details')->where('id_detail_kta', $id_detail_kta)->get();

        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta','t_detail_kta.surat_permohonan','t_app_kta.*')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();

                                // dd($dataDokumen);
    
        return view('backend/dpp/content-pages/master-anggota.screening_pindah', compact('dataAdministrasiBu', 'dataPjbu', 'dataLegalitasBu', 'dataDokumen'));
    }

    public function downloadFileDocumentPindah($file_name)
    {
        $file_path = public_path('storage/pindah_dpp/'.$file_name);
        return response()->download($file_path);
    }



    public function showDocumentNaikKualifikasi($id_detail_kta)
    {
        
        $id_detail_kta      = $id_detail_kta;
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta);
        $dataLegalitasBu        = DataLegalitasBadanUsaha::with('details')->where('id_detail_kta', $id_detail_kta)->get();
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta', 't_kta.status_kta', 't_app_kta.*')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();


        return view('backend/dpp/content-pages/master-anggota.screening_naik_kualifikasi', compact('dataAdministrasiBu', 'dataPjbu', 'legalitasBu', 'dataLegalitasBu', 'dataDokumen', 'id_detail_kta'));
    }
    
    public function showDocumentTurunKualifikasi($id_detail_kta)
    {
        
        $id_detail_kta      = $id_detail_kta;
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta);
        $dataLegalitasBu        = DataLegalitasBadanUsaha::with('details')->where('id_detail_kta', $id_detail_kta)->get();
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta', 't_kta.status_kta', 't_app_kta.*')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();


        return view('backend/dpp/content-pages/master-anggota.screening_turun_kualifikasi', compact('dataAdministrasiBu', 'dataPjbu', 'legalitasBu', 'dataLegalitasBu', 'dataDokumen', 'id_detail_kta'));
    } 

    public function showDocumentEditData($id_detail_kta)
    {
        
        $id_detail_kta      = $id_detail_kta;
        $dataAdministrasiBu = DataAdministrasiBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $dataPjbu           = DataPenanggungJawabBadanUsaha::where('id_detail_kta', $id_detail_kta)->first();
        $legalitasBu        = DataLegalitasBadanUsaha::where('id_detail_kta', $id_detail_kta);
        $dataLegalitasBu        = DataLegalitasBadanUsaha::with('details')->where('id_detail_kta', $id_detail_kta)->get();
        $dataDokumen        = DB::table('t_dokumen_kta')
                                ->join('t_detail_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                                ->join('t_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->select('t_dokumen_kta.*', 't_kta.no_kta', 't_kta.status_kta', 't_app_kta.*')
                                ->where('t_dokumen_kta.id_detail_kta', '=', $id_detail_kta)
                                ->first();


        return view('backend/dpp/content-pages/master-anggota.screening_edit_data', compact('dataAdministrasiBu', 'dataPjbu', 'legalitasBu', 'dataLegalitasBu', 'dataDokumen', 'id_detail_kta'));
    }


}

