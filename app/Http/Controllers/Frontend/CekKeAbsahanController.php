<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;

class CekKeAbsahanController extends Controller
{
    public function checkToValidityMember(Request $request)
    {
         $validator = Validator::make(Input::all(), [
             'npwp_email_bu' => 'required'
         ]);

         if($validator->fails()) {

             return redirect()->back()
             ->with('failedCekKeAbsahan',  'The NPWP or Email Badan Usaha field must be fill');

         } else {

            $dataAnggota = DB::table('t_registrasi_users')
            ->join('t_kta', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
            ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
            ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
            ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
            ->select('t_kta.no_kta', 't_registrasi_users.nm_bu','t_registrasi_users.bentuk_bu', 't_registrasi_users.npwp_bu', 't_pj_kta.nm_pjbu', 't_administrasi_kta.alamat', 't_kta.jenis_bu', 't_kta.kualifikasi', 't_kta.status_kta')
            ->where('t_registrasi_users.npwp_bu', $request->npwp_email_bu)
            ->orWhere('t_registrasi_users.email_bu', $request->npwp_email_bu)
            ->orderBy('t_detail_kta.created_at', 'desc')
            ->first();
        
            if(empty($dataAnggota)) {
                return redirect()->route('front.home')
                ->with('failedEmailOrNpwpValidity',  'NPWP Atau Email Yang Anda Masukan Tidak Ada Dalam Database Kami');
            }
            return view('frontend/content-pages/keabsahan.keabsahan-page', compact('dataAnggota'));
         }
    }
}
