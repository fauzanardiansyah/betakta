<?php

namespace App\Http\Controllers\Dki;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Kta;
use App\DetailKta;
use DB;
use PDF;


class KartuTandaAnggotaController extends Controller
{
    private $jenis_download;
    

    public function __construct()
    {
        $this->jenis_download = Request()->input('jenis_download');
    }

    public function index()
    {
        $list_anggota =  DB::table('t_kta')
                        ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                        ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                        ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                        ->select(
                            't_kta.id as id_kta',
                            't_kta.no_kta',
                            't_kta.lokasi_pengurusan',
                            't_kta.status_kta',
                            't_detail_kta.waktu_pengajuan',
                            't_detail_kta.jenis_pengajuan',
                            't_detail_kta.masa_berlaku',
                            't_detail_kta.id as id_detail_kta',
                            't_app_kta.status_pengajuan',
                            't_kta.status_penataran',
                            't_kta.jenis_bu',
                            't_registrasi_users.id as id_registrasi_user',
                            't_registrasi_users.nm_bu'
                        )
                        ->where('t_detail_kta.is_inserted', 4)
                        ->where('t_app_kta.status_pengajuan', 7)
                        ->where('t_kta.id_dp', Request()->input('id_dp'))
                        ->orderBy('t_detail_kta.created_at', 'desc')
                        ->get();

        if (!empty($list_anggota)) {
            $results = [];
            foreach($list_anggota as $items) {
                $data = [
                    'anggota' =>  [
                        'nm_bu' => $items->nm_bu,
                        'id_kta' => $items->id_kta,
                        'no_kta' => $items->no_kta,
                        'id_registrasi_user' => $items->id_registrasi_user,
                        'lokasi_pengurusan' => $items->lokasi_pengurusan,
                        'status_kta' => ($items->status_kta == 0) ? 'aktif' : 'pasif',
                        'waktu_pengajuan' => $items->waktu_pengajuan,
                        'masa_berlaku' => $items->masa_berlaku,
                        'status_pengajuan' => ($items->status_pengajuan == 7) ? 'selesai' :'dalam proses',
                    ],
                    'download' => [
                        'kta' => route('download.kta-anggota', ['jenis_download' => 'kta','id_kta' => $items->id_kta, 'id_registrasi_user' => $items->id_registrasi_user]),
                        'kia' => route('download.kia-anggota', ['jenis_download' => 'kia','id_kta' => $items->id_kta, 'id_registrasi_user' => $items->id_registrasi_user])
                    ]
                ];

                array_push($results, $data);

            }

            $result = [
                'data' => $results,
                'message' => 'List Anggota',
                'status' => 200,
            ];

            return response()->json($result, 200);
           
        }

        $data = [
            'data' => $memberData,
            'message' => 'Data member tidak di temukan',
            'status' => 404
        ];

        return response()->json($data, 404);
    }


    public function downloadKartuAnggota()
    {
        $id_kta = Request()->input('id_kta'); 
        $id_registrasi_user = Request()->input('id_registrasi_user');
        $dataKta = DB::table('t_kta')
                     ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                     ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                     ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                     ->join('t_registrasi_users', 't_registrasi_users.id', '=', 't_kta.id_registrasi_users')
                     ->join('t_administrasi_kta', 't_detail_kta.id', '=', 't_administrasi_kta.id_detail_kta')
                     ->join('t_pj_kta', 't_detail_kta.id', '=', 't_pj_kta.id_detail_kta')
                     ->join('t_dokumen_kta', 't_detail_kta.id', '=', 't_dokumen_kta.id_detail_kta')
                     ->select(
                         't_registrasi_users.email_bu',
                         't_registrasi_users.nm_bu',
                         't_registrasi_users.npwp_bu',
                         'provinsi.name as province_name',
                         't_kta.*',
                         't_detail_kta.*',
                         't_administrasi_kta.kota',
                         't_administrasi_kta.kecamatan',
                         't_administrasi_kta.alamat',
                         't_administrasi_kta.no_telp',
                         't_administrasi_kta.no_fax',
                         't_administrasi_kta.website',
                         't_dokumen_kta.file_foto_pjbu',
                         't_pj_kta.nm_pjbu',
                         't_dp.nm_ketua_provinsi',
                         't_dp.nm_sekretaris_provinsi',
                         't_dp.nm_ketum',
                         't_dp.nm_sekjen',
                         't_registrasi_users.status_bu',
                         't_dp.ttd_ketum',
                         't_dp.ttd_sekjen',
                         't_dp.ttd_ketua_provinsi',
                         't_dp.ttd_sekretaris_provinsi',
                         't_dp.ketua_bkka',
                         't_dp.sekretaris_bkka',
                         't_dp.ttd_sekretaris_bkka',
                         't_dp.ttd_ketua_bkka'
                     )
                     ->where('t_kta.id', $id_kta)
                     ->where('t_kta.id_registrasi_users', $id_registrasi_user)
                     ->first();
        $dpnSignature = DB::table('t_dp')->whereLevel(1)->first();

        if (empty($dataKta)) {
            abort(404);
        }
        if($this->jenis_download === 'kta') {
            // $pdf = PDF::loadView('kta-template/v3.pmdn-sertificate', compact('dataKta','dpnSignature'))->setPaper('a4', 'landscape');
            // return $pdf->stream('kta-'.$dataKta->nm_bu.'.pdf');

           return view('kta-template/v3.'.$result = ($dataKta->jenis_bu == 'pmdn') ? 'pmdn-sertificate' : 'pma-sertificate', compact('dataKta','dpnSignature'));
        } elseif($this->jenis_download === 'kia') {
            // $pdf = PDF::loadView('kta-template/v3.idCard', compact('dataKta','dpnSignature'))->setPaper('a4', 'portrait');
            // return $pdf->stream('kia-'.$dataKta->nm_bu.'.pdf');

           return view('kta-template/v3.idCard', compact('dataKta','dpnSignature'));

        }
    }
}
