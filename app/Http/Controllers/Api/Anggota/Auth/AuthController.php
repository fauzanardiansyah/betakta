<?php

namespace App\Http\Controllers\Api\Anggota\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\MembersActivationMailApi;
use App\RegistrationUsers;
use App\Jobs\SendMembersActivationMailApi as SendMembersActivationMailApi;
use Ramsey\Uuid\Uuid;
use JWTAuth;
use Hash;
use DB;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = array(
            'email_bu'  => 'required',
            'password' => 'required|min:6'
        );

        
        $validator = Validator::make($request->all(), $rules);

        $credentials = request(['email_bu', 'password']);

       
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $user = DB::table('t_registrasi_users')
            ->select('id', 'email_bu', 'npwp_bu', 'password', 'nm_bu', 'email_verified_at')
            ->where('email_bu', $request->email_bu)
            ->first();

            if (!empty($user)) {
                if (Hash::check($request->input('password'), $user->password)) {
                    if (!empty($user->email_verified_at)) {
                        if (! $token = auth()->attempt($credentials)) {
                            return response()->json([
                            'error' => 'Unauthorized',
                            'status' => 401
                        ], 401);
                        }

                        $data = [
                             'token'  => $token,
                             'data'   => [
                                 'id_registrasi_user' => $user->id ,
                                 'nm_bu'              => $user->nm_bu,
                                 'email_bu'           => $user->email_bu
                             ],
                             'message'    => 'Berhasil login',
                             'status'     => 200
                         ];
                        return response()->json($data, 200);
                    } else {
                        return response()->json([
                            'messages' => 'Akun anda belum aktif',
                             'status' => 400
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'messages' => 'Password anda salah',
                         'status' => 400
                    ], 400);
                }
            } else {
                return response()->json([
                    'messages' => 'Email / NPWP Tidak di temukan',
                     'status' => 401
                ], 401);
            }
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Successfully logged out',
             'status' => 200
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
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
            return response()->json($validator->errors());
        } else {
            $dataUser = [
                'npwp_bu'   => str_replace("-", "", str_replace(".", "", $request->npwp_bu)),
                'email_bu'  => $request->email_bu,
                'nm_bu'     => $request->nm_bu,
                'bentuk_bu' => $request->bentuk_bu,
                'status_bu' => $request->status_bu,
                'password'  => Hash::make($request->password),
                'remember_token' =>  Uuid::uuid4()->toString(),
                'email_verified_at' => null
            ];
            if (RegistrationUsers::create($dataUser)) {
                dispatch(new SendMembersActivationMailApi($dataUser));
     
                if (! $user = RegistrationUsers::first()) {
                    return response()->json([
                        'message' => 'Gagal Terdaftar',
                        'status' => 400
                    ], 400);
                }

                return response()->json([
                    'message' => 'Berhasil Terdaftar',
                    'status' => 200
                ], 200);
            }
        }
    }

    public function reset(Request $request)
    {
        $rules = array(
            'email_bu'  => 'required',
            'password' => 'required|min:6'
        );
        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $reset = RegistrationUsers::where('email_bu', $request->email_bu)
            ->update(['password' => Hash::make($request->password)]);

            if ($reset) {
                return response()->json([
                    'message' => 'Successfully Reset Password',
                     'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Email anda tidak terdaftar',
                     'status' => 200
                ]);
            }
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 401
            ], 401);
        }
    }
}
