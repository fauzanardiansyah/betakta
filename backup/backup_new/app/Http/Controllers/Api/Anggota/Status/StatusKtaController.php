<?php

namespace App\Http\Controllers\Api\Anggota\Status;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class StatusKtaController extends Controller
{
    public function index($id_registrasi_user)
    {
        $statusData =  DB::table('t_kta')
                                    ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                                    ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                                    ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                    ->select('t_kta.id as id_kta', 't_kta.no_kta', 't_kta.lokasi_pengurusan', 't_kta.status_kta', 't_detail_kta.waktu_pengajuan', 't_detail_kta.jenis_pengajuan', 't_detail_kta.masa_berlaku', 't_detail_kta.id as id_detail_kta', 't_app_kta.status_pengajuan')
                                    ->where('t_detail_kta.is_inserted', 4)
                                    ->where('t_registrasi_users.id',$id_registrasi_user)
                                    ->orderBy('t_detail_kta.created_at', 'desc')
                                    ->limit(1)
                                    ->get();
                                

        if(!empty($statusData)) {
            $data = [
                'data' => $statusData,
                'message' => 'Data status anggota',
                'status' => 200
            ];

            return response()->json($data, 200);
        }

        $data = [
            'data' => $statusData,
            'message' => 'Data status anggota tidak di temukan',
            'status' => 404
        ];

        return response()->json($data, 404);
    }

    public function getTrackingAnggota($id)
    {
        $dataTrackingStatus = DB::table('t_detail_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->where('t_detail_kta.id', $id)
                                ->select('t_detail_kta.is_inserted', 't_app_kta.status_pengajuan', 't_app_kta.keterangan')
                                ->first();
        $data = [
                'data' => $dataTrackingStatus,
                'message' => 'Tracking pengajuan anggota',
                'status' => 200
            ];

        return response()->json($data);
    }
}
