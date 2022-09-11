<?php

namespace App\Http\Controllers\Backend\Dpp\MasterAnggota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use App\HistoryApprovalPengajuan;
use App\DetailKta;
use Validator;
use Notification;


class ApprovalAnggotaDokumenController extends Controller
{
    public function approveDokumenBuatBaru($id_detail_kta)
    {
        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => 2,
                                                          'keterangan' => 'Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang menunggu penerbitan invoice'
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpp.master-anggota.baru')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }

    
    public function rejectDokumenBuatBaru(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'keterangan'  => 'required|max:120',
        ]);

        if (!$validator->fails()) {
            $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)
                                                        ->update([
                                                            'status_pengajuan' => 1,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpp.master-anggota.baru')
                    ->with('successRejectDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
                }
            }
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }


    public function approveDokumenPemberhentian($id_detail_kta)
    {
        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => 3,
                                                          'keterangan' => 'Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang menunggu pengesahan oleh Dewan Pengurus Nasional Inkindo'
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
               
                $council =  \App\DewanPengurus::whereLevel(1)->first();
                $to      =  \App\UsersDppDpn::whereId_dp($council->id)->first();
                
                $notificationData = [
                    'id_dp' => $council->id,
                    'message' => 'Anda memiliki 1 pengajuan pemberhentian anggota'               
                ];

                Notification::send($to, new NotifyCouncil($notificationData));
                return redirect()->route('dpp.master-anggota.berhenti')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }


    public function rejectDokumenPemberhentian(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'keterangan'  => 'required|max:2000',
        ]);

        if (!$validator->fails()) {
            $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)
                                                        ->update([
                                                            'status_pengajuan' => 1,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpp.master-anggota.berhenti')
                    ->with('successRejectDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
                }
            }
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }


}
