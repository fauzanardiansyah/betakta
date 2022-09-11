<?php

namespace App\Http\Controllers\Backend\Dpn\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\PaymentConfirmation;
use App\RoleShareConfirmation;
use App\DetailKta;
use App\HistoryApprovalPengajuan;
use DB;
use Session;

class PaymentDpnController extends Controller
{
    public function anggotaAfiliasi()
    {
        return view('backend/dpn/content-pages/payment.payment-afiliasi');
    }

    public function getAnggotaAfiliasi()
    {
        $dataPaymentAfiliasi = DB::table('t_payment_confirmation')
        ->join('t_invoice_kta', 't_payment_confirmation.id_invoice_kta', '=', 't_invoice_kta.id')
        ->join('t_detail_kta', 't_invoice_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
        ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
        ->select('t_payment_confirmation.*', 't_registrasi_users.nm_bu', 't_invoice_kta.status_pembayaran', 't_detail_kta.id as id_detail_kta', 't_app_kta.status_pengajuan')
        ->where('t_kta.jenis_bu', '=', 'pma');
    

        return Datatables::of($dataPaymentAfiliasi)
        ->addColumn('action', function ($detailPaymnet) {
            if ($detailPaymnet->status_pengajuan == 7) {
                return "<a disabled>Selesai</a>";
            } else {
                return '
                <a href="#" class="btn btn-sm btn-default"  id="show-detail-payment" data-id-detail-kta="'.$detailPaymnet->id_detail_kta.'" data-id-payment="'.$detailPaymnet->id.'"  title="Show detail payment"><i class="fa fa-search"></i></a>
                <a href="'.route('dpn.payment.afiliasi-verify', ['id_detail_kta' => $detailPaymnet->id_detail_kta]).'" class="btn btn-sm btn-success"   data-id-payment="'.$detailPaymnet->id_detail_kta.'"  title="DPP Verified" '.($detailPaymnet->status_pembayaran == 0 ? "disabled" : "").'><i class="fa fa-check"></i></a>
                ';
            }
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
                return "<a class='btn btn-xs btn-success'><i class='fa fa-check'></i> DI periksa oleh dpn</a>";
            }

            if ($status_pengajuan->status_pengajuan == 4) {
                return "<a class='btn btn-xs btn-danger'><i class='fa fa-ban'></i> Di tolak oleh dpn</a>";
            }

            if ($status_pengajuan->status_pengajuan == 5) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu pembayaran terverifikasi</a>";
            }

            if ($status_pengajuan->status_pengajuan == 6) {
                return "<a class='btn btn-xs btn-warning'><i class='fa fa-file-pdf-o'></i> Menunggu nomor KTA</a>";
            }

            if ($status_pengajuan->status_pengajuan == 7) {
                return "<a class='btn btn-xs btn-primary'><i class='fa fa-check-square-o'></i> Selesai</a>";
            }
        })

        ->editColumn('nominal', function ($nominal) {
            return "IDR.".$nominal->nominal;
        })
        ->rawColumns(['action', 'nominal', 'status_pembayaran','status_pengajuan'])
        ->make(true);
    }

    public function getDetailDataPaymentAnggotaAfiliasi(Request $request)
    {
        $idPayment = $request->idPayment;

        $dataPaymentAnggota = PaymentConfirmation::findOrfail($idPayment);
        return response()->json($dataPaymentAnggota, 200);
    }

    public function acceptPaymentAnggotaAfiliasi(Request $request)
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

    public function verifikasiPembayaranAnggotaAfiliasi($id_detail_kta)
    {
        $jenisPengajuan = DetailKta::findOrFail($id_detail_kta);
        $anggotaVerify = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
        ->update(
            [
                'status_pengajuan' => ($jenisPengajuan->jenis_pengajuan != 3) ? 6 : 7,
                'keterangan'       => ($jenisPengajuan->jenis_pengajuan != 3) ? 'Menunggu nomor KTA' : 'Pengajuan anda telah selesai,, kartu tanda anggota anda telah dapat di download kembali',
                ]
        );

        if ($anggotaVerify) {
            $notification = DetailKta::findOrFail($id_detail_kta)
                    ->update(['view_notifikasi' => 0]);
            if ($notification) {
                return redirect()->back()->with('successVerifyAnggota', 'Berhasil, Silahkan terbitkan KTA untuk anggoa ini.');
            }
        } else {
            abort(404);
        }
    }


    public function roleSharingDpp()
    {
        return view('backend/dpn/content-pages/payment.payment-role-share');
    }

    public function getRoleSharePayment()
    {
        $dataPaymentRoleShare = DB::table('t_role_share_accumulation');
       
        return Datatables::of($dataPaymentRoleShare)
        ->addColumn('status', function ($status) {
            if ($status->status === 0) {
                return "<a href='#'
                       class='btn btn-sm btn-danger'  
                       title='Show detail payment'>
                       Belum Terverifikasi
                    </a>";
            }

            return "<a href='#'
                       class='btn btn-sm btn-success'  
                       title='Show detail payment'>
                       Terverifikasi
                    </a>";
        })

        ->addColumn('upload_bukti_trf', function ($upload_bukti_trf) {
            return "<a target='_blank' href=".asset('storage/bukti-transfer-rolesharing/'.$upload_bukti_trf->upload_bukti_trf)."><img class='img-responsive img-thumbnail' style='width:70px;height:70px;' src=".asset('storage/bukti-transfer-rolesharing/'.$upload_bukti_trf->upload_bukti_trf).">";
        })
        ->addColumn('action', function ($detailPaymnet) {
            return "<a href='#'
                       class='btn btn-sm btn-default'  
                       id='show-detail-payment'  
                       title='Show detail payment'
                       data-id-role-share='".$detailPaymnet->id."'>
                       <i class='fa fa-search'></i>
                    </a>";
        })
        ->editColumn('nominal', function ($nominal) {
            return "IDR.".number_format($nominal->nominal);
        })
        ->rawColumns(['action', 'nominal', 'status', 'upload_bukti_trf'])
        ->make(true);
    }

    public function getDetailDataPaymentRoleShare(Request $request)
    {
        $idRoleShareAccumulation = $request->idRoleShareAccumulation;
        if (empty($idRoleShareAccumulation)) {
            return response()->json([
               'error' => 'ID Role share tidak di temukan'
           ], 400);
        }
        $dataInvoiceRoleShareDetail = DB::table('t_role_share_confirmation')
                                 ->join('t_invoice_role_share', 't_role_share_confirmation.id_invoice_role_share', '=', 't_invoice_role_share.id')
                                 ->join('t_detail_kta', 't_invoice_role_share.id_detail_kta', '=', 't_detail_kta.id')
                                 ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                                 ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                                 ->select(
                                     't_invoice_role_share.id',
                                     't_registrasi_users.nm_bu',
                                     't_invoice_role_share.no_invoice',
                                     't_invoice_role_share.total_role_share'
                                 )
                                 ->where('t_role_share_confirmation.id_role_share_accumulation', $idRoleShareAccumulation);
        return Datatables::of($dataInvoiceRoleShareDetail)
       ->make(true);
    }

    public function acceptPaymentRoleShare(Request $request)
    {
        $idPayment  = $request->dataArray;
        $rowPayment = count($idPayment);
        $idRoleShareAccumulation = $request->idRoleShareAccumulation;
        try {
            DB::beginTransaction();
            for ($i=0; $i<$rowPayment; $i++) {
                DB::table('t_invoice_role_share')
                    ->where('no_invoice', $idPayment[$i])
                    ->update(['status_pembayaran' => 1]);
            }
            DB::table('t_role_share_accumulation')
                ->where('id', $idRoleShareAccumulation)
                ->update(['status' => 1]);

            DB::commit();
            return response()->json(['success' => 'Berhasil memverifikasi pembayaran role sharing'], 200);
        } catch (\PDOException $err) {
            return response()->json(['errors' => 'Gagal memverifikasi pembayaran role sharing'], 200);
            DB::rollBack();
        }
    }

    public function verifikasiPembayaranRoleSharing($id_detail_kta)
    {
        $anggotaVerify = HistoryApprovalPengajuan::where('id_detail_kta', $id_detail_kta)
        ->update(
            [
                'status_pengajuan' => 6,
                'keterangan'       => 'Menunggu nomor KTA',
                ]
        );

        if ($anggotaVerify) {
            $notification = DetailKta::findOrFail($id_detail_kta)
                    ->update(['view_notifikasi' => 0]);
            if ($notification) {
                return redirect()->back()->with('successVerifyAnggota', 'Berhasil, Silahkan terbitkan KTA untuk anggoa ini.');
            }
        } else {
            abort(404);
        }
    }
}
