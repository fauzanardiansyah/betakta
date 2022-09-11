<?php

namespace App\Http\Controllers\Administrator\Dewan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use Validator;
use DB;
use Hash;

class DewanPengurusNasionalController extends Controller
{
    public function index()
    {
        return view('administrator/content-pages/dewan.dpn-administrator-page');
    }

    public function manageAccountDpn()
    {
        $data_dpn = DB::table('t_dp')
                ->where('level', 1)
                ->select('t_dp.*')
                ->first();
        $user_dpn = DB::table('t_users_dp')
            ->join('t_dp', 't_users_dp.id_dp', '=', 't_dp.id')
            ->where('t_dp.level', 1)
            ->select('t_users_dp.*')
            ->first();
            
        $pengurus = \App\DewanPengurus::with('provinsi')->get();
       
        if(is_null($data_dpn)) {
            return redirect()->back()->with('failedToFormDpnAccount', 'Isi data DPN terlebih dahulu');
           
        }
        return view('administrator/content-pages/dewan.manage-akun-dpn', compact('user_dpn', 'pengurus'));

        

       
    }

    public function manageDataDpn()
    {
        $data_dpn = \App\DewanPengurus::with('provinsi')->where('level', 1)->first();
        $provinsi = \App\Provinsi::all();
        return view('administrator/content-pages/dewan.manage-data-dpn', compact('data_dpn', 'provinsi'));
    }

    public function saveDataDpn(Request $request)
    {
        $data_dpn = \App\DewanPengurus::with('provinsi')->where('level', 1)->first();
        
        $validator = Validator::make($request->all(), [
            'no_rek'                    => 'required|numeric',
            'kode_bank'                 => 'required|numeric',
            'nm_rek'                    => 'required|string',
            'nm_bank'                   => 'required|string',
            'alamat'                    => 'required|string|max:500',
            'email_dewan_pengurus'      => 'required',
            'no_telp_dewan_pengurus'    => 'required|string',
            'iuran_1_thn_besar'         => 'required|numeric',
            'uang_pangkal'              => 'required|numeric',
            'foto_profile_dpn'          => 'file|mimes:jpeg,jpg|max:2048',
            'nm_ketum'                  => 'required|string',
            'nm_sekjen'                 => 'required|string',
            'ketua_bkka'                => 'required|string',
            'sekretaris_bkka'           => 'required|string',
            'ttd_ketum'                 => 'file|mimes:png,jpeg,jpg|max:2048',
            'ttd_sekjen'                => 'file|mimes:png,jpeg,jpg|max:2048',
            'ttd_ketua_bkka'            => 'file|mimes:png,jpeg,jpg|max:2048',
            'ttd_sekretaris_bkka'       => 'file|mimes:png,jpeg,jpg|max:2048',
            'no_rek_bkka'               => 'required|string',
            'nm_bank_bkka'              => 'required|string',
            'nm_rek_bkka'               => 'required|string',
        ]);

        $data_dpn_inputs = [
            'id_provinsi'               => $request->input('id_provinsi'),
            'level'                     => 1,
            'no_rek'                    => $request->input('no_rek'),
            'kode_bank'                 => $request->input('kode_bank'),
            'nm_rek'                    => $request->input('nm_rek'),
            'nm_bank'                   => $request->input('nm_bank'),
            'alamat'                    => $request->input('alamat'),
            'email_dewan_pengurus'      => $request->input('email_dewan_pengurus'),
            'no_telp_dewan_pengurus'    => $request->input('no_telp_dewan_pengurus'),
            'iuran_1_thn_besar'         => $request->input('iuran_1_thn_besar'),
            'uang_pangkal'              => $request->input('uang_pangkal'),
            'nm_ketum'                  => $request->input('nm_ketum'),
            'nm_sekjen'                 => $request->input('nm_sekjen'),
            'ketua_bkka'                => $request->input('ketua_bkka'),
            'sekretaris_bkka'           => $request->input('sekretaris_bkka'),
            'foto_profile_dpn'          => ($request->hasFile('foto_profile_dpn') ? substr($request->file('foto_profile_dpn')->storeAs('public/profile-dpn', Uuid::uuid4().'.jpg'), 19) : $data_dpn->foto_profile_dpn),
            'ttd_ketum'                 => ($request->hasFile('ttd_ketum') ? substr($request->file('ttd_ketum')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $data_dpn->ttd_ketum),
            'ttd_sekjen'                => ($request->hasFile('ttd_sekjen') ? substr($request->file('ttd_sekjen')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $data_dpn->ttd_sekjen),
            'ttd_ketua_bkka'            => ($request->hasFile('ttd_ketua_bkka') ? substr($request->file('ttd_ketua_bkka')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $data_dpn->ttd_ketua_bkka),
            'ttd_sekretaris_bkka'       => ($request->hasFile('ttd_sekretaris_bkka') ? substr($request->file('ttd_sekretaris_bkka')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $data_dpn->ttd_sekretaris_bkka),
            'no_rek_bkka'               => $request->input('no_rek_bkka'),
            'nm_bank_bkka'              => $request->input('nm_bank_bkka'),
            'nm_rek_bkka'               => $request->input('nm_rek_bkka'),
        ];


        if (!$validator->fails()) {
            $user_dpn = DB::table('t_users_dp')
            ->join('t_dp', 't_users_dp.id_dp', '=', 't_dp.id')
            ->where('t_dp.level', 1)
            ->select('t_users_dp.*')
            ->first();

            if(!empty($user_dpn)) {
                $update_data_dpn = \App\DewanPengurus::where('id', $data_dpn->id)->update($data_dpn_inputs);
            } else {
                $add_data_dpn = \App\DewanPengurus::create($data_dpn_inputs);
            }
            
            if ($update_data_dpn or $add_data_dpn) {
                return redirect()->back()->with('successUpdateDataDpn', 'Data dewan pengurus berhasil di perbaharui');
            } else {
                return redirect()->back()->with('faildUpdateDataDpn', 'Data dewan pengurus gagal di perbaharui');
            }
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }


    public function saveAccountDpn(Request $request)
    {
        $data_akun_dpn  = DB::table('t_users_dp')
                                ->join('t_dp', 't_users_dp.id_dp', '=', 't_dp.id')
                                ->where('t_dp.level', 1)
                                ->select('t_users_dp.*')
                                ->first();

        if (!empty($request->password)) {
            $validator = Validator::make($request->all(), [
                'id_dp'                  => 'required|numeric',
                'npwp_pengurus'          => 'required|string',
                'email_pengurus'         => 'required|email|max:30',
                'password'               => 'required|confirmed|min:6',
                'password_confirmation'  => 'required_with:password|min:6|max:100'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'id_dp'                  => 'required|numeric',
                'npwp_pengurus'          => 'required|string',
                'email_pengurus'         => 'required|email|max:30',
            ]);
        }
        

        if (! $validator->fails()) {
            $data_akun_inputs = [
                'id_dp'               => $request->input('id_dp'),
                'npwp_pengurus'       => $request->input('npwp_pengurus'),
                'email_pengurus'      => $request->input('email_pengurus'),
                'password'            => Hash::make($request->input('password')),
            ];

                               
            if (empty($data_akun_dpn)) {
                $simpan_akun_dpn = \App\UsersDppDpn::create($data_akun_inputs);
                if ($simpan_akun_dpn) {
                    return redirect()->back()->with('successSaveAccountDpn', 'Akun dewan pengurus berhasil di tambah');
                }
                return redirect()->back()->with('failedSaveAccountDpn', 'Akun dewan pengurus berhasil di tambah');
            } else {
                $data_akun_dpn_update  = DB::table('t_users_dp')
                                ->join('t_dp', 't_users_dp.id_dp', '=', 't_dp.id')
                                ->where('t_dp.level', 1);
                if ($data_akun_dpn_update->update($data_akun_inputs)) {
                    return redirect()->back()->with('successUpdateAccountDpn', 'Akun dewan pengurus berhasil di tambah');
                }

                return redirect()->back()->with('failedUpdateAccountDpn', 'Akun dewan pengurus berhasil di tambah');
            }
        } else {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
    }
}
