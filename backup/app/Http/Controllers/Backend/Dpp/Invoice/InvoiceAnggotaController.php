<?php

namespace App\Http\Controllers\Backend\Dpp\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendInvoiceAnggotaMail as SendInvoiceAnggotaMail;
use App\Notifications\NotifyCouncil;
use App\InvoicePengajuanKta;
use App\DewanPengurus;
use App\HistoryApprovalPengajuan;
use App\DetailKta;
use App\InvoiceRoleShare;
use App\RoleShareConfirmation;
use App\RoleShareAccumulation;
use App\UsersDppDpn;
use Yajra\Datatables\Datatables;
use Ramsey\Uuid\Uuid;
use Validator;
use Notification;
use DB;
use Session;
use PDF;

class InvoiceAnggotaController extends Controller
{
    protected $keteranganUlang;
    
    protected $keteranganBaru;

    protected $jml_tagihan;

    public function __construct()
    {
        $this->keteranganUlang = 'Untuk pengajuan "PENDAFTARAN ULANG/PEMBERHENTIAN" tidak di kenakan biaya apapun, dan akan di tindak lanjuti oleh team DPN inkindo';
        $this->keteranganBaru = 'Invoice anda telah di terbitkan, Silhakan lihat pada menu "INVOICE"';
    }

    public function index()
    {
        return view('backend/dpp/content-pages/invoice.anggota-invoice');
    }

    public function getInvoiceAnggota()
    {
        $anggota = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->where('t_kta.id_dp', '=', Session::get('id_dp'))
        ->where('t_detail_kta.jenis_pengajuan', '!=', 4)
        ->where('t_detail_kta.is_inserted', '=', 4)
        ->select(['t_detail_kta.id as id_detail_kta', 't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                  't_kta.kualifikasi', 't_detail_kta.waktu_pengajuan', 't_app_kta.status_pengajuan']);
        
    

        return Datatables::of($anggota)
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
        ->addColumn('status', function ($status_pengajuan) {
            if ($status_pengajuan->status_pengajuan === 0) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 2) {
                return '<a class="btn btn-xs btn-warning">Terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 1) {
                return '<a class="btn btn-xs btn-danger">Di tolak</a>';
            } elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">Selesai</a>';
            } else {
                return '<a class="btn btn-xs btn-warning">Terverifikasi</a>';
            }
        })
        ->addColumn('action', function ($kta) {
            if ($kta->status_pengajuan == 7) :
                return '<a href="#" class="btn btn-sm btn-success"   title="Finish" disabled>FINISH</a>'; elseif ($kta->status_pengajuan == 0) :
                return '<a href="#" class="btn btn-sm btn-success"   title="Can`t publish" disabled>PUBLISH</a>'; else :
                return '<a href="#" class="btn btn-sm btn-success" data-id-detail-kta="'.$kta->id_detail_kta.'" id="publish-member-invoice"  title="Publish invoice for this member">PUBLISH</a>';
            endif;
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan'])
        ->make(true);
    }


    public function publishInvoiceAnggota(Request $request)
    {
        $idDetailKta = $request->id_detail_kta;

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->select(
                          't_kta.kualifikasi',
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
        
        $tagihan     = DewanPengurus::find(Session::get('id_dp'));

        // Tagihan buat baru
        if ($pengajuan->kualifikasi == 'kecil' and $pengajuan->jenis_pengajuan == 0) {
            $this->jml_tagihan = ($tagihan->iuran_1_thn_kecil + $tagihan->uang_pangkal);
        } elseif ($pengajuan->kualifikasi == 'menengah' and $pengajuan->jenis_pengajuan == 0) {
            $this->jml_tagihan = ($tagihan->iuran_1_thn_menengah + $tagihan->uang_pangkal);
        } elseif ($pengajuan->kualifikasi == 'besar' and $pengajuan->jenis_pengajuan == 0) {
            $this->jml_tagihan = ($tagihan->iuran_1_thn_besar + $tagihan->uang_pangkal);
        }

        // Tagihan perpanjang
        if ($pengajuan->kualifikasi == 'kecil' and $pengajuan->jenis_pengajuan == 3) {
            $this->jml_tagihan = $tagihan->iuran_1_thn_kecil;
        } elseif ($pengajuan->kualifikasi == 'menengah' and $pengajuan->jenis_pengajuan == 3) {
            $this->jml_tagihan = $tagihan->iuran_1_thn_menengah;
        } elseif ($pengajuan->kualifikasi == 'besar' and $pengajuan->jenis_pengajuan == 3) {
            $this->jml_tagihan = $tagihan->iuran_1_thn_besar;
        }
       

        $publishInvoiceAgt = InvoicePengajuanKta::create([
          'id_detail_kta'     => $idDetailKta,
          'no_invoice'        => "INV-DPP-INKINDO-".strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5)),
          'jenis_pengajuan'   => $pengajuan->jenis_pengajuan,
          'jml_tagihan'       => ($this->jml_tagihan == null) ? 0 : $this->jml_tagihan,
          'tgl_cetak'         => date('Y-m-d H:i:s'),
          'status_pembayaran' => ($pengajuan->jenis_pengajuan == 1 or $pengajuan->jenis_pengajuan == 4) ? 1 : 0,
        ]);
        if ($publishInvoiceAgt) {
            $updateKeternagan = HistoryApprovalPengajuan::where('id_detail_kta', $idDetailKta)
            ->update(
                [
                    'status_pengajuan' => ($pengajuan->jenis_pengajuan == 1 or $pengajuan->jenis_pengajuan == 4) ? 3 : 2,
                    'keterangan' => ($pengajuan->jenis_pengajuan == 1 or $pengajuan->jenis_pengajuan == 4) ? $this->keteranganUlang : $this->keteranganBaru,
                ]
            );
            $updataNotification = DetailKta::findOrFail($idDetailKta)
                                  ->update(['view_notifikasi' => 0]);

            if ($updateKeternagan and $updataNotification) {
                $dataInvoiceAnggota = [
                    'invoice'  => $publishInvoiceAgt,
                    'kta'      => $pengajuan,
                    'pengurus' => $tagihan
                ];
                if($pengajuan->jenis_pengajuan == 1) {

                    $council =  DewanPengurus::whereLevel(1)->first();
                    $to      =  UsersDppDpn::whereId_dp($council->id)->first();
                    
                    $notificationData = [
                        'id_dp' => $council->id,
                        'message' => 'Anda memiliki 1 pengajuan baru'               
                    ];

                    Notification::send($to, new NotifyCouncil($notificationData));

                    dispatch(new SendInvoiceAnggotaMail($dataInvoiceAnggota));
                    return $dataInvoiceAnggota;
                }
                dispatch(new SendInvoiceAnggotaMail($dataInvoiceAnggota));
                return $dataInvoiceAnggota;
            }
        }
    }


    public function getInvoiceAnggotaPublished()
    {
        $invoicePublished = DB::table('t_invoice_kta')
                          ->join('t_detail_kta', 't_invoice_kta.id_detail_kta', '=', 't_detail_kta.id')
                          ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                          ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                          ->select('t_invoice_kta.*', 't_registrasi_users.nm_bu', 't_kta.id_dp', 't_detail_kta.id as id_detail_kta')
                          ->where('t_kta.id_dp', '=', Session::get('id_dp'));
                          
                          
        return Datatables::of($invoicePublished)
        ->addColumn('action', function ($invoice) {
            return '
            <a href="'. route('dpp.invoice.show', ['no_invoice' => $invoice->no_invoice, 'id_detail_kta' => $invoice->id_detail_kta]) .'" class="btn btn-sm btn-primary"  id="publish-member-invoice"  title="Publish invoice for this member">INVOICE</a>
            ';
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
        ->rawColumns(['action', 'jenis_pengajuan', 'status_pembayaran'])
        ->make(true);
    }


    public function showInvoice($noInvoice, $idDetailKta)
    {
        $dataInvoice = InvoicePengajuanKta::where('no_invoice', $noInvoice)->first();

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->select(
                          't_kta.kualifikasi',
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
        
        $pengurus    = DewanPengurus::find(Session::get('id_dp'));

        if ($dataInvoice && $pengajuan && $pengurus) {
            $dataInvoiceAnggota = [
                'invoice' => $dataInvoice,
                'kta'     => $pengajuan,
                'pengurus' => $pengurus
            ];
            return view('backend/dpp/content-pages/invoice.anggota-invoice-template', compact('dataInvoiceAnggota'));
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
        
        $pengurus    = DewanPengurus::find(Session::get('id_dp'));

        if ($dataInvoice && $pengajuan && $pengurus) {
            $dataInvoiceAnggota = [
                'invoice' => $dataInvoice,
                'kta'     => $pengajuan,
                'pengurus' => $pengurus
            ];
            $pdf = PDF::loadView('prints-template.invoice-anggota', compact('dataInvoiceAnggota'))->setPaper('a4', 'landscape');
            return $pdf->stream('invoice |'.$pengajuan->nm_bu.'.pdf');
        } else {
            abort(404);
        }
    }

    public function invoiceRoleShare()
    {
        return view('backend/dpp/content-pages/invoice.invoice-role-share');
    }

    public function getInvoiceRoleShare()
    {
        $invoicePublished = DB::table('t_invoice_role_share')
                          ->join('t_detail_kta', 't_invoice_role_share.id_detail_kta', '=', 't_detail_kta.id')
                          ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                          ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                          ->select(
                              't_invoice_role_share.*',
                              't_registrasi_users.nm_bu',
                              't_kta.id_dp',
                              't_detail_kta.id as id_detail_kta'
                          )
                           ->where('t_kta.id_dp', Session::get('id_dp'));
                          
        return Datatables::of($invoicePublished)
        ->addColumn('action', function ($invoice) {
            return '<a href="'.route('dpp.invoice.roleshare-show', ['no_invoice' => $invoice->no_invoice, 'id_detail_kta' => $invoice->id_detail_kta]).'" class="btn btn-sm btn-default" title="Pay this invoice">Detail Invoice</a>';
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

        ->editColumn('total_role_share', function ($total_role_share) {
            //return "IDR.".number_format($total_role_share->total_role_share);
            return $total_role_share->total_role_share;
        })
        ->rawColumns(['action', 'jenis_pengajuan', 'status_pembayaran'])
        ->make(true);
    }

    public function showInvoiceRoleShare($noInvoice, $idDetailKta)
    {
        $dataInvoice = InvoiceRoleShare::where('no_invoice', $noInvoice)->first();

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                      ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                      
                      ->select(
                          't_kta.kualifikasi',
                          't_detail_kta.jenis_pengajuan',
                          't_registrasi_users.email_bu',
                          't_registrasi_users.nm_bu',
                          't_detail_kta.masa_berlaku',
                          't_administrasi_kta.alamat',
                          't_administrasi_kta.no_telp',
                          't_detail_kta.id as id_detail_kta',
                          't_kta.id_dp',
                          'provinsi.name  as nama_provinsi'
                      )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
        
        $tagihan_provinsi  = DewanPengurus::where('id', $pengajuan->id_dp)->first();
        $pengurus_nasional  = DewanPengurus::where('level', 1)->first();
              
        if ($dataInvoice && $pengajuan && $tagihan_provinsi && $pengurus_nasional) {
            $dataInvoiceRoleShare = [
                'invoice'  => $dataInvoice,
                'kta'      => $pengajuan,
                'dpp'      => $tagihan_provinsi,
                'dpn'      => $pengurus_nasional
            ];
            return view('backend/dpp/content-pages/invoice/invoice-role-share-template', compact('dataInvoiceRoleShare'));
        } else {
            abort(404);
        }
    }

    public function saveRoleShareConfirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nominal'          => 'required|max:11',
            'atas_nama'        => 'required|max:50',
            'nama_bank_anda'   => 'required|max:20',
            'upload_bukti_trf' => 'required|file|mimes:jpeg,jpg|max:2048'
        ]);

        if (!$validator->fails()) {
            $extension      = $request->file('upload_bukti_trf')->getClientOriginalExtension();
            $dir            = 'public/bukti-transfer-rolesharing';
            $filename       = uniqid() . '_' . time() . '.' . $extension;
            $request->file('upload_bukti_trf')->storeAs($dir, $filename);
            $rowRoleShareAccumulation = count($request['id_role_share_accumulation']);

            try {
                DB::beginTransaction();
                $savePayment = RoleShareAccumulation::create([
                    'nominal'          => $request->nominal,
                    'upload_bukti_trf' => $filename,
                    'atas_nama'        => $request->atas_nama,
                    'nama_bank_anda'   => $request->nama_bank_anda,
                    ]);

               
                    for ($i=0; $i < $rowRoleShareAccumulation; $i++) {
                        RoleShareConfirmation::create([
                                'id_invoice_role_share'      => $request['id_role_share_accumulation'][$i],
                                'id_role_share_accumulation' => $savePayment->id,
                            ]);
                    }

                    $council =  DewanPengurus::whereLevel(1)->first();
                    $to      =  UsersDppDpn::whereId_dp($council->id)->first();
                    
                    $notificationData = [
                        'id_dp' => $council->id,
                        'message' => 'Anda memiliki 1 pembayaran role sharing baru'               
                    ];

                    Notification::send($to, new NotifyCouncil($notificationData));
                    DB::commit();
                    return response()->json(['success'=>'Pembayaran rolesharing ke Dewan Pengurus Pusat berhasil di lakukan.']);
               
                
            } catch (\PDOException $err) {
                return response()->json(['errors' => 'Gagal mengkonfirmasi pembayaran role sharing'], 400);
                DB::rollBack();
            }
        } else {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
    }
}
