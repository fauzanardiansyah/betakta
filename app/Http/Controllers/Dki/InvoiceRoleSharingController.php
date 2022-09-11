<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NotifyCouncil;
use Notification;
use Validator;
use DB;

class InvoiceRoleSharingController extends Controller
{
    public function index()
    {
        $invoice_role_sharing = DB::table('t_invoice_role_share')
                                ->join('t_detail_kta', 't_invoice_role_share.id_detail_kta', '=', 't_detail_kta.id')
                                ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                                ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                                ->select(
                                    't_invoice_role_share.*',
                                    't_registrasi_users.nm_bu',
                                    't_registrasi_users.id as id_registrasi_users'   
                                )
                                ->where('t_kta.id_dp', Request()->input('id_dp'))
                                ->get();
        $results = [];
        foreach($invoice_role_sharing as $item) {
            $data = [
                'id' => $item->id,
                'id_registrasi_users' => $item->id_registrasi_users,
                'no_invoice' => $item->no_invoice,
                'nm_bu' => $item->nm_bu,
                'jenis_pengajuan' => ($item->jenis_pengajuan == 0) ? 'Buat Baru' : (($item->jenis_pengajuan == 1) ? 'Daftar Ulang' : ($item->jenis_pengajuan == 3) ? 'Perpanjangan' : 'Pemberhentian') ,
                'total_role_share' => $item->total_role_share,
                'tgl_cetak' => $item->tgl_cetak,
                'status_pembayaran' => ($item->status_pembayaran == 0) ? 'pending' : 'paid',
                'created_at' => $item->created_at
            ];

            array_push($results, $data);
        }
        return response()->json([
            'data' => $results,
            'message' => 'Invoice Role Sharing',
            'status' => 200
        ], 200);
    }

    public function detailInvoiceRoleSharing(Request $request)
    {
        $id_detail_kta = $request->input('id_detail_kta');
        $no_invoice = $request->input('no_invoice');

        $dataInvoice = \App\InvoiceRoleShare::where('no_invoice', $no_invoice)->first();

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
                      ->where('t_detail_kta.id', $id_detail_kta)
                      ->first();
        
        $tagihan_provinsi  = \App\DewanPengurus::where('id', $pengajuan->id_dp)->first();
        $pengurus_nasional  = \App\DewanPengurus::where('level', 1)->first();
              
        if ($dataInvoice && $pengajuan && $tagihan_provinsi && $pengurus_nasional) {
            $data_invoice_rolesharing = [
                'id' => $dataInvoice->id,
                'no_invoice' => $dataInvoice->no_invoice,
                'nm_bu' => $pengajuan->nm_bu,
                'jenis_pengajuan' => ($dataInvoice->jenis_pengajuan == 0) ? 'Buat Baru' : 'Daftar Ulang',
                'total_role_share' => $dataInvoice->total_role_share,
                'tgl_cetak' => $dataInvoice->tgl_cetak,
                'status_pembayaran' => ($dataInvoice->status_pembayaran == 0) ? 'pending' : 'paid',
                'transfer_ke' => [
                    'no_rek' => $pengurus_nasional->no_rek,
                    'nm_rek' => $pengurus_nasional->nm_rek,
                    'nm_bank' => $pengurus_nasional->nm_bank,
                    'kode_bank' => $pengurus_nasional->kode_bank,
                    'email_dewan_pengurus' => $pengurus_nasional->email_dewan_pengurus
                ]
            ];
            
            return response()->json([
                'data' => $data_invoice_rolesharing,
                'message' => 'Detail invoice role sharing',
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                'data' => null,
                'message' => 'Data tidak ditemukan',
                'status' => 404
            ], 404);
        }
    }

    public function roleSharingConfirmation(Request $request)
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
                $savePayment = \App\RoleShareAccumulation::create([
                    'nominal'          => $request->nominal,
                    'upload_bukti_trf' => $filename,
                    'atas_nama'        => $request->atas_nama,
                    'nama_bank_anda'   => $request->nama_bank_anda,
                    ]);

               
                    for ($i=0; $i < $rowRoleShareAccumulation; $i++) {
                        \App\RoleShareConfirmation::create([
                                'id_invoice_role_share'      => $request['id_role_share_accumulation'][$i],
                                'id_role_share_accumulation' => $savePayment->id,
                            ]);
                    }

                    $council =  \App\DewanPengurus::whereLevel(1)->first();
                    $to      =  \App\UsersDppDpn::whereId_dp($council->id)->first();
                    
                    $notificationData = [
                        'id_dp' => $council->id,
                        'message' => 'Anda memiliki 1 pembayaran role sharing baru'               
                    ];

                    Notification::send($to, new NotifyCouncil($notificationData));
                    DB::commit();
                    return response()->json([
                        'data' => $savePayment,
                        'message'=>'Pembayaran rolesharing ke Dewan Pengurus Nasional berhasil di lakukan.',
                        'status' => 200
                    ], 200);
               
                
            } catch (\PDOException $err) {
                return response()->json([
                    'data' => $err,
                    'message'=>'Gagal mengkonfirmasi pembayaran role sharing.',
                    'status' => 400
                ], 400);
                DB::rollBack();
            }
        } else {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
    }
}
