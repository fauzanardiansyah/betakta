<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;


class ReRegistrationController extends Controller
{
    public function index()
    {
        $allDPP = DB::table('t_dp')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->select('t_dp.id', 'provinsi.name')
            ->orderBy('t_dp.id', 'DESC')
            ->get();

        return view('backend/anggota/content-pages/re-registration.registration-page', compact('allDPP'));
    }
    public function pindah_dpp()
    {
        $allDPP = DB::table('t_dp')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->select('t_dp.id', 'provinsi.name')
            ->orderBy('t_dp.id', 'DESC')
            ->get();

        return view('backend/anggota/content-pages/re-registration.pindah_dpp', compact('allDPP'));
    }

    
    public function action_pindah_dpp()
    {
        // dd('tes');
       
        $rules = array(
            'jenis_bu'  => 'required',
            'lokasi_pengurusan' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->fails()) {
            $dataInfoBu = [
                'id'                  => Uuid::uuid4()->toString(),
                'id_registrasi_users' => Session::get('id_registrasi_user'),
                'id_dp'               => $request->provinsi  ,
                'jenis_bu'            => $request->jenis_bu,
                'kualifikasi'         => ($request->jenis_bu == 'pmdn') ? $request->kualifikasi : "besar",
                'lokasi_pengurusan'   => $request->lokasi_pengurusan,
                'no_kta'              => null,
                'status_kta'          => 1,
                'status_penataran'    => 1,
                'registration_until_date' => date('Y-m-d H:i:s', strtotime('+11 month'))
            ];

            if (\App\Kta::create($dataInfoBu)) {
                $getLastKta = DB::table('t_kta')->orderBy('created_at', 'DESC')->first();

                $detailKta = new \App\DetailKta;

                $detailKta->id = Uuid::uuid4()->toString();

                $detailKta->id_kta = $getLastKta->id;

                $detailKta->jenis_pengajuan = 1;

                $detailKta->waktu_pengajuan = $getLastKta->created_at;

                $detailKta->tgl_terbit = null;

                $detailKta->masa_berlaku = date('Y').'-12-31';

                $detailKta->view_notifikasi = 0;

                $detailKta->view_notifikasi_dpp = 0;

                $detailKta->view_notifikasi_dpn = 0;

                $detailKta->is_inserted = false;

                if ($detailKta->save()) {
                    $getLastDetailKta = DB::table('t_detail_kta')->orderBy('created_at', 'DESC')->first();
                    
                    Session::put('id_detail_kta', $getLastDetailKta->id);

                    $appKta = new  \App\HistoryApprovalPengajuan;

                    $appKta->id_detail_kta = Session::get('id_detail_kta');
                    // JIka pengurusan oleh dpp maka akan di isi angka 0 dan jika pengurusan oleh dpn maka akan di isi anka 2
                    $appKta->status_pengajuan = $stsPengajuan = ($getLastKta->jenis_bu === 'pma') ? 3 : 0 ;

                    $appKta->tgl_status = date('Y/m/d H:i:s');

                    $appKta->keterangan = '';

                    $appKta->save();
                    
                    // return redirect()->route('anggota.re-registration.formAdministrasiBadanUsaha');
                }
            }
            
            return redirect()->back();
        }

    }

    public function formAdminstrasiBadanUsaha()
    {
        $dataUser = \App\RegistrationUsers::findOrFail(Session::get('id_registrasi_user'));
        
        return view('backend/anggota/content-pages/re-registration.formBadanUsaha', compact('dataUser'));
    }

    public function formPenanggungJawabBadanUsaha()
    {
        return view('backend/anggota/content-pages/re-registration.formPenanggungJawabBadanUsaha');
    }

    public function formLegalitasBadanUsaha()
    {
        return view('backend/anggota/content-pages/re-registration.formLegalitasBadanUsaha');
    }

    public function formDokumenPendukung()
    {
        return view('backend/anggota/content-pages/re-registration.formDokumenPendukung');
    }
}
