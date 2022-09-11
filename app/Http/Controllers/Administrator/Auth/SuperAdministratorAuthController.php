<?php

namespace App\Http\Controllers\Administrator\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SuperAdmin;
use Validator;
use Session;
use Hash;


class SuperAdministratorAuthController extends Controller
{
    public function index()
    {
        return view('council-auth.admin-login-page');
    }

    public function login(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'  => 'required', // make sure the email is an actual email
            'password' => 'required|min:6' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator);
        } else {
            $super_admin = SuperAdmin::whereEmail($request->email)->first();
         

            if (!empty($super_admin)) {
                if (Hash::check($request->input('password'), $super_admin->password)) {
                        Session::put('id_admin', $super_admin->id);
                        Session::put('nama_admin', $super_admin->nama_admin);
                        Session::put('email', $super_admin->email);
                        Session::put('is_login_super_admin', true);
                        
                       return redirect()->route('administrator.dashboard.main');
                 
                       
                } else {
                    return redirect()->back()
                    ->with('failPasswordLogin', 'Password Anda Salah');
                }
            } else {
                return redirect()->back()
                ->with('failEmailLogin', 'Email Tidak Di Temukan');
            }
        }
    }

    public function destroy(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('admin.auth');
    }
}
