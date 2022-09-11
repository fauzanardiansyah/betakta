<?php

namespace App\Http\Controllers\Backend\Dpn\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class DashboardDpnController extends Controller
{
    public function index()
    {
        $query = 'SELECT provinsi.name as provinsi, COUNT(t_kta.id) as jumlah
                  from provinsi, t_kta, t_dp, t_detail_kta WHERE t_kta.id_dp = t_dp.id and 
                  t_dp.id_provinsi = provinsi.id AND t_kta.id = t_detail_kta.id_kta 
                  AND t_detail_kta.is_inserted = 4 GROUP by provinsi.name';
        $dataChart = DB::select($query, [1]);
        
       $jmlAnggotaDpp = [];
       foreach ($dataChart as $item) {
           $jmlAnggotaDpp[] = [
            ($item->provinsi == "DEWAN PENGURUS NASIONAL") ? "Afiliasi" : $item->provinsi,
            $item->jumlah
        ];
       }
        
        $anggota_aktif    = DB::select("SELECT COUNT(t_kta.id) as total_aktif from t_kta, t_detail_kta 
                                        WHERE status_kta = 0 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");
        $anggota_pasif    = DB::select("SELECT COUNT(t_kta.id) as total_pasif from t_kta, t_detail_kta 
                                        WHERE status_kta = 1 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");
        $anggota_berhenti = DB::select("SELECT COUNT(t_kta.id) as total_berhenti from t_kta, t_detail_kta 
                                        WHERE status_kta = 2 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");
  
        return view('backend/dpn/content-pages/dashboard.dashboard-page', compact('jmlAnggotaDpp', 'anggota_aktif', 'anggota_pasif', 'anggota_berhenti'));
    }
}
