<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\RegistrationUsers;
use Ramsey\Uuid\Uuid;
use Session;
use Validator;
use Image;
use Hash;


class ProfileController extends Controller
{

    protected $path;

    public function __construct()
    {
        //DEFINISIKAN PATH
        $this->path = storage_path('app/public/logo-badan-usaha');
    }


    public function index()
    {
        $dataRegistrasiUser = RegistrationUsers::findOrFail(Session::get('id_registrasi_user'));
        
        return view('backend/anggota/content-pages/profile.profile-page', compact('dataRegistrasiUser'));
    }

    public function uploadProfilePicture(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'foto_profile'  => 'required|file|mimes:png,jpg,jpeg,svg|max:2048'
        ]);

        if(!$validator->fails()) {
            
            
            $filename = Uuid::uuid4().'.'.$request->foto_profile->getClientOriginalExtension();

            $file_foto_profile = Image::make($request->foto_profile)->resize(100, 100)->save(public_path('storage/logo-badan-usaha/'.$filename));
            
            $registrasiUser = RegistrationUsers::find(Session::get('id_registrasi_user'));

            $registrasiUser->foto_profile = $filename;
            

            if($registrasiUser->save() == true)  {
                $request->session()->forget('foto_profile');
                Session::put('foto_profile', $registrasiUser);
                return redirect()->back();
            }
        } else {
            
            return redirect()->back()
            ->withErrors($validator);
           
        }
    }


    public function resetPassword(Request $request)
    {
        $rules = [
            'npwp_email_bu'         => 'required',
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required_with:password|min:6'
        ];
        
        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->fails()) {
            $reset = RegistrationUsers::where('email_bu', $request->npwp_email_bu)
            ->orWhere('npwp_bu', $request->npwp_email_bu)
            ->update(['password' => Hash::make($request->password)]);

            if ($reset) {
                return redirect('panel/anggota/profile-badan-usaha#reset-password')
                ->with('successResetPasswordRegistrationUsers', 'Password anda telah berhasiol di reset');
            } else {
                return redirect('panel/anggota/profile-badan-usaha?fail')
                ->with('faildResetPasswordRegistrationUsers', 'Email/NPWP anda tidak ada dalam sistem kami');
            }
        } else {
            return redirect('panel/anggota/profile-badan-usaha#reset-password')
            ->withErrors($validator->messages());
           
        }
    }
}
