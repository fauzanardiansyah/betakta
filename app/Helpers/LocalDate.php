<?php

namespace App\Helpers;

use Carbon\Carbon;

class LocalDate
{
	public static function toIndonesia($date)
	{
                // Carbon::setLocale('id_ID.utf8');//id kode untuk indonesia
                // $localDate = Carbon::parse($date)->translatedFormat('d F Y');
                // return $localDate;
        if($date == null)
        {
        	$date_ = date('Y-m-d');
        }
        else
        {
        	$date_ = $date;
        }
        $bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $date_); 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	} 

    public static function date_invoice_now($waktu_pengajuan)
	{

		// waktu rincian
	    // $month_from = date("F", mktime(0, 0, 0, 1, 10)) .'  ' .date("Y",strtotime($waktu_pengajuan));
		$month_from = date("F Y",strtotime($waktu_pengajuan));


	     // buat dapetin bulan pertama .untuk hitungan klo dia perpanjangan
	    $monthName = date("F", mktime(0, 0, 0, 12, 10)); 


	    // buat dapetin bulan ke 12 .untuk hitungan klo dia perpanjangan
	    $month_to = $monthName.' '.date("Y",strtotime($waktu_pengajuan));
		return '<small>'.$month_from .' - '.$month_to.'</small>';
	}


	public static function date_invoice_next($waktu_pengajuan)
	{

	    $month_from = date("F Y",strtotime($waktu_pengajuan));
		


		 //// buat dapetin bulan ke 7 jika dia lebih dari bulan juli
        $month_cut = strtotime( date("F", mktime(0, 0, 0, 7, 10)).date("Y",strtotime($waktu_pengajuan)) ) ; 
        //// buat dapetin bulan untuk perhitungan jika dia lebih dari bulan juli
        $get_month_now = strtotime($month_from);

        // tahun tambah 1 jika bulan lebih dari bulan juli 
        $year_plus = date("Y",strtotime($waktu_pengajuan)) + 1 ;   
        // jika  lebih dari bulan juli 
        $plus_from =strtotime( date("F", mktime(0, 0, 0, 1, 10)).$year_plus ) ;
        // jika  lebih dari bulan juli
        $plus_to =strtotime( date("F", mktime(0, 0, 0, 12, 10)).$year_plus ) ;


		if($month_cut < $get_month_now)
        {

            return '<br><small>'.date('F Y',$plus_from) .' - '.date('F Y',$plus_to).'</small>';
        }
        else
        {
        	return "";
        }
	}

	public static function get_contribution_now($cont,$time)
	{
		$iuran_bagi_kecil = $cont / 12;
        return $v_iuran = $iuran_bagi_kecil * $time;
	}

	public static function get_contribution_next($cont)
	{
		$iuran_bagi_kecil = $cont / 12;
		return $price_cut =$iuran_bagi_kecil * 12;
        
	}

	public static function get_detail_kta()
	{

          $get_data = \DB::table('t_registrasi_users as tru')
            ->join('t_kta as tk','tk.id_registrasi_users','tru.id')
            ->join('t_detail_kta as tdk','tdk.id_kta','tk.id')
            ->where('tru.id',\Session::get('id_registrasi_user'))
            ->whereNotNull('tk.no_kta')
            ->first();

           return $get_data;
        
	}

}