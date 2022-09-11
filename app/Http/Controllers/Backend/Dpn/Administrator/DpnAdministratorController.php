<?php

namespace App\Http\Controllers\Backend\Dpn\Administrator;

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


class DpnAdministratorController extends Controller
{
    
   protected $dpn; 


    public function index()
    {
        $dataCouncil = DewanPengurus::with('provinsi')->findOrfail(Session::get('id_dp'));
        $this->dpn = $dataCouncil; 
        $province    = Provinsi::all();
        
        return view('backend/dpn/content-pages/administrator.administrator-page', compact('dataCouncil', 'province')); 
    }

    public function saveDataPengurus(Request $request)
    {
        $dpn = DewanPengurus::with('provinsi')->findOrfail(Session::get('id_dp'));

        $validator = Validator::make($request->all(), [
            'no_rek'                    => 'required|numeric',
            'kode_bank'                 => 'required|numeric',
            'nm_rek'                    => 'required|string',
            'alamat'                    => 'required|string|max:500',
            'email_dewan_pengurus'      => 'required',
            'no_telp_dewan_pengurus'    => 'required|string',
            'iuran_1_thn_kecil'         => 'numeric|nullable',
            'iuran_1_thn_menengah'      => 'numeric|nullable',
            'iuran_1_thn_besar'         => 'required|numeric',
            'uang_pangkal'              => 'required|numeric',
            'role_share_iuran_kecil'    => 'numeric|nullable',
            'role_share_iuran_menengah' => 'numeric|nullable',
            'role_share_iuran_besar'    => 'numeric|nullable',
            'role_share_uang_pangkal'   => 'numeric|nullable',
            'foto_profile_dpn'          => 'file|mimes:jpeg,jpg|max:2048',
            'ttd_ketum'                 => 'file|mimes:png|max:2048',
            'ttd_sekjen'                => 'file|mimes:png|max:2048',
            'ttd_ketua_bkka'            => 'file|mimes:png|max:2048',
            'ttd_sekretaris_bkka'       => 'file|mimes:png|max:2048',
        ]);

        $dataDpp = [
            'no_rek'                    => $request->input('no_rek'),
            'kode_bank'                 => $request->input('kode_bank'),
            'nm_rek'                    => $request->input('nm_rek'),
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
            'nm_ketum'                  => $request->input('nm_ketum'),
            'nm_sekjen'                 => $request->input('nm_sekjen'),
            'ketua_bkka'                => $request->input('ketua_bkka'),
            'sekretaris_bkka'           => $request->input('sekretaris_bkka'),
            'foto_profile_dpn'          => ($request->hasFile('foto_profile_dpn') ? substr($request->file('foto_profile_dpn')->storeAs('public/profile-dpn', Uuid::uuid4().'.jpg'), 19) : $dpn->foto_profile_dpn),
            'ttd_ketum'                 => ($request->hasFile('ttd_ketum') ? substr($request->file('ttd_ketum')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpn->ttd_ketum),
            'ttd_sekjen'                => ($request->hasFile('ttd_sekjen') ? substr($request->file('ttd_sekjen')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpn->ttd_sekjen),
            'ttd_ketua_bkka'            => ($request->hasFile('ttd_ketua_bkka') ? substr($request->file('ttd_ketua_bkka')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpn->ttd_ketua_bkka),
            'ttd_sekretaris_bkka'       => ($request->hasFile('ttd_sekretaris_bkka') ? substr($request->file('ttd_sekretaris_bkka')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpn->ttd_sekretaris_bkka),

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
