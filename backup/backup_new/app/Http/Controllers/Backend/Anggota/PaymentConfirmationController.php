<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use Illuminate\Support\Facades\Input;
use App\InvoicePengajuanKta;
use App\PaymentConfirmation;
use Notification;
use Validator;
use Session;

class PaymentConfirmationController extends Controller
{
    public function checkNoInvoiceAnggota(Request $request)
    {
        $noInvoice = $request->no_invoice;

        $dataInvoice = InvoicePengajuanKta::where('no_invoice', $noInvoice)->first();
        
        if(!empty($dataInvoice)) {
            return "<small style='color:green'>Invoice  Found</small>";
        } else {
            return "<small style='color:red'>Invoice Not Found</small>";
        }


    }


    public function saveConfirmationPayment(Request $request)
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

                $user  = \App\Kta::whereId_registrasi_users(Session::get('id_registrasi_user'))->first();
                $council =  \App\UsersDppDpn::whereId_dp($user->id_dp)->first();  
                
                $notificationData = [
                    'id_dp' => $user->id_dp,
                    'message' => 'Anda memiliki 1 pembayaran anggota'               ];

                // Notification::send($council, new NotifyCouncil($notificationData));
                
                return response()->json(['success'=>'Pembayaran anda akan di proses oleh team KTA inkindo, dan akan di beritahukan apabila di nyatakan Terverifikasi']);
            } 
            
            
        } else {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }
    }
}
