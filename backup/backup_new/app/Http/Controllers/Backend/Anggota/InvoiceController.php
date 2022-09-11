<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\InvoicePengajuanKta;
use App\DewanPengurus;
use App\PaymentConfirmation;
use DB;
use Session;
use PDF;

class InvoiceController extends Controller
{
    
    public function index()
    {
        return view('backend/anggota/content-pages/invoice.anggota-invoice');
    }

    public function getAnggotaInvoice()
    {
        $invoicePublished = DB::table('t_invoice_kta')
        ->join('t_detail_kta', 't_invoice_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->select('t_invoice_kta.*', 't_registrasi_users.nm_bu', 't_detail_kta.jenis_pengajuan', 't_kta.id_dp', 't_detail_kta.id as id_detail_kta', 
                  't_invoice_kta.jenis_pengajuan')
        ->where('t_registrasi_users.id', '=', Session::get('id_registrasi_user'));
        
        
        return Datatables::of($invoicePublished)
        ->addColumn('action', function ($invoice) {
            if($invoice->jenis_pengajuan == 1 OR $invoice->jenis_pengajuan == 4  ) :
                return '<a class="btn btn-sm btn-default"  id="publish-member-invoice"  title="No payment required for this invoice" disabled>no payment required</a>';
            else :
                return '<a href="'. route('anggota.invoice.detail', ['no_invoice' => $invoice->no_invoice, 'id_detail_kta' => $invoice->id_detail_kta]) .'" class="btn btn-sm btn-default"  id="publish-member-invoice"  title="Pay this invoice">make payment</a>';
            endif;
        })

        ->editColumn('jenis_pengajuan', function ($jenis_pengajuan) {
            if ($jenis_pengajuan->jenis_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'>buat baru</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 1) {
                return "<a class='btn btn-xs btn-success'>daftar ulang</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 3) {
                return "<a class='btn btn-xs btn-warning'>perpanjang</a>";
            }
        })

       

        ->editColumn('status_pembayaran', function ($status_pembayaran) {
            if ($status_pembayaran->status_pembayaran === 0) {
                return "<a class='btn btn-xs btn-warning'>pending</a>";
            }

            if ($status_pembayaran->status_pembayaran === 1) {
                return "<a class='btn btn-xs btn-success'>paid</a>";
            }
        })

        ->editColumn('jml_tagihan', function ($jml_tagihan) {
            return "IDR.".number_format($jml_tagihan->jml_tagihan);    
        })

        ->editColumn('tgl_cetak', function ($tgl_cetak) {
            return $tgl_cetak->tgl_cetak;   
        })
        ->rawColumns(['action', 'jenis_pengajuan', 'status_pembayaran'])
        ->make(true);
    }


    public function showInvoiceDetail($noInvoice, $idDetailKta)
    {
        $dataInvoice = InvoicePengajuanKta::where('no_invoice', $noInvoice)->first();

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->select('t_kta.jenis_bu','t_kta.kualifikasi', 't_detail_kta.jenis_pengajuan', 't_registrasi_users.email_bu',
                       't_registrasi_users.nm_bu', 't_detail_kta.masa_berlaku', 't_kta.id_dp',
                       't_administrasi_kta.alamat',
                       't_administrasi_kta.no_telp',
                       't_detail_kta.id as id_detail_kta',
                       't_kta.sisa_bulan',
                        't_detail_kta.waktu_pengajuan'
                          )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
        
        $pengurus    = DewanPengurus::find($pengajuan->id_dp);
        $countPaymentConfirm = count(PaymentConfirmation::where('no_invoice', $noInvoice)->get());
        // dd($countPaymentConfirm);
       // dd($pengurus);
        if($dataInvoice && $pengajuan && $pengurus) {
            $dataInvoiceAnggota = [
                'invoice' => $dataInvoice,
                'kta'     => $pengajuan,
                'pengurus' => $pengurus,
                'countPaymentConfirm' => $countPaymentConfirm,
            ];
            return view('backend/anggota/content-pages/invoice.anggota-invoice-template', compact('dataInvoiceAnggota'));
        } else {
            abort(404);
        }
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
                          't_kta.jenis_bu',
                          't_kta.id_dp',
                          't_detail_kta.jenis_pengajuan',
                          't_registrasi_users.email_bu',
                          't_registrasi_users.nm_bu',
                          't_detail_kta.masa_berlaku',
                          't_administrasi_kta.alamat',
                          't_administrasi_kta.no_telp',
                          't_detail_kta.id as id_detail_kta',
                          't_kta.sisa_bulan',
                          't_detail_kta.waktu_pengajuan'

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
            return "gagal";
        }

       
    }
}
