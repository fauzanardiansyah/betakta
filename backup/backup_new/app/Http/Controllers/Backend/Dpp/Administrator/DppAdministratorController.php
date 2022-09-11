<?php

namespace App\Http\Controllers\Backend\Dpp\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\DewanPengurus;
use App\UsersDppDpn;
use Ramsey\Uuid\Uuid;
use App\Provinsi;
use Session;
use Validator;
use Hash;


class DppAdministratorController extends Controller
{
    
   protected $dpp; 


    public function index()
    {
        $dataCouncil = DewanPengurus::with('provinsi')->findOrfail(Session::get('id_dp'));
        $this->dpp = $dataCouncil; 
        $province    = Provinsi::all();
        return view('backend/dpp/content-pages/administrator.administrator-page', compact('dataCouncil', 'province')); 
    }

    public function saveDataPengurus(Request $request)
    {
        $dpp = DewanPengurus::with('provinsi')->findOrfail(Session::get('id_dp'));

        $validator = Validator::make($request->all(), [
            'no_rek'                    => 'required|numeric',
            'kode_bank'                 => 'required|numeric',
            'nm_rek'                    => 'required|string',
            'nm_bank'                   => 'required|string',
            'alamat'                    => 'required|string|max:500',
            'email_dewan_pengurus'      => 'required',
            'no_telp_dewan_pengurus'    => 'required|string',
            'iuran_1_thn_kecil'         => 'required|numeric',
            'iuran_1_thn_menengah'      => 'required|numeric',
            'iuran_1_thn_besar'         => 'required|numeric',
            'uang_pangkal'              => 'required|numeric',
            'role_share_iuran_kecil'    => 'required|numeric',
            'role_share_iuran_menengah' => 'required|numeric',
            'role_share_iuran_besar'    => 'required|numeric',
            'role_share_uang_pangkal'   => 'required|numeric',
            'nm_ketua_provinsi'         => 'required|string',
            'nm_sekretaris_provinsi'    => 'required|string',
            'foto_profile_dpp'          => 'file|mimes:jpeg,jpg|max:2048',
            'ttd_ketua_provinsi'        => 'file|mimes:png|max:2048',
            'ttd_sekretaris_provinsi'   => 'file|mimes:png|max:2048',
        ]);

        $dataDpp = [
            'no_rek'                    => $request->input('no_rek'),
            'kode_bank'                 => $request->input('kode_bank'),
            'nm_rek'                    => $request->input('nm_rek'),
            'nm_bank'                   => $request->input('nm_bank'),
            'alamat'                    => $request->input('alamat'),
            'email_dewan_pengurus'      => $request->input('email_dewan_pengurus'),
            'no_telp_dewan_pengurus'    => $request->input('no_telp_dewan_pengurus'),
            'iuran_1_thn_kecil'         => $request->input('iuran_1_thn_kecil'),
            'iuran_1_thn_menengah'      => $request->input('iuran_1_thn_menengah'),
            'iuran_1_thn_besar'         => $request->input('iuran_1_thn_besar'),
            'uang_pangkal'              => $request->input('uang_pangkal'),
            'role_share_iuran_kecil'    => $request->input('role_share_iuran_kecil'),
            'role_share_iuran_menengah' => $request->input('role_share_iuran_menengah'),
            'role_share_iuran_besar'    => $request->input('role_share_iuran_besar'),
            'role_share_uang_pangkal'   => $request->input('role_share_uang_pangkal'),
            'nm_ketua_provinsi'         => $request->input('nm_ketua_provinsi'),
            'nm_sekretaris_provinsi'    => $request->input('nm_sekretaris_provinsi'),
            'foto_profile_dpp'          => ($request->hasFile('foto_profile_dpp') ? substr($request->file('foto_profile_dpp')->storeAs('public/profile-dpp', Uuid::uuid4().'.jpg'), 19) : $dpp->ttd_ketua_provinsi),
            'ttd_ketua_provinsi'        => ($request->hasFile('ttd_ketua_provinsi') ? substr($request->file('ttd_ketua_provinsi')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpp->ttd_ketua_provinsi),
            'ttd_sekretaris_provinsi'   => ($request->hasFile('ttd_sekretaris_provinsi') ? substr($request->file('ttd_sekretaris_provinsi')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpp->ttd_sekretaris_provinsi),
            'uang_gedung'               => $request->input('uang_gedung')
        ];

        if(!$validator->fails()) {
            $updateDpp = DewanPengurus::whereId(Session::get('id_dp'))->update($dataDpp);
            if($updateDpp) {
                return redirect()->back()->with('successUpdateAdminDpp', 'Data dewan pengurus berhasil di perbaharui');
            } else {
                return redirect()->back()->with('faildUpdateAdminDpp', 'Data dewan pengurus gagal di perbaharui');
            }
            
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }


    public function resetPasswordDpp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required_with:password|min:6|max:100'
        ]);

        if(!$validator->fails()) {
            $resetPasswordDpp = UsersDppDpn::where('id_dp', Session::get('id_dp'))->update([
                'password' => Hash::make($request->input('password'))
            ]);
            if($resetPasswordDpp) {
                $message = [
                    'success' => 'Berhasil merubah password'
                ];
                return response()->json($message, 200);
            }
            $message = [
                'failed' => 'Gagal merubah password'
            ];
            return response()->json($message, 422);
           
        } else {

            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }


    }
}
