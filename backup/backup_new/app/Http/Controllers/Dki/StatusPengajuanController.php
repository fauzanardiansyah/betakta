<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class StatusPengajuanController extends Controller
{
    public function index(string $id_detail_kta)
    {
        $dataTrackingStatus = DB::table('t_detail_kta')
                                ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                                ->where('t_detail_kta.id', $id_detail_kta)
                                ->select('t_detail_kta.jenis_pengajuan', 't_app_kta.status_pengajuan', 't_app_kta.keterangan')
                                ->first();
        
        if ($dataTrackingStatus) {
            $data = [
                'data' => $dataTrackingStatus,
                'message' => 'Tracking pengajuan anggota',
                'status' => 200
          ];
            return response()->json($data, 200);
        }
        $data = [
                'data' => null,
                'message' => 'Anggota tidak di temukan',
                'status' => 404
        ];
        return response()->json($data, 404);
    }

}
