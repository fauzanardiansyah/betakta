<?php

namespace App\Http\Controllers\Backend\Dpp\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Notifications\NotifyCouncil;
use App\PaymentConfirmation;
use App\HistoryApprovalPengajuan;
use App\DetailKta;
use App\DewanPengurus;
use App\UsersDppDpn;
use Notification;
use DB;
use Session;

class PaymentAnggotaController extends Controller
{
    public function index()
    {
        return view('backend/dpp/content-pages/payment.anggota-payment');
    }

    public function getDataPaymentAnggota()
    {
        $dataPaymentAnggota = DB::table('t_payment_confirmation')
        ->join('t_invoice_kta', 't_payment_confirmation.id_invoice_kta', '=', 't_invoice_kta.id')
        ->join('t_detail_kta', 't_invoice_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
        ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
        ->select('t_payment_confirmation.*', 't_registrasi_users.nm_bu', 't_invoice_kta.status_pembayaran', 't_detail_kta.id as id_detail_kta', 't_app_kta.status_pengajuan')
        ->where('t_dp.id', '=', Session::get('id_dp'));
        
        
        
        return Datatables::of($dataPaymentAnggota)
        ->addColumn('action', function ($detailPaymnet) {
            return '
            <a href="#" class="btn btn-sm btn-default"  id="show-detail-payment" data-id-detail-kta="'.$detailPaymnet->id_detail_kta.'" data-id-payment="'.$detailPaymnet->id.'"  title="Show detail payment"><i class="fa fa-search"></i></a>
            <a href="'.route('dpp.payment.verify', ['id_detail_kta' => $detailPaymnet->id_detail_kta]).'" class="btn btn-sm btn-success"   data-id-payment="'.$detailPaymnet->id_detail_kta.'"  title="DPP Verified" '.($detailPaymnet->status_pembayaran == 0 ? "disabled" : "").'><i class="fa fa-check"></i></a>
            ';
        })

        ->editColumn('status_pembayaran', function ($status_pembayaran) {
            if ($status_pembayaran->status_pembayaran === 0) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-money'></i> pending</a>";
            }

            if ($status_pembayaran->status_pembayaran === 1) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-money'></i> paid</a>";
            }
        })

        ->editColumn('status_pengajuan', function ($status_pengajuan) {
            if ($status_pengajuan->status_pengajuan == 2) {
                return "<a class='btn btn-xs btn-default'><i class='fa fa-pdf-o'></i>Menunggu pembayaran terverifikasi</a>";
            }

            if ($status_pengajuan->status_pengajuan == 3) {
                return "<a class='btn btn-xs btn-success'><i class='fa fa-check'></i> Di periksa oleh dpn</a>";
            }

            if ($status_pengajuan->status_pengajuan == 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di tolak oleh dpn</a>";
            }

            if ($status_pengajuan->status_pengajuan == 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu nomor KTA</a>";
            }

            if ($status_pengajuan->status_pengajuan == 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selsai</a>";
            }

           
        })

        ->editColumn('nominal', function ($nominal) {
            return "IDR.".$nominal->nominal;
        })
        ->rawColumns(['action', 'nominal', 'status_pembayaran','status_pengajuan'])
        ->make(true);
    }

    public function getDetailDataPaymentAnggota(Request $request)
    {
        $idPayment = $request->idPayment;

        $dataPaymentAnggota = PaymentConfirmation::findOrfail($idPayment);
        return response()->json($dataPaymentAnggota, 200);
    }

    public function acceptPaymentAnggota(Request $request)
    {
        $idDetailKta = $request->idDetailKta;
        $idPayment = $request->idPayment;

        $paymentConfirmation = PaymentConfirmation::findOrFail($idPayment);
        $updataStatusPembayaran = $paymentConfirmation->invoice()->update([
            'status_pembayaran' => 1
        ]);

        if ($updataStatusPembayaran) {
            DetailKta::findOrFail($idDetailKta)
            ->update([
                'view_notifikasi' => 0,
            ]);
            HistoryApprovalPengajuan::where('id_detail_kta', $idDetailKta)
            ->update([
                'keterangan' => 'Pembayaran anda telah terverifikasi oleh team KTA inkindo, Silahkan menunggu team KTA DPP inkindo menyelsaikan pengajuan anda',
            ]);
            return response()->json(['success' => $updataStatusPembayaran], 200);
        }
    }


    public function dppVerifiyAnggota($id_detail_kta)
    {
        $anggotaVerify = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
        ->update([
                'status_pengajuan' => 3,
                'keterangan'       => 'Pengajuan anda telah di verifikasi oleh Dewan Pengurus Provinsi, Untuk selanjutnya akan di lanjutkan ke Dewan Pengurus Pusat untuk di verifikasi dan penerbitan Kartu Tanda Anggota',
                ]);

        if ($anggotaVerify) {
            $notification = DetailKta::findOrFail($id_detail_kta)
                    ->update(['view_notifikasi' => 0]);
            if ($notification) {
                $council =  DewanPengurus::whereLevel(1)->first();
                $to      =  UsersDppDpn::whereId_dp($council->id)->first();
                
                $notificationData = [
                    'id_dp' => $council->id,
                    'message' => 'Anda memiliki 1 pengajuan baru'               
                ];

                Notification::send($to, new NotifyCouncil($notificationData));
                return redirect()->back()->with('successVerifyAnggota', 'Berhasil');
            }
        } else {
            abort(404);
        }
    }


   
}
