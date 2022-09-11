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

        $get_data = DetailKta::where('id', $id_detail_kta)->first();
        if($get_data->status_pengajuan == 1)
        {
            $status_pengajuan = 2;
        }
        else
        {
            $status_pengajuan = 2;
        }

        $keterangan ='Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang menunggu penerbitan invoice';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
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



     
    public function approveDokumenPindah($id_detail_kta)
    {

        $get_data = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)->first();
        
        if($get_data->status_pengajuan == 11 )
        {
            $status_pengajuan = 7;
        }
        else
        {
            $status_pengajuan = 3;
        }
        $keterangan ='Dokumen "Pindah" anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang "SCREENING" oleh pihak Dewan Pengurus Nasional';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpp.pindah_dpp')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }

    public function rejectDokumenPindah(Request $request)
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
                    return redirect()->route('dpp.pindah_dpp')
                    ->with('successRejectDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
                }
            }
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }


    
    public function approveDokumenNaikKualifikasi($id_detail_kta)
    {

        $get_data = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)->first();
        $status_pengajuan = 2;
        $keterangan ='Dokumen "Naik Kualifikasi" anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang menunggu penerbitan invoice';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpp.naik_kualifikasi')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }

    public function rejectDokumenNaikKualifikasi(Request $request)
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
                    return redirect()->route('dpp.naik_kualifikasi')
                    ->with('successRejectDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
                }
            }
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    
    public function approveDokumenTurunKualifikasi($id_detail_kta)
    {

        $get_data = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)->first();
        $status_pengajuan = 3;
        $keterangan ='Dokumen "Turun Kualifikasi" anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang menunggu penerbitan invoice';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpp.turun_kualifikasi')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }

    public function rejectDokumenTurunKualifikasi(Request $request)
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
                    return redirect()->route('dpp.turun_kualifikasi')
                    ->with('successRejectDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
                }
            }
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }


    public function approveDokumenEditData($id_detail_kta)
    {

        $get_data = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)->first();
        $status_pengajuan = 3;
        $keterangan ='Dokumen "EDIT" anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang "SCREENING" oleh pihak Dewan Pengurus Nasional';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpp.index_edit_data')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }

    public function rejectDokumenEditData(Request $request)
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
                    return redirect()->route('dpp.index_edit_data')
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
