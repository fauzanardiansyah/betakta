<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DetailKta;

class AnggotaNotifyController extends Controller
{
    /**
     * Get notification for member
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $idDetailKta = DetailKta::findOrFail($request->id_detail_kta);

        $idDetailKta->view_notifikasi = 1;

        if($idDetailKta->save()) {
            return redirect()->route('anggota.status.main');
        }
    }
}
