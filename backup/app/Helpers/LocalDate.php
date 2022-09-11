<?php

namespace App\Helpers;

use Carbon\Carbon;

class LocalDate
{
	public static function toIndonesia($date)
	{
                Carbon::setLocale('id_ID.utf8');//id kode untuk indonesia
                $localDate = Carbon::parse($date)->translatedFormat('d F Y');
                return $localDate;
	} 
}