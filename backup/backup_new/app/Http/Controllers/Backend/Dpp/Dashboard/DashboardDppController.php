<?php

namespace App\Http\Controllers\Backend\Dpp\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class DashboardDppController extends Controller
{
   
    public function index()
    {
        $query = 'SELECT provinsi.name as provinsi, COUNT(t_kta.id) as jumlah,kd_provinsi,name,no_urut_2
                  from provinsi, t_kta, t_dp, t_detail_kta WHERE t_kta.id_dp = t_dp.id and 
                  t_dp.id_provinsi = provinsi.id AND t_kta.id = t_detail_kta.id_kta 
                  AND t_detail_kta.is_inserted = 4 GROUP by provinsi.name order by provinsi.no_urut_2 asc';
        $dataChart = DB::select($query, [1]);
        
       $jmlAnggotaDpp = [];
       foreach ($dataChart as $item) {
           $jmlAnggotaDpp[] = [
            ($item->provinsi == "DEWAN PENGURUS NASIONAL") ? "AFILIASI" : $item->provinsi,
            $item->jumlah
        ];
       }

        $warning  = \App\M_warning::where('status', 'aktif')->first(); 
        
        $anggota_aktif    = DB::select("SELECT COUNT(t_kta.id) as total_aktif from t_kta, t_detail_kta 
                                        WHERE status_kta = 0 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");
        $anggota_pasif    = DB::select("SELECT COUNT(t_kta.id) as total_pasif from t_kta, t_detail_kta 
                                        WHERE status_kta = 1 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");
        $anggota_berhenti = DB::select("SELECT COUNT(t_kta.id) as total_berhenti from t_kta, t_detail_kta 
                                        WHERE status_kta = 2 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");
        
        $id_dp = Session::get('id_dp');
        return view('backend/dpp/content-pages/dashboard.dashboard-page', compact('jmlAnggotaDpp', 'anggota_aktif', 'anggota_pasif', 'anggota_berhenti','warning'));
    }
    
}
