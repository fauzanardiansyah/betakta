<?php

namespace App\Http\Controllers\Api\Dki\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\UsersDppDpn;
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
        $this->middleware('auth:api', ['except' => ['signin','register','reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request)
    {
        $rules = array(
            'email_pengurus'  => 'required|string|max:100',
            'password' => 'required|min:6'
        );

        
        $validator = Validator::make($request->all(), $rules);

        $credentials = request(['email_pengurus', 'password']);

       
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $pengurus = DB::table('t_users_dp AS a')
            ->select('a.*', 'c.name')
            ->join('t_dp AS b', 'a.id_dp', '=', 'b.id')
            ->join('provinsi AS c', 'b.id_provinsi', 'c.id')
            ->where('a.email_pengurus', $request->email_pengurus)
            ->first();

            if (!empty($pengurus)) {
                if (Hash::check($request->input('password'), $pengurus->password)) {
                        if (! $token = auth('api2')->attempt($credentials)) {
                            return response()->json([
                            'error' => 'Unauthorized',
                            'status' => 401
                        ], 401);
                        }
                        $result = [
                             'token'  => $token,
                             'data'   => [
                                 'id_registrasi_user' => $pengurus->id,
                                 'name'               => $pengurus->name,
                                 'email_pengurus'     => $pengurus->email_pengurus,
                                 'created_at'         => $pengurus->created_at,
                                 'updated_at'         => $pengurus->updated_at
                             ],
                             'message'    => 'Berhasil login',
                             'status'     => 200
                         ];
                        return response()->json($result, 200);
                    
                } else {
                    return response()->json([
                        'messages' => 'Password anda salah',
                         'status' => 400
                    ], 400);
                }
            } else {
                return response()->json([
                    'messages' => 'Email tidak ditemukan',
                     'status' => 404
                ], 404);
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
            'email_bu' => 'required|email|unique:t_registrasi_users|max:30',
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
