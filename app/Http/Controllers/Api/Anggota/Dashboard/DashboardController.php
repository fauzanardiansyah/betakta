<?php

namespace App\Http\Controllers\Api\Anggota\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DashboardController extends Controller
{
    public function getDataAnggota()
    {
        $query = 'SELECT provinsi.name as provinsi, COUNT(t_kta.id) as jumlah
        from provinsi, t_kta, t_dp WHERE t_kta.id_dp = t_dp.id and 
        t_dp.id_provinsi = provinsi.id GROUP by provinsi.name';
        $dataChart = DB::select($query, [1]);

        $jmlAnggotaDpp = [];
        foreach ($dataChart as $item) {
                $jmlAnggotaDpp[] = [
                $item->provinsi,
                $item->jumlah
            ];
        }

        $data = [
            'data' => $jmlAnggotaDpp,
            'message' => 'Data chart anggota tiap provinsi',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
