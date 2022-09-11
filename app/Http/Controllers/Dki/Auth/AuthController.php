<?php

namespace App\Http\Controllers\Dki\Auth;

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
        $this->middleware('auth:api', ['except' => ['signin','register','reset', 'signout']]);
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
                                 'id_registrasi_pengurus' => $pengurus->id,
                                 'id_dp'              => $pengurus->id_dp,
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
                        'message' => 'Password anda salah',
                         'status' => 400
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => 'Email tidak ditemukan',
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
    public function signout()
    {
        auth()->logout();

        return response()->json([
            'message' => 'Berhasil sign out',
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

    public function reset(Request $request)
    {
        $email_pengurus = $request->input('email_pengurus');
        $password = $request->input('password');
    
        $rules = array(
            'email_pengurus'  => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required_with:password|min:6|max:100'
        );
        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $user = UsersDppDpn::where('email_pengurus', $email_pengurus)->first();
            if(!empty($user)) {
                $updateUser = $user->update([
                    'password' => bcrypt($password)
                ]);
                return response()->json([
                    'message' => 'Berhasil Merubah Password',
                    'status' => 200
                ], 200);

            } else {
                return response()->json([
                    'message' => 'Email Anda Tidak Di Temukan',
                    'status' => 404
                ], 404);
            }
        } else {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 401
            ], 401);
        }
    }
}

