<?php

namespace App\Http\Controllers\Backend\Authentication\Dewan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use DB;
use Session;

class DpnAuthController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::has('is_login_dewan') === true) {
            return redirect()->route('dpp.dashboard');
        }
        return view('council-auth.dpn-login-page');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // validate the info, create rules for the inputs
         $rules = array(
            'npwp_email_pengurus'  => 'required', // make sure the email is an actual email
            'password' => 'required|min:6' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator);
        } else {
            $user = DB::table('t_users_dp')
            ->join('t_dp', 't_users_dp.id_dp', '=', 't_dp.id')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->select('t_users_dp.*', 'provinsi.name', 't_dp.level')
            ->where('npwp_pengurus', $request->npwp_email_pengurus)
            ->orWhere('email_pengurus', $request->npwp_email_pengurus)
            ->first();

         

            if (!empty($user)) {
                if (Hash::check(Input::get('password'), $user->password)) {
                    if($user->level == 1) {
                        Session::put('id_dp', $user->id_dp);
                        Session::put('nm_dpn', $user->name);
                        Session::put('email_pengurus', $user->email_pengurus);
                        Session::put('npwp_pengurus', $user->npwp_pengurus);
                        Session::put('is_login_dewan_pusat', true);
                        Session::put('level', $user->level);
                       return redirect()->route('dpn.dashboard');
                    } else {
                        return redirect()->back()
                    ->with('failPasswordLoginRegistrationUser', 'Maaf Akun Anda Bukan Pengurus Provinsi');
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
}
