<?php

namespace App\Http\Controllers\Backend\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use \App\Helpers\LocalDate;
use Ramsey\Uuid\Uuid;

class PindahDppController extends Controller
{
    public function index()
    {

    
        $kta =  DB::table('t_kta as a')
            ->join('t_registrasi_users as b', 'a.id_registrasi_users', '=', 'b.id')
            ->where('id_registrasi_users',Session::get('id_registrasi_user'))
            ->orderBy('a.created_at','desc')
            ->first();

        $allDPP = DB::table('t_dp')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->select('t_dp.id', 'provinsi.name')
            ->orderBy('t_dp.id', 'DESC')
            ->get();


        return view('backend/anggota/content-pages/pindah_dpp.pindah_dpp', compact('allDPP','kta'));
    }

    
    public function action_pindah_dpp(Request $request)
    {
        $checkLastKta = \App\Kta::where('id_registrasi_users', Session::get('id_registrasi_user'))
                                ->orderBy('created_at', 'desc')
                                ->first();
        $get_detail = \App\Helpers\LocalDate::get_detail_kta();
        // dd($get_detail);
        

        if($request->provinsi_tujuan == $get_detail->id_dp)
        {
            return redirect()->back()->with('get_exist_dpp', 'Nomor KTA anda masih aktif');
        }
        
        if (empty($checkLastKta)) {
            return redirect()->back()->with('validasi_kta_kosong', 'Kartu Tanda Anggota anda masih belum tersedia');
        } 
       
        $rules = array(
            'provinsi_asal'  => 'required',
            'provinsi_tujuan' => 'required',
            'surat_permohonan'=> 'required|file|mimes:pdf|max:2048',
        );
         

        $validator = \Validator::make($request->all(), $rules);
        
        
        
        if (!$validator->fails()) {

            if ($request->hasFile('surat_permohonan')) {
                $name_foto_pindah                   = Uuid::uuid4().'.'.$request->surat_permohonan->getClientOriginalExtension();
                $request->file('surat_permohonan')->storeAs('public/pindah_dpp', $name_foto_pindah);
            }

            
            $data_pindah = [
                
                'jenis_pengajuan'=>'5',
                'provinsi_asal'               => $request->provinsi_asal,
                'provinsi_tujuan'            => $request->provinsi_tujuan,
                'surat_permohonan'         => $name_foto_pindah,
                'status_pindah'   => 'baru',
                'waktu_pengajuan'   => date('Y-m-d H:i:s'),
            ];

            \App\DetailKta::where('id',$get_detail->id)->update($data_pindah);


            $appKta['id_detail_kta'] = $get_detail->id;
            
            $appKta['status_pengajuan'] =  0 ;

            $appKta['tgl_status'] = date('Y-m-d H:i:s');

            $appKta['keterangan'] = 'Dokumen "Pindah DPP" anda telah memasuki fase "Screening" oleh Team KTA Online Inkindo, Jika dokumen anda lengkap dan valid maka akan di lanjutkan ke fase berikutnya.';

            \App\HistoryApprovalPengajuan::where('id_detail_kta',$get_detail->id)->update($appKta);

            
            
            return redirect()->route('anggota.status.main')->with('pindah_dpp', 'Berhasil melakukan registrasi anggota');

        }
        else
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }
}


 