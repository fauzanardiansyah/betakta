<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Notifications\NotifyCouncil;
use Ramsey\Uuid\Uuid;
use App\Kta;
use App\DetailKta;
use App\HistoryApprovalPengajuan;
use Validator;
use Notification;

class StopKtaController extends Controller
{
    public function index($idDetailKta)
    {
        $getIdKta = DetailKta::findOrFail($idDetailKta);
        return view('backend/anggota/content-pages/status/stop.formPemberhentian', compact('getIdKta'));
    }

    public function stopBeingMember(Request $request)
    {
        $validator = Validator::make(Input::all(), [

                'dokumen_pemberhentian'   => 'required|file|mimes:pdf|max:2048',

                'keterangan'              => 'required|string|max:500',

            ]);

        if (!$validator->fails()) {
            $getLastKta             = Kta::findOrFail($request->id_kta);

            $dokumenPemberhentian   = $request->file('dokumen_pemberhentian')->storeAs('public/dokumen-pemberhentian', Uuid::uuid4().'.pdf');

            if ($detailKta = DetailKta::findOrfail($request->id_detail_kta)) {
                $dataDetailKta = [
                    'id_kta' => $detailKta->id_kta ,
                    'jenis_pengajuan' => 4,
                    'waktu_pengajuan' => date('Y-m-d H:i:s'),
                    'tgl_terbit' => $detailKta->tgl_terbit,
                    'masa_berlaku' => $detailKta->masa_berlaku,
                    'view_notifikasi' => 0,
                    'is_inserted' => 4
                ];

               

                if ($detailKta->update($dataDetailKta)) {
                    $detailKta->historyApps()->update([
                        'status_pengajuan' => $stsPengajuan = ($getLastKta->jenis_bu === 'pmdn') ? 0 : 3 ,
                        'tgl_status'       => date('Y-m-d H:i:s'),
                        'keterangan'       => 'Dokumen pengajuan pemberhentian anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.',
                    ]);

                    $detailKta->pemberhentianAgt()->create([
                        'file_pemberhentian' => substr($dokumenPemberhentian, 29) ,
                        'keterangan'         => $request->keterangan
                    ]);

                    $user  = \App\DetailKta::with('kta')->whereId($request->id_detail_kta)->first();
                    $council =  \App\UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                    
                    $notificationData = [
                        'id_dp' => $user->kta->id_dp,
                        'message' => 'Anda memiliki 1 pengajuan pemberhentian anggota'
                    ];

                    Notification::send($council, new NotifyCouncil($notificationData));

                    return redirect()->route('anggota.status.main')->with('successStopMember', 'Dokumen pengajuan pemberhentian anda akan kami proses');
                }
            }
        } else {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
    }
}
