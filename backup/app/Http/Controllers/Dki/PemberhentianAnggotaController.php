<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use Validator;
use App\Kta;
use App\DetailKta;
use App\HistoryApprovalPengajuan;

class PemberhentianAnggotaController extends Controller
{

    public function berhentiMenjadiAnggota(Request $request)
    {
        $validator = Validator::make(Input::all(), [

                'dokumen_pemberhentian'   => 'required|file|mimes:pdf|max:2048',

                'keterangan'              => 'required|string|max:500',

            ]);

        if (!$validator->fails()) {
            $dokumenPemberhentian   = $request->file('dokumen_pemberhentian')->storeAs('public/dokumen-pemberhentian', Uuid::uuid4().'.pdf');

            if ($detailKta = DetailKta::findOrfail($request->id_detail_kta)) {
                $dataDetailKta = [
                    'id_kta' => $detailKta->id_kta ,
                    'jenis_pengajuan' => 4,
                    'waktu_pengajuan' => date('Y-m-d H:i:s'),
                    'tgl_terbit' => $detailKta->tgl_terbit,
                    'masa_berlaku' => $detailKta->masa_berlaku,
                    'view_notifikasi' => 0,
                    'is_inserted' => 4
                ];

               

                if ($detailKta->update($dataDetailKta)) {
                    $detailKta->historyApps()->update([
                        'status_pengajuan' => 3 ,
                        'tgl_status'       => date('Y-m-d H:i:s'),
                        'keterangan'       => 'Dokumen pengajuan pemberhentian anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.',
                    ]);

                    $detailKta->pemberhentianAgt()->create([
                        'file_pemberhentian' => substr($dokumenPemberhentian, 29) ,
                        'keterangan'         => $request->keterangan
                    ]);

                    return response()->json([
                        'message' => 'Pengajuan pemberhentian anda akan di proses oleh tim KTA Inkindo',
                        'status' => 200
                    ], 200);
                }
            }
        } else {
            return response()->json([
                'data' => $validator->errors(),
                'message' => 'Error credentials',
                'status' => 400
                
            ], 400);
        }
    }
}
