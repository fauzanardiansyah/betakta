<?php

namespace App\Http\Controllers\Backend\Dpn\MasterAnggota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\HistoryApprovalPengajuan;
use App\DetailKta;
use App\Kta;
use Validator;

class ApprovalAnggotaDokumenController extends Controller
{
    public function approveDokumenBuatBaru($jenis_bu, $id_detail_kta)
    {
        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => ($jenis_bu == 'pmdn') ? 6 : 5,
                                                          'keterangan' => 'Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Pusat inkindo'
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpn.master-anggota.baru')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }

    
    public function rejectDokumenBuatBaru(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'keterangan'  => 'required|max:2000',
        ]);

        if (!$validator->fails()) {
            $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)
                                                        ->update([
                                                            'status_pengajuan' => 4,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpn.master-anggota.baru')
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
                                                          'status_pengajuan' => 7,
                                                          'keterangan' => 'Pengajuan "PEMBERHENTIAN KEANGGOTAAN" anda telah di setujui oleh Pengurus Pusat Inkindo, Mulai saat ini anda telah di nyatakan "BERHENTI" dari ke anggotaan inkindo.'
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeStatusKta = Kta::findOrFail($changeNotification->id_kta);
            $changeStatusKta->update(['status_kta' => 2]);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpn.master-anggota.berhenti')
                  ->with('successApproveDokumenAnggota', 'Berhasil melakukan approval dokumen anggota');
            }
        }
    }


    public function rejectDokumenPemberhentian(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'keterangan'  => 'required|max:120',
        ]);

        if (!$validator->fails()) {
            $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $request->id_detail_kta)
                                                        ->update([
                                                            'status_pengajuan' => 4,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpn.master-anggota.berhenti')
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
