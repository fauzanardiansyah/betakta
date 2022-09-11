<?php

namespace App\Http\Controllers\Administrator\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Ramsey\Uuid\Uuid;
use Validator;
use DB;
use Hash;
use File;

class ProfileController extends Controller
{
    public function index()
    {
        return view('administrator/content-pages/profile.user-profile');
    }

    public function getDataSuperAdmin()
    {
        $super_admin = DB::table('super_admin')->select('*');

        return Datatables::of($super_admin)
        ->editColumn('foto_profile', function ($foto_profile) {
           return "<img src=".asset('storage/superadmin/'.$foto_profile->foto_profile)." style='width:100px' class='img-fluid'>";
        })
        ->addColumn('action', function ($super_admin) {
            return '
           <a href="'.route('administrator.profile.form-edit-superadmin', ['id' => $super_admin->id]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Manage</a>
           <a href="#" id="delete-admin" data-id-admin="'.route('administrator.profile.delete-superadmin', ['id' => $super_admin->id]).'" class="mb-2 mr-2 btn btn-danger" style="color:#fff">Remove</a>
           ';
        })
        ->rawColumns(['action', 'foto_profile'])
        ->make(true);


    }

    public function formAddSuperAdmin()
    {
        return view('administrator/content-pages/profile.form-add-super-admin');       
    }

    public function addSuperAdminProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_admin'             => 'required|string',
            'email'                  => 'required|email|unique:super_admin|max:30',
            'foto_profile'           => 'required|file|mimes:jpeg,jpg|max:2048',
            'jabatan'                => 'required|string',
            'password'               => 'required|confirmed|min:6',
            'password_confirmation'  => 'required_with:password|min:6|max:100'
        ]);


        if(! $validator->fails()) {
            $image_name  = $request->file('foto_profile')->getClientOriginalName();
            $fileName = pathinfo($image_name, PATHINFO_FILENAME);
            $image_file  = $fileName.'.'.$request->foto_profile->getClientOriginalExtension();
            $request->file('foto_profile')->move(public_path('storage/superadmin'), $image_file);
           
            $data_input = [
                'nama_admin'             => $request->input('nama_admin'),
                'email'                  => $request->input('email'),
                'foto_profile'           => $image_file,
                'jabatan'                => $request->input('jabatan'),
                'password'               => Hash::make($request->input('password')),
            ];

            if(\App\SuperAdmin::create($data_input)) {
                return redirect()->route('administrator.profile.profile-main')
                       ->with('successAddSuperAdmin', 'Berhasil Menambah Akun Super Admin');
            }

            return redirect()->back()
            ->with('failedAddSuperAdmin', 'Gagal Menambah Akun Super Admin');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

    }

    public function formEditSuperAdmin($id)
    {
        $superadmin = \App\SuperAdmin::findOrFail($id);
        return view('administrator/content-pages/profile.form-edit-super-admin', compact('superadmin'));
    }

    public function updateSuperAdminProcess(Request $request, $id)
    {
        $superadmin = \App\SuperAdmin::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama_admin'             => 'required|string',
            'email'                  => 'required|email|max:30',
            'foto_profile'           => 'file|mimes:jpeg,jpg,png|max:2048',
            'jabatan'                => 'required|string',
            'password'               => 'required|confirmed|min:6',
            'password_confirmation'  => 'required_with:password|min:6|max:100'
        ]);


        if(! $validator->fails()) {
            if($request->hasFile('foto_profile')) {
                $image_name  = $request->file('foto_profile')->getClientOriginalName();
                $fileName = pathinfo($image_name, PATHINFO_FILENAME);
                $image_file  = $fileName.'.'.$request->foto_profile->getClientOriginalExtension();
                $request->file('foto_profile')->move(public_path('storage/superadmin'), $image_file);
            }
            
           
            $data_input = [
                'nama_admin'             => $request->input('nama_admin'),
                'email'                  => $request->input('email'),
                'foto_profile'           => ($request->hasFile('foto_profile')) ? $image_file : $superadmin->foto_profile,
                'jabatan'                => $request->input('jabatan'),
                'password'               => Hash::make($request->input('password')),
            ];

            if($superadmin->update($data_input)) {
                return redirect()->route('administrator.profile.profile-main')
                       ->with('successUpdateSuperAdmin', 'Berhasil Merubah Akun Super Admin');
            }

            return redirect()->back()
            ->with('failedUpdateSuperAdmin', 'Gagal Merubah Akun Super Admin');
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function destroy($id) 
    {
        $superadmin = \App\SuperAdmin::findOrFail($id);
        if (!is_null($superadmin)) {
            if ($superadmin->delete()) {
                $foto_profile = public_path('storage/superadmin/'.$superadmin->foto_profile) ;                       
                File::delete($foto_profile);
                return redirect()->back();
            }
        } 
    }
}
