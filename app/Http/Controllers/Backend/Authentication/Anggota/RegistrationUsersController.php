<?php

namespace App\Http\Controllers\Backend\Authentication\Anggota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Mail\ResetPasswordUser;
use App\RegistrationUsers;
use App\Jobs\SendActivationEmail as SendActivationEmail;
use App\Jobs\SendResetPasswordMail;
use Hash;
use DB;
use Session;
use ReCaptcha;

class RegistrationUsersController extends Controller
{
    
    /**
     * Authentication page
     *
     */
    public function index()
    {
        return view('frontend/content-pages/authentication.login-anggota');
    }

    /**
     * Registration page
     *
     */
    public function registrationPage()
    {
        return view('frontend/content-pages/authentication.registration-anggota');
    }

    /**
     * Forgot password page
     *
     */
    public function forgotPasswordPage()
    {
        return view('frontend/content-pages/authentication.reset-password-anggota');
    }




    /**
     * Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'npwp_email_bu'  => 'required', // make sure the email is an actual email
            'password' => 'required|min:6', // password can only be alphanumeric and has to be greater than 3 characters
            // 'g-recaptcha-response' => 'required|captcha',
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()->back()
            ->with('failValidationdLoginRegistrationUser', $validator->messages())
            ->withErrors($validator)
            ->withInput();
        } else {
            
            $user = DB::table('t_registrasi_users')
            ->select('id', 'email_bu', 'npwp_bu', 'password', 'nm_bu', 'email_verified_at')
            ->where('email_bu', $request->npwp_email_bu)
            ->orWhere('npwp_bu', $request->npwp_email_bu)
            ->first();

            if (!empty($user)) {
                if (Hash::check(Input::get('password'), $user->password)) {
                    if (!empty($user->email_verified_at)) {
                        Session::put('id_registrasi_user', $user->id);
                        Session::put('nm_bu', $user->nm_bu);
                        Session::put('email_bu', $user->email_bu);
                        Session::put('is_login_agt', true);
                        return redirect()->route('anggota.dashboard');
                    } else {
                        return redirect()->back()
                    ->with('failVerficationLoginRegistrationUser', 'Akun anda belum aktif');
                    }
                } else {
                    return redirect()->back()
                    ->with('failPasswordLoginRegistrationUser', 'Password Anda Salah');
                }
            } else {
                return redirect()->back()
                ->with('failEmailOrNpwpLoginRegistrationUser', 'Email / NPWP Tidak Di Temukan');
            }
        }
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npwp_bu' => 'required|max:21',
            'email_bu' => 'required|email|unique:t_registrasi_users|max:100',
            'nm_bu' => 'required|string|max:50',
            'bentuk_bu' => 'required|string',
            'status_bu' => 'required|string',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required_with:password|min:6|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->with('faildStoreRegistrationUser', $validator->messages())
            ->withErrors($validator)
            ->withInput();
        } else {
            $dataUser = [
                'npwp_bu'   => str_replace("-","",str_replace(".", "", $request->npwp_bu)),
                'email_bu'  => $request->email_bu,
                'nm_bu'     => strtoupper($request->nm_bu),
                'bentuk_bu' => $request->bentuk_bu,
                'status_bu' => $request->status_bu,
                'password'  => Hash::make($request->password),
                'remember_token' => str_random(50),
                'email_verified_at' => null
            ];
            if(RegistrationUsers::create($dataUser)) {
               
                dispatch(new SendActivationEmail($dataUser));
     
                return redirect('/')->with('sucsessStoreRegistrationUser', 'Silahkan ');
            }

            
        }
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        RegistrationUsers::where('remember_token', $id)
          ->update(['email_verified_at' => date('Y-m-d H:i:s')]);
        return redirect('/')->with('sucsessVerifyRegistrationUser', 'Silahkan ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendResetPasswordMail(Request $request)
    {
        $user = DB::table('t_registrasi_users')
                    ->where('email_bu', $request->npwp_email_bu)
                    ->orWhere('npwp_bu', $request->npwp_email_bu)
                    ->first();

        if(! empty($user)) {
            dispatch(new SendResetPasswordMail($user));
            return redirect('')->with('successSendResetPassword', 'Kami telah mengirimkan email untuk melakukan reset password');
        }

        return redirect()->back()->with('failSendResetPassword', 'Email / NPWP anda tidak terdapat di database kami');
    }
    

    public function formResetPassword($token)
    {
        $user = RegistrationUsers::whereRemember_token($token)->first();
        if(empty($user)) {
            abort(404);
        }
        return view('frontend/content-pages/authentication.form-reset-password', compact('user'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request, $token)
    {
        $rules = array(
            'password' => 'required|min:6'
        );
        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->fails()) {
            $reset = RegistrationUsers::where('remember_token', $token)
            ->update([
                'password' => Hash::make($request->password),
                'email_verified_at' => date('Y-m-d H:i:s')
                ]);

            if ($reset) {
                return redirect('/')->with('successResetPasswordRegistrationUsers', 'Password anda telah berhasiol di reset');
            } else {
                return redirect()->back()->with('faildResetPasswordRegistrationUsers', 'Email anda tidak ada dalam sistem kami');
            }
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}
