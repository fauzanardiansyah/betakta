<?php

namespace App\Http\Controllers\Api\Anggota\Extend\NonUpdate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use App\DataAdministrasiBadanUsaha;
use App\DataPenanggungJawabBadanUsaha;
use App\Kta;
use App\DetailKta;
use App\DataLegalitasBadanUsaha;
use App\HistoryApprovalPengajuan;
use App\DataDokumenPendukungBadanUsaha;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use Validator;
use Notification;

class ExtendNonUpdateProcessController extends Controller
{

    public function extendPeriodWithNoUpdate(Request $request)
    {
        $validator = Validator::make(Input::all(), [
              'file_kta' => 'required|file|mimes:pdf|max:2048',
              'surat_permohonan_perpanjang' => 'required|file|mimes:pdf|max:2048',
            ]);
  
        if (!$validator->fails()) {
            $detailKta = DetailKta::findOrFail($request->id_detail_kta);
                
            $detailKta->jenis_pengajuan = 3;

            $detailKta->waktu_pengajuan = date('Y-m-d H:i:s');

            $detailKta->masa_berlaku    = (substr($detailKta->masa_berlaku, 0, 4)+1).'-12-31';

            $detailKta->view_notifikasi = 0;

            if ($detailKta->save() === true) {
                $kta = Kta::findOrFail($detailKta->id_kta);

                $appKta  = HistoryApprovalPengajuan::whereId_detail_kta($request->id_detail_kta)->first();

                $appKta->tgl_status = date('Y-m-d H:i:s');

                $appKta->status_pengajuan  = ($kta->jenis_bu === 'pmdn') ? 0 : 3 ;

                $appKta->keterangan = "Dokumen pengajuan perpanjangan anda telah memasuki fase 'Screening' oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya";
                     
                if ($appKta->update() == true) {
                    $file_kta = $request->file('file_kta')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');
                    $surat_permohonan_perpanjang = $request->file('surat_permohonan_perpanjang')->storeAs('public/legalitas-files', Uuid::uuid4().'.pdf');

                    $oldKta   = DataDokumenPendukungBadanUsaha::whereId_detail_kta($request->id_detail_kta)->first();
                   
                    $oldKta->file_kta = substr($file_kta, 23);

                    $oldKta->surat_permohonan_perpanjang = substr($surat_permohonan_perpanjang, 23);
                   
                    $oldKta->update();

                    $user  = \App\DetailKta::with('kta')->whereId($request->id_detail_kta)->first();
                
                    $council =  \App\UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                    
                    $notificationData = [
                        'id_dp' => $user->kta->id_dp,
                        'message' => 'Anda memiliki 1 pengajuan baru'
                    ];

                    Notification::send($council, new NotifyCouncil($notificationData));

                    return response()->json([
                        'message' => 'Berhasil melakukan pengajuan perpanjangan Kartu Tanda Anggota badan usaha',
                        'status' => 200,
                   ], 200);
                } else {
                    return response()->json([
                        'message' => 'Gagal melakukan pengajuan perpanjangan Kartu Tanda Anggota badan usaha',
                        'status' => 400,
                        'redirect' => [
                            'url' => redirect()->back(),
                            'method' => 'PUT'
                        ]
                   ], 400);
                }
            }
        } else {
            return response()->json([
                'errors' => $validator->errors()->all() 
            ]);
        }
    }
}
