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

        $get_data = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)->first();
        $get_kta = \DB::table('t_kta as a')
        ->join('t_detail_kta as b','a.id','b.id_kta')
        ->where('b.id',$id_detail_kta)
        ->first();
        // $get_kta_detail = DetailKta::where('id',$id_detail_kta)->first();
        // $get_kta = Kta::where('id',$get_detail)->first();
        // dump($get_data);
        // dd($get_kta);
        if($get_kta->jenis_pengajuan == 1)
        {
            $status_pengajuan = ($jenis_bu == 'pmdn') ? 6 : 5;    
        }
        else
        {
            $status_pengajuan = ($jenis_bu == 'pmdn') ? 8 : 5;    
        }
        
        $keterangan ='Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Pusat inkindo';
        
        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
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

    public function approveDokumenPindah($id_detail_kta)
    {
        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => 6,
                                                          'keterangan' => 'Pengajuan "PINDAH DPP" anda telah di setujui oleh Pengurus Pusat Inkindo, Mulai saat ini anda telah di nyatakan "PINDAH" keanggotaan.'
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeStatusKta = Kta::findOrFail($changeNotification->id_kta);
            $changeStatusKta->update(['status_kta' => 0,'id_dp'=>$changeNotification->provinsi_tujuan]);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpn.pindah_dpp')
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
                                                            'status_pengajuan' => 4,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpn.pindah_dpp')
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
        $status_pengajuan = 8;
        $keterangan ='Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang menunggu penerbitan invoice';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
                                                          ]);
        \App\InvoiceRoleShare::where('id_detail_kta',$id_detail_kta)
        ->update(['jml_tagihan_agt'=>0,'total_role_share'=>0,'status_pembayaran'=>0,'jml_tagihan_naik'=>0]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpn.naik_kualifikasi')
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
                                                            'status_pengajuan' => 4,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpn.naik_kualifikasi')
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
        $get_detail = DetailKta::find($id_detail_kta);
        // dd($get_detail);
        $get_data = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)->first();
        $status_pengajuan = 7;
        $keterangan ='Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang menunggu penerbitan invoice';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
                                                          ]);



        $kta = Kta::findOrFail($get_detail->id_kta);
        $get_kualifikasi = $kta->kualifikasi;
        $kualifikasi =  $kta->kualifikasi;
        if($get_kualifikasi == 'besar' and $get_detail->jenis_pengajuan == 7)
        {
            $kualifikasi =  'menengah';
        }
        elseif($get_kualifikasi == 'menengah' and $get_detail->jenis_pengajuan == 7)
        {
            $kualifikasi = 'kecil';
        }

        $updateKTA = $kta->update([
            'status_kta' => 0,
            'kualifikasi'=>$kualifikasi
        ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpn.turun_kualifikasi')
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
                                                            'status_pengajuan' => 4,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpn.turun_kualifikasi')
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
        $status_pengajuan = 7;
        $keterangan ='Dokumen anda telah di periksa dan di nyatakan "DI SETUJUI" oleh pihak Dewan Pengurus Provinsi inkindo, Saat ini sedang "SCREENING" oleh pihak Dewan Pengurus Nasional';

        $dataHitoryApproval = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
                                                      ->update([
                                                          'status_pengajuan' => $status_pengajuan,
                                                          'keterangan' => $keterangan
                                                          ]);
        if ($dataHitoryApproval) {
            $changeNotification = DetailKta::findOrFail($id_detail_kta);
            $changeNotification->view_notifikasi = 0;
            if ($changeNotification->save()) {
                return redirect()->route('dpn.index_edit_data')
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
                                                            'status_pengajuan' => 4,
                                                            'keterangan' => $request->keterangan
                                                            ]);
            if ($dataHitoryApproval) {
                $changeNotification = DetailKta::findOrFail($request->id_detail_kta);
                $changeNotification->view_notifikasi = 0;
                if ($changeNotification->save()) {
                    return redirect()->route('dpn.index_edit_data')
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
