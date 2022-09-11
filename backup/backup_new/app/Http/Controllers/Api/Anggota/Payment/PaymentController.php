<?php

namespace App\Http\Controllers\Api\Anggota\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use App\PaymentConfirmation;
use Validator;
use Notification;

class PaymentController extends Controller
{
    public function confirmationPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_invoice'       => 'required|max:191',
            'nominal'          => 'required|max:11',
            'atas_nama'        => 'required|max:50',
            'nama_bank_anda'   => 'required|max:20',
            'upload_bukti_trf' => 'required|file|mimes:jpeg,jpg|max:2048'
        ]);

        if(!$validator->fails()) {
            $extension = $request->file('upload_bukti_trf')->getClientOriginalExtension();
            $dir = 'public/bukti-transfer';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('upload_bukti_trf')->storeAs($dir, $filename);
            
            $savePayment = PaymentConfirmation::create([
            'id_invoice_kta' => $request->id_invoice_kta,
            'no_invoice' => $request->no_invoice,
            'nominal'    => $request->nominal,
            'atas_nama'  => $request->atas_nama,
            'nama_bank_anda' => $request->nama_bank_anda,
            'upload_bukti_trf' => $filename
            ]);

            if($savePayment) {

                $invoice = \App\InvoicePengajuanKta::where('no_invoice', $request->no_invoice)->first();
                
                $user  = \App\DetailKta::with('kta')->whereId($invoice->id_detail_kta)->first();
                
                $council =  \App\UsersDppDpn::whereId_dp($user->kta->id_dp)->first();  
                
                $notificationData = [
                    'id_dp' => $user->kta->id_dp,
                    'message' => 'Anda memiliki 1 pembayaran anggota'               ];

                Notification::send($council, new NotifyCouncil($notificationData));
                
                return response()->json([
                    'message'=>'Pembayaran anda akan di proses oleh team KTA inkindo, dan akan di beritahukan apabila di nyatakan Terverifikasi',
                    'status' => 200
                    ]);
            } 
            
            
        } else {
            return response()->json([
                'message' => 'Gagal melakukan konfirmasi pembayaran',
                'errors'=>$validator->errors()->all(),
                'status' => 422
            ], 422);
        }
    }
}
