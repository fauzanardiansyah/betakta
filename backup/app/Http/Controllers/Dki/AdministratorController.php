<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ramsey\Uuid\Uuid;
use Validator;
use DB;

class AdministratorController extends Controller
{
    protected $dpp; 


    public function index()
    {
        $data_pengurus_provinsi = \App\DewanPengurus::with('provinsi')->find(Request()->input('id_dp')); 
        
        if(!empty($data_pengurus_provinsi)) {
            return response()->json([
                'data' => [
                    "id" => $data_pengurus_provinsi->id,
                    "id_provinsi" => $data_pengurus_provinsi->id_provinsi,
                    "no_rek" => $data_pengurus_provinsi->no_rek,
                    "nm_rek" => $data_pengurus_provinsi->nm_rek,
                    "kode_bank" => $data_pengurus_provinsi->kode_bank,
                    "nm_bank" => $data_pengurus_provinsi->nm_bank,
                    "iuran_1_thn_kecil" => $data_pengurus_provinsi->iuran_1_thn_kecil,
                    "iuran_1_thn_menengah" => $data_pengurus_provinsi->iuran_1_thn_menengah,
                    "iuran_1_thn_besar" => $data_pengurus_provinsi->iuran_1_thn_besar,
                    "uang_pangkal" => $data_pengurus_provinsi->uang_pangkal,
                    "role_share_iuran_kecil" => $data_pengurus_provinsi->role_share_iuran_kecil,
                    "role_share_iuran_menengah" => $data_pengurus_provinsi->role_share_iuran_menengah,
                    "role_share_iuran_besar" => $data_pengurus_provinsi->role_share_iuran_besar,
                    "role_share_uang_pangkal" => $data_pengurus_provinsi->role_share_uang_pangkal,
                    "nm_ketua_provinsi" => $data_pengurus_provinsi->nm_ketua_provinsi,
                    "nm_sekretaris_provinsi" => $data_pengurus_provinsi->nm_sekretaris_provinsi,
                    "ttd_ketua_provinsi" => asset('storage/signature/'.$data_pengurus_provinsi->ttd_ketua_provinsi),
                    "ttd_sekretaris_provinsi" => asset('storage/signature/'.$data_pengurus_provinsi->ttd_sekretaris_provinsi),
                    "foto_profile_dpp" => asset('storage/profile-dpp/'.$data_pengurus_provinsi->foto_profile_dpp),
                    "alamat" => $data_pengurus_provinsi->alamat,
                    "email_dewan_pengurus" => $data_pengurus_provinsi->email_dewan_pengurus,
                    "no_telp_dewan_pengurus" => $data_pengurus_provinsi->no_telp_dewan_pengurus,
                    "provinsi" => [
                        "id" => $data_pengurus_provinsi->provinsi->id,
                        "kd_provinsi" => $data_pengurus_provinsi->provinsi->kd_provinsi,
                        "name" => $data_pengurus_provinsi->provinsi->name,
                    ]
                ],
                'message' => 'Data pengurus provinsi',
                'status' => 200
            ], 200);
        }

        return response()->json([
            'data' => null,
            'message' => 'Data pengurus provinsi',
            'status' => 404
        ], 404);
    }

    public function updateDataPengurus(Request $request)
    {
        $data_pengurus_provinsi = \App\DewanPengurus::with('provinsi')->find($request->input('id_dp'));

        $validator = Validator::make($request->all(), [
            'no_rek'                    => 'required|numeric',
            'kode_bank'                 => 'required|numeric',
            'nm_rek'                    => 'required|string',
            'nm_bank'                   => 'required|string',
            'alamat'                    => 'required|string|max:500',
            'email_dewan_pengurus'      => 'required|string|max:100',
            'no_telp_dewan_pengurus'    => 'required|string|max:100',
            'iuran_1_thn_kecil'         => 'required|numeric',
            'iuran_1_thn_menengah'      => 'required|numeric',
            'iuran_1_thn_besar'         => 'required|numeric',
            'uang_pangkal'              => 'required|numeric',
            'role_share_iuran_kecil'    => 'required|numeric',
            'role_share_iuran_menengah' => 'required|numeric',
            'role_share_iuran_besar'    => 'required|numeric',
            'role_share_uang_pangkal'   => 'required|numeric',
            'nm_ketua_provinsi'         => 'required|string|max:100',
            'nm_sekretaris_provinsi'    => 'required|string|max:100',
            'foto_profile_dpp'          => 'file|mimes:jpeg,jpg|max:2048',
            'ttd_ketua_provinsi'        => 'file|mimes:png|max:2048',
            'ttd_sekretaris_provinsi'   => 'file|mimes:png|max:2048',
        ]);

        $data_dpp = [
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
            'ttd_sekretaris_provinsi'   => ($request->hasFile('ttd_sekretaris_provinsi') ? substr($request->file('ttd_sekretaris_provinsi')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpp->ttd_sekretaris_provinsi)
        ];

        if(!$validator->fails()) {
            $updateDpp = \App\DewanPengurus::whereId($request->input('id_dp'))->update($data_dpp);
            if($updateDpp) {
                return response()->json([
                    'data' => $data_dpp,
                    'message' => 'Berhasil melakukan update data DPP',
                    'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'data' => null,
                    'message' => 'Gagal melakukan update data DPP',
                    'status' => 400
                ], 400);
            }
            
        } else {
            return response()->json([
                'data' => $validator->errors(),
                'message' => 'Terjadi kesalahan',
                'status' => 400
            ], 400);
        }
    }
}
