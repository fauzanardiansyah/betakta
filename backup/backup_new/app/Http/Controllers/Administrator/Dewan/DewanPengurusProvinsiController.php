<?php

namespace App\Http\Controllers\Administrator\Dewan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Ramsey\Uuid\Uuid;
use Validator;
use DB;
use Hash;
use File;

class DewanPengurusProvinsiController extends Controller
{
    public function index()
    {
        return view('administrator/content-pages/dewan.dpp-administrator-page');
    }

    public function manageDataDpp()
    {
        return view('administrator/content-pages/dewan.manage-data-dpp');
    }

    public function getCouncilAllProvince()
    {
        $pengurusInkindo = DB::table('t_dp')
        ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
        ->select('t_dp.id as id_dp', 't_dp.email_dewan_pengurus', 'provinsi.name')
        ->where('t_dp.level', 0);
    

        return Datatables::of($pengurusInkindo)
        ->addColumn('action', function ($pengurus) {
            return '
           <a href="'.route('administrator.dewan.form-manage-data-dpp', ['id' => $pengurus->id_dp]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Manage</a>
           <a href="#" id="remove-dpp" data-id-dpp="'.route('administrator.dewan.remove-data-dpp', ['id_dp' => $pengurus->id_dp]).'" class="mb-2 mr-2 btn btn-danger" style="color:#fff">Remove</a>
           ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function formaAddDataDpp()
    {
        $provinsi = \App\Provinsi::all();
        return view('administrator/content-pages/dewan.form-tambah-data-dpp', compact('provinsi'));
    }


    public function formaAddDataDppProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_provinsi'               => 'required',
            'no_rek'                    => 'required|numeric',
            'kode_bank'                 => 'required|numeric',
            'nm_bank'                   => 'required|string|max:50',
            'nm_rek'                    => 'required|string',
            'alamat'                    => 'required|string|max:500',
            'email_dewan_pengurus'      => 'required',
            'no_telp_dewan_pengurus'    => 'required|string',
            'iuran_1_thn_kecil'         => 'required|numeric',
            'iuran_1_thn_menengah'      => 'required|numeric',
            'iuran_1_thn_besar'         => 'required|numeric',
            'role_share_iuran_kecil'    => 'required|numeric',
            'role_share_iuran_menengah' => 'required|numeric',
            'role_share_iuran_besar'    => 'required|numeric',
            'role_share_uang_pangkal'   => 'required|numeric',
            'uang_pangkal'              => 'required|numeric',
            'foto_profile_dpp'          => 'file|mimes:jpeg,jpg,png|max:2048',
            'nm_ketua_provinsi'         => 'required|required|string',
            'nm_sekretaris_provinsi'    => 'required|string',
            'ttd_ketua_provinsi'        => 'required|file|mimes:png|max:2048',
            'ttd_sekretaris_provinsi'   => 'required|file|mimes:png|max:2048',
        ]);



        if (!$validator->fails()) {
            $data_dpp_inputs = [
                'id_provinsi'               => $request->input('id_provinsi'),
                'level'                     => 0,
                'no_rek'                    => $request->input('no_rek'),
                'kode_bank'                 => $request->input('kode_bank'),
                'nm_bank'                   => $request->input('nm_bank'),
                'nm_rek'                    => $request->input('nm_rek'),
                'alamat'                    => $request->input('alamat'),
                'email_dewan_pengurus'      => $request->input('email_dewan_pengurus'),
                'no_telp_dewan_pengurus'    => $request->input('no_telp_dewan_pengurus'),
                'iuran_1_thn_kecil'         => $request->input('iuran_1_thn_kecil'),
                'iuran_1_thn_menengah'      => $request->input('iuran_1_thn_menengah'),
                'iuran_1_thn_besar'         => $request->input('iuran_1_thn_besar'),
                'role_share_iuran_kecil'    => $request->input('role_share_iuran_kecil'),
                'role_share_iuran_menengah' => $request->input('role_share_iuran_menengah'),
                'role_share_iuran_besar'    => $request->input('role_share_iuran_besar'),
                'role_share_uang_pangkal'   => $request->input('role_share_uang_pangkal'),
                'uang_pangkal'              => $request->input('uang_pangkal'),
                'foto_profile_dpp'          => substr($request->file('foto_profile_dpp')->storeAs('public/profile-dpn', Uuid::uuid4().'.jpg'), 19),
                'nm_ketua_provinsi'         => $request->input('nm_ketua_provinsi'),
                'nm_sekretaris_provinsi'    => $request->input('nm_sekretaris_provinsi'),
                'ttd_ketua_provinsi'        => substr($request->file('ttd_ketua_provinsi')->storeAs('public/signature', Uuid::uuid4().'.png'), 17),
                'ttd_sekretaris_provinsi'   => substr($request->file('ttd_sekretaris_provinsi')->storeAs('public/signature', Uuid::uuid4().'.png'), 17),
            ];
            $save_data_dpp = \App\DewanPengurus::create($data_dpp_inputs);
            if ($save_data_dpp) {
                return redirect()->back()->with('successSaveDataDpp', 'Data dewan pengurus berhasil di tambah');
            } else {
                return redirect()->back()->with('failedSaveDataDpp', 'Data dewan pengurus gagal di tambah');
            }
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function formManageDataDpp($id_dp)
    {
        $data_dpp = \App\DewanPengurus::with('provinsi')
                        ->where('level', 0)
                        ->where('id', $id_dp)
                        ->first();
        $provinsi = \App\Provinsi::all();

        return view('administrator/content-pages/dewan.form-manage-data-dpp', compact('data_dpp', 'provinsi'));
    }


    public function formManageDataDppProcess(Request $request, $id_dp)
    {
        $dpp = \App\DewanPengurus::findOrFail($id_dp);
        $validator = Validator::make($request->all(), [
            'no_rek'                    => 'required|numeric',
            'kode_bank'                 => 'required|numeric',
            'nm_bank'                   => 'required|string',
            'nm_rek'                    => 'required|string',
            'alamat'                    => 'required|string|max:500',
            'email_dewan_pengurus'      => 'required',
            'no_telp_dewan_pengurus'    => 'required|string',
            'iuran_1_thn_kecil'         => 'required|numeric',
            'iuran_1_thn_menengah'      => 'required|numeric',
            'iuran_1_thn_besar'         => 'required|numeric',
            'role_share_iuran_kecil'    => 'required|numeric',
            'role_share_iuran_menengah' => 'required|numeric',
            'role_share_iuran_besar'    => 'required|numeric',
            'role_share_uang_pangkal'   => 'required|numeric',
            'uang_pangkal'              => 'required|numeric',
            'foto_profile_dpp'          => 'file|mimes:jpeg,jpg|max:2048',
            'nm_ketua_provinsi'         => 'required|required|string',
            'nm_sekretaris_provinsi'    => 'required|string',
            'ttd_ketua_provinsi'        => 'file|mimes:png|max:2048',
            'ttd_sekretaris_provinsi'   => 'file|mimes:png|max:2048',
        ]);

      

        if (!$validator->fails()) {
            $data_dpp_inputs = [
                'id_provinsi'               => $request->input('id_provinsi'),
                'level'                     => 0,
                'no_rek'                    => $request->input('no_rek'),
                'kode_bank'                 => $request->input('kode_bank'),
                'nm_bank'                   => $request->input('nm_bank'),
                'nm_rek'                    => $request->input('nm_rek'),
                'alamat'                    => $request->input('alamat'),
                'email_dewan_pengurus'      => $request->input('email_dewan_pengurus'),
                'no_telp_dewan_pengurus'    => $request->input('no_telp_dewan_pengurus'),
                'iuran_1_thn_kecil'         => $request->input('iuran_1_thn_kecil'),
                'iuran_1_thn_menengah'      => $request->input('iuran_1_thn_menengah'),
                'iuran_1_thn_besar'         => $request->input('iuran_1_thn_besar'),
                'role_share_iuran_kecil'    => $request->input('role_share_iuran_kecil'),
                'role_share_iuran_menengah' => $request->input('role_share_iuran_menengah'),
                'role_share_iuran_besar'    => $request->input('role_share_iuran_besar'),
                'role_share_uang_pangkal'   => $request->input('role_share_uang_pangkal'),
                'uang_pangkal'              => $request->input('uang_pangkal'),
                'foto_profile_dpp'          => ($request->hasFile('foto_profile_dpp') ? substr($request->file('foto_profile_dpp')->storeAs('public/profile-dpp', Uuid::uuid4().'.jpg'), 19) : $dpp->foto_profile_dpp),
                'nm_ketua_provinsi'         => $request->input('nm_ketua_provinsi'),
                'nm_sekretaris_provinsi'    => $request->input('nm_sekretaris_provinsi'),
                'ttd_ketua_provinsi'        => ($request->hasFile('ttd_ketua_provinsi')) ? substr($request->file('ttd_ketua_provinsi')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpp->ttd_ketua_provinsi,
                'ttd_sekretaris_provinsi'   => ($request->hasFile('ttd_sekretaris_provinsi')) ? substr($request->file('ttd_sekretaris_provinsi')->storeAs('public/signature', Uuid::uuid4().'.png'), 17) : $dpp->ttd_sekretaris_provinsi,
            ];
    
            $update_data_dpp = $dpp->update($data_dpp_inputs);
            if ($update_data_dpp) {
                return redirect()->back()->with('successUpdateDataDpp', 'Data dewan pengurus berhasil di ubah');
            } else {
                return redirect()->back()->with('failedUpdateDataDpp', 'Data dewan pengurus gagal di ubah');
            }
        } else {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }


    public function removeDataDpp($id_dp)
    {
        $dpp = \App\DewanPengurus::findOrFail($id_dp);
        if (!is_null($dpp)) {
            if ($dpp->delete()) {
                $foto_profile_dpp = public_path('storage/profile-dpp/'.$dpp->foto_profile_dpp) ;
                $ttd_ketua_provinsi = public_path('storage/signature/'.$dpp->ttd_ketua_provinsi) ;
                $ttd_sekretaris_provinsi = public_path('storage/signature/'.$dpp->ttd_sekretaris_provinsi) ;
                
                File::delete($foto_profile_dpp, $ttd_ketua_provinsi, $ttd_sekretaris_provinsi);
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('failedDeleteNews', 'Gagal menghapus data testimonial');
        }
    }


    public function manageAkunDpp()
    {
        return view('administrator/content-pages/dewan.manage-akun-dpp');
    }

    public function getCouncilAccountAllProvince()
    {
        $pengurusInkindo = DB::table('t_users_dp')
        ->join('t_dp', 't_users_dp.id_dp', '=', 't_dp.id')
        ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
        ->select('t_users_dp.id as id_pengurus', 't_users_dp.email_pengurus', 'provinsi.name')
        ->where('t_dp.level', 0);
    

        return Datatables::of($pengurusInkindo)
        ->addColumn('action', function ($pengurus) {
            return '
           <a href="'.route('administrator.dewan.form-edit-akun-dpp', ['id' => $pengurus->id_pengurus]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Manage</a>
           <a href="#" id="remove-users-dpp" data-id-users-dpp="'.route('administrator.dewan.remove-akun-dpp', ['id_users_dp' => $pengurus->id_pengurus]).'" class="mb-2 mr-2 btn btn-danger" style="color:#fff">Remove</a>
           ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }


    public function formaAddAccountDpp()
    {
        $data_dpp = \App\DewanPengurus::with('provinsi')
        ->where('level', 0)
        ->get();
        return view('administrator/content-pages/dewan.form-tambah-akun-dpp', compact('data_dpp'));
    }

    public function formAddAccountDppProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_dp'                  => 'required|numeric',
            'npwp_pengurus'          => 'required|string',
            'email_pengurus'         => 'required|email|unique:t_users_dp|max:190',
            'password'               => 'required|confirmed|min:6',
            'password_confirmation'  => 'required_with:password|min:6|max:100'
        ]);

        if (! $validator->fails()) {
            if (\App\UsersDppDpn::create([
                'id_dp'                  => $request->id_dp,
                'npwp_pengurus'          => $request->npwp_pengurus,
                'email_pengurus'         => $request->email_pengurus,
                'password'               => Hash::make($request->password),
            ])) {
                return redirect()
                ->route('administrator.dewan.manage-akun-dpp')
                ->with('successSaveAccountDpp', 'Berhasil Menambah Akun DPP');
            } else {
                return redirect()
                ->route('administrator.dewan.manage-akun-dpp')
                ->with('failedSaveAccountDpp', 'Gagal Menambah Akun DPP');
            }
        } else {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
    }

    public function formEditAccountDpp($id_users_dp)
    {
        $data_dpp = \App\DewanPengurus::with('provinsi')
        ->where('level', 0)
        ->get();
        $data_users_dpp = \App\UsersDppDpn::findOrFail($id_users_dp);

        return view('administrator/content-pages/dewan.form-edit-akun-dpp', compact('data_users_dpp', 'data_dpp'));
    }

    public function formUpdateAccountDpp(Request $request, $id_users_dp)
    {
        $data_akun_dpp  = \App\UsersDppDpn::findOrFail($id_users_dp);

        if (!empty($request->password)) {
            $validator = Validator::make($request->all(), [
        'id_dp'                  => 'required|numeric',
        'npwp_pengurus'          => 'required|string',
        'email_pengurus'         => 'required|email|max:30',
        'password'               => 'required|confirmed|min:6',
        'password_confirmation'  => 'required_with:password|min:6|max:100'
        ]);
        } else {
            $validator = Validator::make($request->all(), [
            'id_dp'                  => 'required|numeric',
            'npwp_pengurus'          => 'required|string',
            'email_pengurus'         => 'required|email|max:30',
            ]);
        }


        if (! $validator->fails()) {
            $data_akun_inputs = [
                'id_dp'               => $request->input('id_dp'),
                'npwp_pengurus'       => $request->input('npwp_pengurus'),
                'email_pengurus'      => $request->input('email_pengurus'),
                'password'            => Hash::make($request->input('password')),
                ];

            if ($data_akun_dpp->update($data_akun_inputs)) {
                return redirect()->back()->with('successUpdateAccountDpp', 'Akun dewan pengurus berhasil di tambah');
            }

            return redirect()->back()->with('failedUpdateAccountDpp', 'Akun dewan pengurus berhasil di tambah');
        } else {
            return redirect()->back()
        ->withErrors($validator)
        ->withInput();
        }
    }


    public function removeAccountDpp($id_users_dp)
    {
        $users_dpp = \App\UsersDppDpn::findOrFail($id_users_dp);
        if (!is_null($users_dpp)) {
            if ($users_dpp->delete()) {
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('failedDeleteNews', 'Gagal menghapus data testimonial');
        }
    }
}
