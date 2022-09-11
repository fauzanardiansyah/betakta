<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DashboardController extends Controller
{
    /**
     * Get data of members from all councils
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $query = 'SELECT provinsi.name as provinsi, COUNT(t_kta.id) as jumlah
                  from provinsi, t_kta, t_dp WHERE t_kta.id_dp = t_dp.id and 
                  t_dp.id_provinsi = provinsi.id GROUP by provinsi.name';
        $dataChart = DB::select($query, [1]);
        
       $jmlAnggotaDpp = [];
       foreach($dataChart as $item) {
        $jmlAnggotaDpp[] = [
            ($item->provinsi == "DEWAN PENGURUS NASIONAL") ? "Afiliasi" : $item->provinsi,
            $item->jumlah
        ];
       }


        return view('backend/anggota/content-pages/dashboard.dashboard-page', compact('jmlAnggotaDpp'));
    }
}
