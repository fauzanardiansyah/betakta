<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use App\DataDokumenPendukungBadanUsaha;
use App\HistoryApprovalPengajuan;
use App\UsersDppDpn;
use App\DetailKta;
use App\Kta;
use DB;
use Session;
use Validator;
use Notification;

class ExtendKtaController extends Controller
{
    public function index($id)
    {
        return view('backend/anggota/content-pages/status/extend.formPerpanjang');
    }

    public function extendPeriodWithNoUpdate(Request $request)
    {
        $validator = Validator::make(Input::all(), [
              'file_kta'                    => 'required|file|mimes:pdf|max:2048',
              'surat_permohonan_perpanjang' => 'required|file|mimes:pdf|max:2048',
            ]);
  
        if (!$validator->fails()) {
            $detailKta = DetailKta::findOrFail($request->id_detail_kta);
            dd($detailKta);
                
            $detailKta->jenis_pengajuan = 3;

            $detailKta->waktu_pengajuan = date('Y-m-d H:i:s');

            $detailKta->masa_berlaku    = (substr($detailKta->masa_berlaku, 0, 4)+1).'-12-31';

            $detailKta->view_notifikasi = 0;

            if ($detailKta->save() === true) {
                $kta = Kta::findOrFail($detailKta->id_kta);
                $until_date_format =  date('Y-m-d', strtotime($kta->registration_until_date));
    
                $update_kta = Kta::where('id', $detailKta->id_kta)->update([
                    'registration_until_date' => date('Y-m-d', strtotime('+ '.$kta->sisa_bulan.' month', strtotime($until_date_format)))
                ]);

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
                
                    $council =  UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                    
                    $notificationData = [
                        'id_dp' => $user->kta->id_dp,
                        'message' => 'Anda memiliki 1 pengajuan baru'
                    ];

                    Notification::send($council, new NotifyCouncil($notificationData));

                    return redirect()->route('anggota.status.main')->with('successExtend', 'Berhasil Melakukan Perpanjangan Karatu Tanda Anggota');
                }
            }
        } else {
            return redirect()->back()
              ->withErrors($validator)
              ->withInput();
        }
    }


    
}
