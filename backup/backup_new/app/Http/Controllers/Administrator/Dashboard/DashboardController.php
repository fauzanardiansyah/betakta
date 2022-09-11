<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\DashboardAdministratorExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $provinsi = DB::table('provinsi')->get();
        return view('administrator/content-pages.dashboard', compact('provinsi'));
    }

    public function dashboardAjax()
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


        $anggota_aktif    = DB::select("SELECT COUNT(t_kta.id) as total_aktif from t_kta, t_detail_kta 
                                        WHERE status_kta = 0 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");
       
        $anggota_berhenti = DB::select("SELECT COUNT(t_kta.id) as total_berhenti from t_kta, t_detail_kta 
                                        WHERE status_kta = 2 AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_detail_kta.is_inserted = 4");

        $tolak_by_dpp    = DB::select("SELECT COUNT(t_kta.id) as tolak_by_dpp from t_kta, t_detail_kta, t_app_kta 
                                        WHERE t_kta.id = t_detail_kta.id_kta 
                                        AND t_app_kta.id_detail_kta = t_detail_kta.id 
                                        AND t_detail_kta.is_inserted = 4
                                        AND t_app_kta.status_pengajuan = 1"    
                                    );
         $tolak_by_dpn    = DB::select("SELECT COUNT(t_kta.id) as tolak_by_dpn from t_kta, t_detail_kta, t_app_kta 
                                        WHERE t_kta.id = t_detail_kta.id_kta 
                                        AND t_app_kta.id_detail_kta = t_detail_kta.id 
                                        AND t_detail_kta.is_inserted = 4
                                        AND t_app_kta.status_pengajuan = 4"    
                                    );
        $on_dpp           = DB::select("SELECT COUNT(t_kta.id) AS on_dpp from t_kta 
                                    INNER JOIN t_detail_kta 
                                        on t_detail_kta.id_kta = t_kta.id
                                    INNER JOIN t_app_kta
                                        ON t_app_kta.id_detail_kta = t_detail_kta.id
                                    INNER JOIN t_dp
                                        ON t_kta.id_dp = t_dp.id
                                        WHERE t_detail_kta.is_inserted = 4 
                                        AND t_app_kta.status_pengajuan = 0
                                        OR t_app_kta.status_pengajuan = 2");
        $on_dpn           = DB::select("SELECT COUNT(t_kta.id) AS on_dpn from t_kta 
                                        INNER JOIN t_detail_kta 
                                            on t_detail_kta.id_kta = t_kta.id
                                        INNER JOIN t_app_kta
                                            ON t_app_kta.id_detail_kta = t_detail_kta.id
                                        INNER JOIN t_dp
                                            ON t_kta.id_dp = t_dp.id
                                            WHERE t_detail_kta.is_inserted = 4
                                            AND t_app_kta.status_pengajuan = 3
                                            OR t_app_kta.status_pengajuan = 5
                                            OR t_app_kta.status_pengajuan = 6");

        $data = [
            'jmlAnggotaDpp' => $jmlAnggotaDpp,
            'anggota_aktif' => $anggota_aktif,
            'anggota_berhenti' => $anggota_berhenti,
            'tolak_by_dpp' => $tolak_by_dpp,
            'tolak_by_dpn' => $tolak_by_dpn,
            'on_dpp' => $on_dpp,
            'on_dpn' => $on_dpn,
        ];

        if($data) {
            return $data;
        }

        throw new Exception('Terjadi kesalahan');

        
    }

    public function dashboardFilterByProvinsiAjax(Request $request)
    {
        $provinsi_id = $request->input('provinsi_id');
        
        $query = "SELECT provinsi.name as provinsi, COUNT(t_kta.id) as jumlah
                  from provinsi, t_kta, t_dp, t_detail_kta WHERE t_kta.id_dp = t_dp.id and 
                  t_dp.id_provinsi = provinsi.id AND t_kta.id = t_detail_kta.id_kta 
                  AND t_detail_kta.is_inserted = 4 AND provinsi.id = ".$provinsi_id." GROUP by provinsi.name";
        $dataChart = DB::select($query, [1]);
        
       $jmlAnggotaDpp = [];
       foreach ($dataChart as $item) {
           $jmlAnggotaDpp[] = [
            ($item->provinsi == "DEWAN PENGURUS NASIONAL") ? "Afiliasi" : $item->provinsi,
            $item->jumlah
        ];
       }
        
        $anggota_aktif    = DB::select("SELECT COUNT(t_kta.id) AS total_aktif from t_kta 
                                            INNER JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
                                            INNER JOIN t_registrasi_users ON t_kta.id_registrasi_users = t_registrasi_users.id
                                            INNER JOIN t_dp ON t_kta.id_dp = t_dp.id
                                            INNER JOIN provinsi ON t_dp.id_provinsi = provinsi.id
                                            INNER JOIN t_administrasi_kta ON t_administrasi_kta.id_detail_kta = t_detail_kta.id
                                            INNER JOIN t_pj_kta ON t_pj_kta.id_detail_kta = t_detail_kta.id
                                            WHERE t_kta.status_kta = 0  
                                            AND t_detail_kta.is_inserted = 4
                                            AND t_dp.id_provinsi = $provinsi_id");
                                    
        $anggota_berhenti = DB::select("SELECT COUNT(t_kta.id) as total_berhenti from t_kta, t_detail_kta, t_dp 
                                        WHERE status_kta = 2 
                                        AND t_kta.id = t_detail_kta.id_kta 
                                        AND t_kta.id_dp = t_dp.id
                                        AND t_detail_kta.is_inserted = 4
                                        AND t_dp.id_provinsi = $provinsi_id
                                        ");

        $tolak_by_dpp    = DB::select("SELECT COUNT(t_kta.id) as tolak_by_dpp from t_kta, t_detail_kta, t_app_kta, t_dp 
                                        WHERE t_kta.id = t_detail_kta.id_kta 
                                        AND t_app_kta.id_detail_kta = t_detail_kta.id 
                                        AND t_kta.id_dp = t_dp.id
                                        AND t_detail_kta.is_inserted = 4
                                        AND t_app_kta.status_pengajuan = 1
                                        AND t_dp.id_provinsi = $provinsi_id
                                        ");
         $tolak_by_dpn    = DB::select("SELECT COUNT(t_kta.id) as tolak_by_dpn from t_kta, t_detail_kta, t_app_kta, t_dp 
                                        WHERE t_kta.id = t_detail_kta.id_kta 
                                        AND t_app_kta.id_detail_kta = t_detail_kta.id 
                                        AND t_kta.id_dp = t_dp.id
                                        AND t_detail_kta.is_inserted = 4
                                        AND t_app_kta.status_pengajuan = 4
                                        AND t_dp.id_provinsi = $provinsi_id
                                        ");
        $on_dpp           = DB::select("SELECT COUNT(t_kta.id) AS on_dpp from t_kta 
                                    INNER JOIN t_detail_kta 
                                        on t_detail_kta.id_kta = t_kta.id
                                    INNER JOIN t_app_kta
                                        ON t_app_kta.id_detail_kta = t_detail_kta.id
                                    INNER JOIN t_dp
                                        ON t_kta.id_dp = t_dp.id
                                        WHERE (t_app_kta.status_pengajuan = 0 OR t_app_kta.status_pengajuan = 2) 
                                        AND t_detail_kta.is_inserted = 4 
                                        AND t_dp.id_provinsi = $provinsi_id
                                        ");
        $on_dpn           = DB::select("SELECT COUNT(t_kta.id) AS on_dpn from t_kta 
                                        INNER JOIN t_detail_kta 
                                            on t_detail_kta.id_kta = t_kta.id
                                        INNER JOIN t_app_kta
                                            ON t_app_kta.id_detail_kta = t_detail_kta.id
                                        INNER JOIN t_dp
                                            ON t_kta.id_dp = t_dp.id
                                            WHERE (t_app_kta.status_pengajuan = 3 OR t_app_kta.status_pengajuan = 5 OR t_app_kta.status_pengajuan = 6) 
                                            AND t_detail_kta.is_inserted = 4
                                            AND t_dp.id_provinsi = $provinsi_id
                                            ");

        $data = [
            'jmlAnggotaDpp' => $jmlAnggotaDpp,
            'anggota_aktif' => $anggota_aktif,
            'anggota_berhenti' => $anggota_berhenti,
            'tolak_by_dpp' => $tolak_by_dpp,
            'tolak_by_dpn' => $tolak_by_dpn,
            'on_dpp' => $on_dpp,
            'on_dpn' => $on_dpn,
        ];

        if($data) {
            return $data;
        }

        throw new Exception('Terjadi kesalahan');
    }

    public function exportToExcel()
    {

        $data_report_table = \App\Provinsi::orderBy('kd_provinsi','asc')->get();
        $tot = count($data_report_table);
        
        $data_send = [];
        foreach ($data_report_table as $key => $value) {
            # code...

            if($value['kd_provinsi'] == "31")
            {
                continue;
            }

            $data_send[$value['kd_provinsi']] = ['id'=>$value['id'], 'name'=>$value['name'] ,'kd_provinsi'=>$value['kd_provinsi'] ];


        }
        $invite = ['id'=>100, 'name'=>'Afiliasi' ,'kd_provinsi'=>31];
        array_push($data_send,$invite);
        
        $data_report_table    = DB::select("SELECT 
        s1.nama_provinsi AS nama_provinsi,
        (CASE WHEN s2.total_aktif IS NOT NULL THEN s2.total_aktif ELSE 0 END) AS total_aktif,
        (CASE WHEN s3.total_berhenti IS NOT NULL THEN s3.total_berhenti ELSE 0 END) AS total_berhenti,
        (CASE WHEN s4.dikembalikan_dpp IS NOT NULL THEN s4.dikembalikan_dpp ELSE 0 END) AS dikembalikan_dpp,
        (CASE WHEN s5.dikembalikan_dpn IS NOT NULL THEN s5.dikembalikan_dpn ELSE 0 END) AS dikembalikan_dpn,
        (CASE WHEN s6.diproses_dpp IS NOT NULL THEN s6.diproses_dpp ELSE 0 END) AS diproses_dpp,
        (CASE WHEN s7.diproses_dpn IS NOT NULL THEN s7.diproses_dpn ELSE 0 END) AS diproses_dpn
    FROM(
        SELECT provinsi.id as id, provinsi.name AS nama_provinsi
        from provinsi
    ) s1
    
    LEFT JOIN (
        SELECT 
        provinsi.id AS id,
        COUNT(t_kta.id) AS total_aktif
        from t_kta 
          LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
          LEFT JOIN t_registrasi_users ON t_kta.id_registrasi_users = t_registrasi_users.id
          LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
          LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
          LEFT JOIN t_administrasi_kta ON t_administrasi_kta.id_detail_kta = t_detail_kta.id
          LEFT JOIN t_pj_kta ON t_pj_kta.id_detail_kta = t_detail_kta.id
      WHERE t_kta.status_kta = 0 
      AND t_detail_kta.is_inserted = 4
        GROUP BY provinsi.`name`
    ) s2 ON s1.id = s2.id
    
    LEFT JOIN (
        SELECT 
        provinsi.id AS id,
        COUNT(t_kta.id) AS total_berhenti
        from t_kta 
      LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
      LEFT JOIN t_app_kta  ON t_app_kta.id_detail_kta = t_detail_kta.id
      LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
        LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
      WHERE t_kta.status_kta = 2
      AND t_detail_kta.is_inserted = 4
        GROUP BY provinsi.`name`
    ) s3 ON s1.id = s3.id 
    
    LEFT JOIN (
        SELECT 
        provinsi.id AS id,
        COUNT(t_kta.id) as dikembalikan_dpp 
        FROM t_kta
        LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
      LEFT JOIN t_app_kta  ON t_app_kta.id_detail_kta = t_detail_kta.id
      LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
        LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id 
        WHERE t_app_kta.status_pengajuan = 1
        AND t_detail_kta.is_inserted = 4
        GROUP BY provinsi.`name`
    ) s4 ON s1.id = s4.id
    
    LEFT JOIN (
        SELECT 
        provinsi.id AS id,
        COUNT(t_kta.id) as dikembalikan_dpn 
        FROM t_kta
        LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
      LEFT JOIN t_app_kta  ON t_app_kta.id_detail_kta = t_detail_kta.id
      LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
        LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id 
        WHERE t_app_kta.status_pengajuan = 4
        AND t_detail_kta.is_inserted = 4
        GROUP BY provinsi.`name`
    ) s5 ON s1.id = s5.id
    
    LEFT JOIN (
        SELECT 
        provinsi.id AS id,
        COUNT(t_kta.id) as diproses_dpp 
        FROM t_kta 
      LEFT JOIN t_detail_kta ON t_detail_kta.id_kta = t_kta.id
      LEFT JOIN t_app_kta ON t_app_kta.id_detail_kta = t_detail_kta.id
      LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
        LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
      WHERE (t_app_kta.status_pengajuan = 0 OR t_app_kta.status_pengajuan = 2) 
      AND t_detail_kta.is_inserted = 4
        GROUP BY provinsi.`name`
    ) s6 ON s1.id = s6.id
    
    LEFT JOIN (
    SELECT 
        provinsi.id AS id,
        COUNT(t_kta.id) as diproses_dpn 
    FROM t_kta 
    INNER JOIN t_detail_kta ON t_detail_kta.id_kta = t_kta.id
    INNER JOIN t_app_kta ON t_app_kta.id_detail_kta = t_detail_kta.id
    INNER JOIN t_dp ON t_kta.id_dp = t_dp.id
    LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
    WHERE (t_app_kta.status_pengajuan = 3 OR t_app_kta.status_pengajuan = 5 OR t_app_kta.status_pengajuan = 6) 
    AND t_detail_kta.is_inserted = 4
    GROUP BY provinsi.`name`
    ) s7 ON s1.id = s7.id");
        

        if($data_send) {
            return Excel::download(new DashboardAdministratorExport($data_send), "report_anggota_inkindo-".date('Y-m-d').".xlsx");
        }

        throw new Exception('Terjadi kesalahan');
        
    }

    public function exportToPdf()
    {


            $data_report_table = \App\Provinsi::orderBy('kd_provinsi','asc')->get();
            $tot = count($data_report_table);
            
            $data_send = [];
            foreach ($data_report_table as $key => $value) {
                # code...

                if($value['kd_provinsi'] == "31")
                {
                    continue;
                }

                $data_send[$value['kd_provinsi']] = ['id'=>$value['id'], 'name'=>$value['name'] ,'kd_provinsi'=>$value['kd_provinsi'] ];


            }
            $invite = ['id'=>100, 'name'=>'Afiliasi' ,'kd_provinsi'=>31];
            array_push($data_send,$invite);
            // dd($data_send);


            // dd($data);



                //     $data_report_table    = DB::select("SELECT 
                //     s1.nama_provinsi AS nama_provinsi,
                //     (CASE WHEN s2.total_aktif IS NOT NULL THEN s2.total_aktif ELSE 0 END) AS total_aktif,
                //     (CASE WHEN s3.total_berhenti IS NOT NULL THEN s3.total_berhenti ELSE 0 END) AS total_berhenti,
                //     (CASE WHEN s4.dikembalikan_dpp IS NOT NULL THEN s4.dikembalikan_dpp ELSE 0 END) AS dikembalikan_dpp,
                //     (CASE WHEN s5.dikembalikan_dpn IS NOT NULL THEN s5.dikembalikan_dpn ELSE 0 END) AS dikembalikan_dpn,
                //     (CASE WHEN s6.diproses_dpp IS NOT NULL THEN s6.diproses_dpp ELSE 0 END) AS diproses_dpp,
                //     (CASE WHEN s7.diproses_dpn IS NOT NULL THEN s7.diproses_dpn ELSE 0 END) AS diproses_dpn
                // FROM(
                //     SELECT provinsi.id as id, provinsi.name AS nama_provinsi
                //     from provinsi
                // ) s1
                
                // LEFT JOIN (
                //     SELECT 
                //     provinsi.id AS id,
                //     COUNT(t_kta.id) AS total_aktif
                //     from t_kta 
                //       LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
                //       LEFT JOIN t_registrasi_users ON t_kta.id_registrasi_users = t_registrasi_users.id
                //       LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
                //       LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
                //       LEFT JOIN t_administrasi_kta ON t_administrasi_kta.id_detail_kta = t_detail_kta.id
                //       LEFT JOIN t_pj_kta ON t_pj_kta.id_detail_kta = t_detail_kta.id
                //   WHERE t_kta.status_kta = 0 
                //   AND t_detail_kta.is_inserted = 4
                //     GROUP BY provinsi.`name`
                // ) s2 ON s1.id = s2.id
                
                // LEFT JOIN (
                //     SELECT 
                //     provinsi.id AS id,
                //     COUNT(t_kta.id) AS total_berhenti
                //     from t_kta 
                //   LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
                //   LEFT JOIN t_app_kta  ON t_app_kta.id_detail_kta = t_detail_kta.id
                //   LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
                //     LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
                //   WHERE t_kta.status_kta = 2
                //   AND t_detail_kta.is_inserted = 4
                //     GROUP BY provinsi.`name`
                // ) s3 ON s1.id = s3.id 
                
                // LEFT JOIN (
                //     SELECT 
                //     provinsi.id AS id,
                //     COUNT(t_kta.id) as dikembalikan_dpp 
                //     FROM t_kta
                //     LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
                //   LEFT JOIN t_app_kta  ON t_app_kta.id_detail_kta = t_detail_kta.id
                //   LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
                //     LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id 
                //     WHERE t_app_kta.status_pengajuan = 1
                //     AND t_detail_kta.is_inserted = 4
                //     GROUP BY provinsi.`name`
                // ) s4 ON s1.id = s4.id
                
                // LEFT JOIN (
                //     SELECT 
                //     provinsi.id AS id,
                //     COUNT(t_kta.id) as dikembalikan_dpn 
                //     FROM t_kta
                //     LEFT JOIN t_detail_kta on t_detail_kta.id_kta = t_kta.id
                //   LEFT JOIN t_app_kta  ON t_app_kta.id_detail_kta = t_detail_kta.id
                //   LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
                //     LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id 
                //     WHERE t_app_kta.status_pengajuan = 4
                //     AND t_detail_kta.is_inserted = 4
                //     GROUP BY provinsi.`name`
                // ) s5 ON s1.id = s5.id
                
                // LEFT JOIN (
                //     SELECT 
                //     provinsi.id AS id,
                //     COUNT(t_kta.id) as diproses_dpp 
                //     FROM t_kta 
                //   LEFT JOIN t_detail_kta ON t_detail_kta.id_kta = t_kta.id
                //   LEFT JOIN t_app_kta ON t_app_kta.id_detail_kta = t_detail_kta.id
                //   LEFT JOIN t_dp ON t_kta.id_dp = t_dp.id
                //     LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
                //   WHERE (t_app_kta.status_pengajuan = 0 OR t_app_kta.status_pengajuan = 2) 
                //   AND t_detail_kta.is_inserted = 4
                //     GROUP BY provinsi.`name`
                // ) s6 ON s1.id = s6.id
                
                // LEFT JOIN (
                // SELECT 
                //     provinsi.id AS id,
                //     COUNT(t_kta.id) as diproses_dpn 
                // FROM t_kta 
                // INNER JOIN t_detail_kta ON t_detail_kta.id_kta = t_kta.id
                // INNER JOIN t_app_kta ON t_app_kta.id_detail_kta = t_detail_kta.id
                // INNER JOIN t_dp ON t_kta.id_dp = t_dp.id
                // LEFT JOIN provinsi ON t_dp.id_provinsi = provinsi.id
                // WHERE (t_app_kta.status_pengajuan = 3 OR t_app_kta.status_pengajuan = 5 OR t_app_kta.status_pengajuan = 6) 
                // AND t_detail_kta.is_inserted = 4
                // GROUP BY provinsi.`name`
                // ) s7 ON s1.id = s7.id");


            if($data_send) {
                return (new DashboardAdministratorExport($data_send))->download("report_anggota_inkindo-".date('Y-m-d').".pdf", \Maatwebsite\Excel\Excel::DOMPDF);
            }

            throw new Exception('Terjadi kesalahan');
    }
        
}
