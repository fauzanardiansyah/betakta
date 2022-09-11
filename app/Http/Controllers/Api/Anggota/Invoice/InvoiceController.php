<?php

namespace App\Http\Controllers\Api\Anggota\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InvoicePengajuanKta;
use App\DewanPengurus;
use PDF;
use DB;

class InvoiceController extends Controller
{
    public function index($id_registrasi_user)
    {
        $invoicePublished = DB::table('t_invoice_kta')
        ->join('t_detail_kta', 't_invoice_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->select('t_invoice_kta.*', 't_registrasi_users.nm_bu', 't_detail_kta.jenis_pengajuan', 't_kta.id_dp', 't_detail_kta.id as id_detail_kta', 
                  't_invoice_kta.jenis_pengajuan')
        ->where('t_registrasi_users.id', '=', $id_registrasi_user)
        ->get();

        if(count($invoicePublished) > 0) {

            foreach($invoicePublished as $invoicePublished_item) { 
                $data_invoice[] = [
                    "id" => $invoicePublished_item->id,
                    "id_detail_kta" =>$invoicePublished_item->id_detail_kta,
                    "no_invoice" => $invoicePublished_item->no_invoice,
                    "jenis_pengajuan" => $invoicePublished_item->jenis_pengajuan,
                    "jml_tagihan" => $invoicePublished_item->jml_tagihan,
                    "tgl_cetak" => $invoicePublished_item->tgl_cetak,
                    "status_pembayaran" => $invoicePublished_item->status_pembayaran,
                    "created_at" => $invoicePublished_item->created_at,
                    "updated_at" => $invoicePublished_item->updated_at,
                    "nm_bu" => $invoicePublished_item->nm_bu,
                    "id_dp" => $invoicePublished_item->id_dp,
                    "download_invoice" => route('api.invoice.download-invoice-member', ['no_invoice' => $invoicePublished_item->no_invoice, 'id_detail_kta' => $invoicePublished_item->id_detail_kta]),
                ];
            }
               $data = [
                    'data' => $data_invoice,
                    'message' => 'Data invoice anggota',
                    'status' => 200
                ];
    
                return response()->json($data, 200);
            
            
        }

        $data = [
            'data' => $invoicePublished,
            'message' => 'Data invoice anggota tidak di temukan',
            'status' => 404
        ];

        return response()->json($data, 404);


        
    
    }


    public function downloadInvoice($noInvoice, $idDetailKta)
    {
        $dataInvoice = InvoicePengajuanKta::where('no_invoice', $noInvoice)->first();

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->select(
                          't_kta.kualifikasi',
                          't_kta.id_dp',
                          't_detail_kta.jenis_pengajuan',
                          't_registrasi_users.email_bu',
                          't_registrasi_users.nm_bu',
                          't_detail_kta.masa_berlaku',
                          't_administrasi_kta.alamat',
                          't_administrasi_kta.no_telp',
                          't_detail_kta.id as id_detail_kta'
                      )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
        
        $pengurus    = DewanPengurus::find($pengajuan->id_dp);

        if ($dataInvoice && $pengajuan && $pengurus) {
            $dataInvoiceAnggota = [
                'invoice' => $dataInvoice,
                'kta'     => $pengajuan,
                'pengurus' => $pengurus
            ];
            $pdf = PDF::loadView('prints-template.invoice-anggota', compact('dataInvoiceAnggota'))->setPaper('a4', 'landscape');
            return $pdf->stream('invoice |'.$pengajuan->nm_bu.'.pdf');
        } else {
            return response()->json([
                'message' => 'Gagal mendownload invoice',
                'status' => 404
            ], 404);
        }
    }
}
