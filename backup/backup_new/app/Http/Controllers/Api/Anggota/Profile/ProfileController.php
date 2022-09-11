<?php

namespace App\Http\Controllers\Api\Anggota\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RegistrationUsers;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use Validator;
use FIle;
use Image;
use Hash;

class ProfileController extends Controller
{
    public function index($id_registrasi_user)
    {
        $dataRegistrasiUser = RegistrationUsers::find($id_registrasi_user);
        
        if (!empty($dataRegistrasiUser)) {
            return response()->json([
                'data'    => [
                    'foto_profile' => $result = (!empty($dataRegistrasiUser->foto_profile) ? url('storage/logo-badan-usaha/'.$dataRegistrasiUser->foto_profile) : null)
                ],
                'message' => 'Foto profile anda',
                'status'  => 200,
            ], 200);
        }

        return response()->json([
            'message' => 'Gagal menampilkan Foto profile anda',
            'status'  => 404,
        ], 404);
    }


    public function uploadProfilePicture(Request $request, $id_registrasi_user)
    {
        $validator = Validator::make(Input::all(), [
            'foto_profile'  => 'required|file|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        if (!$validator->fails()) {
            $filename = Uuid::uuid4().'.'.$request->foto_profile->getClientOriginalExtension();

            $file_foto_profile = Image::make($request->foto_profile)->resize(100, 100)->save(public_path('storage/logo-badan-usaha/'.$filename));
            
            $registrasiUser = RegistrationUsers::find($id_registrasi_user);

            $registrasiUser->foto_profile = $filename;
            

            if ($registrasiUser->save() == true) {
                $data = [
                    'data' => $registrasiUser,
                    'message' => 'Berhasil merubah profile anda',
                    'status' => 200,
                    'redirect' => redirect()->route('api.profile.profile', ['id_registrasi_user' => $id_registrasi_user]),
                ];
    
                return response()->json($data, 200);
            }
        } else {
            return response()->json([
                'message' => 'Gagal merubah profile anda',
                'status' => 400,
                'return' => redirect()->route('api.profile.profile', ['id_registrasi_user' => $id_registrasi_user]),
            ], 400);
        }
    }
}
