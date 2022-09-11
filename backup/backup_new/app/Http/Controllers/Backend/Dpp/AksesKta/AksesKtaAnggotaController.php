<?php

namespace App\Http\Controllers\Backend\Dpp\AksesKta;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kta;
use Validator;
use Session;

class AksesKtaAnggotaController extends Controller
{
    public function index()
    {
        return view('backend/dpp/content-pages/akses-kta.akses-kta-page');
    }

    public function getDataAnggota(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kta'  => 'required',
        ]);

        if(!$validator->fails()) {
            $dataAnggota = Kta::with('registrasiUsers')->where('no_kta', $request->no_kta)->first();
            if(!is_null($dataAnggota)) {
                return $dataAnggota;
            } else {
                return response()->json('Data Tidak Di Temukan', 422);
            }
            
        } else {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
    }

    public function enableKtaAccess(Request $request)
    {
        $no_kta = $request->no_kta;
        $dataAnggota = Kta::where('no_kta', $no_kta)
                       ->update(['status_penataran' => $request->status_penataran]);
        if($dataAnggota) {
            return response()->json('Akses telah di ubah untuk anggota ini', 200);
        } else {
            return response()->json('Anggota tidak di temukan', 422);
        }
        
    }
}
