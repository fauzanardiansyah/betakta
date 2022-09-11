<?php

namespace App\Http\Controllers\Backend\Dpn\Invoice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendInvoiceRoleShareMail as SendInvoiceRoleShareMail;
use App\Jobs\SendInvoiceAnggotaAfiliasi as SendInvoiceAnggotaAfiliasi;
use Yajra\Datatables\Datatables;
use App\DewanPengurus;
use App\InvoiceRoleShare;
use App\InvoicePengajuanKta;
use App\HistoryApprovalPengajuan;
use App\Notifications\NotifyCouncil;
use App\DetailKta;
use App\UsersDppDpn;
use Notification;
use DB;
use PDF;

class InvoiceDpnController extends Controller
{
    
    protected $jml_tagihan_agt;
    protected $jml_role_share_iuran;
    protected $jml_role_share_pangkal;
    
    


    public function invoiceRoleSharing()
    {
        return view('backend/dpn/content-pages/invoice.roleshare-invoice');
    }

    public function invoiceAnggotaAfiliasi()
    {
        return view('backend/dpn/content-pages/invoice.afiliasi-invoice');
    }

    public function getAnggotaLokal()
    {
        $anggota = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->select(['t_detail_kta.id as id_detail_kta', 
                   't_registrasi_users.nm_bu', 
                   't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                   't_kta.kualifikasi',
                   't_detail_kta.waktu_pengajuan', 
                   't_app_kta.status_pengajuan',
                   't_kta.id_dp'
                   ])
        ->where('t_kta.jenis_bu', '=', 'pmdn')
        ->where('t_detail_kta.jenis_pengajuan', '!=', 1)
        ->where('t_detail_kta.jenis_pengajuan', '!=', 4)
        ->where('t_app_kta.status_pengajuan' ,'>=', 5);
        
    

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
            if ($jenis_pengajuan->jenis_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'>Naik Kualifikasi</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 7) {
                return "<a class='btn btn-xs btn-warning'>Turun Kualifikasi</a>";
            }
        })
        ->addColumn('status', function ($status_pengajuan) {
            if ($status_pengajuan->status_pengajuan === 3) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 6) {
                return '<a class="btn btn-xs btn-warning">Terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 4) {
                return '<a class="btn btn-xs btn-danger">Di tolak</a>';
            } elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">Selesai</a>';
            } else {
                return '<a class="btn btn-xs btn-warning">Terverifiaksi</a>';
            }
        })
        ->addColumn('action', function ($kta) {
            if ($kta->status_pengajuan == 7) :
                 return '<a href="#" class="btn btn-sm btn-success"   title="Finish" disabled>FINISH</a>'; 
                elseif ($kta->status_pengajuan == 0) :
                    return '<a href="#" class="btn btn-sm btn-success"   title="Can`t publish" disabled>PUBLISH</a>';
                else :
                    return '<a href="#" class="btn btn-sm btn-success" data-id-detail-kta="'.$kta->id_detail_kta.'" data-id-dp="'.$kta->id_dp.'" id="publish-roleshare-invoice"  title="Publish invoice for this member">PUBLISH</a>';
            endif;
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan'])
        ->make(true);
    }

    public function getAnggotaAfiliasi()
    {
        $anggota = DB::table('t_kta')
        ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_app_kta', 't_app_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->where('t_detail_kta.jenis_pengajuan', '!=', 4)
        ->select(['t_detail_kta.id as id_detail_kta', 't_registrasi_users.nm_bu', 't_pj_kta.nm_pjbu',
                   't_detail_kta.jenis_pengajuan',
                   't_kta.kualifikasi', 't_detail_kta.waktu_pengajuan', 't_app_kta.status_pengajuan'])
        ->where('t_kta.jenis_bu', '=', 'pma');
    

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
            if ($jenis_pengajuan->jenis_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'>Naik Kualifikasi</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 7) {
                return "<a class='btn btn-xs btn-warning'>Turun Kualifikasi</a>";
            }
        })
        ->addColumn('status', function ($status_pengajuan) {
            if ($status_pengajuan->status_pengajuan === 3) {
                return '<a class="btn btn-xs btn-primary">Belum terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 6) {
                return '<a class="btn btn-xs btn-warning">Terverifikasi</a>';
            } elseif ($status_pengajuan->status_pengajuan === 4) {
                return '<a class="btn btn-xs btn-danger">DI tolak</a>';
            } elseif ($status_pengajuan->status_pengajuan === 7) {
                return '<a class="btn btn-xs btn-success">Selesai</a>';
            } else {
                return '<a class="btn btn-xs btn-warning">Terverifikasi</a>';
            }
        })
        ->addColumn('action', function ($kta) {
            if ($kta->status_pengajuan == 7) :
                return '<a href="#" class="btn btn-sm btn-success"   title="Finish" disabled>FINISH</a>'; 
               elseif ($kta->status_pengajuan == 3) :
                   return '<a href="#" class="btn btn-sm btn-success"   title="Can`t publish" disabled>PUBLISH</a>';
               else :
                   return '<a href="#" class="btn btn-sm btn-success" data-id-detail-kta="'.$kta->id_detail_kta.'" id="publish-afiliasi-invoice"  title="Publish invoice for this member">PUBLISH</a>';
           endif;
            
        })
        ->rawColumns(['status', 'action', 'jenis_pengajuan'])
        ->make(true);
    }

    public function publishInvoiceRoleShare(Request $request)
    {
        // dd('tes');
        $idDetailKta = $request->id_detail_kta;
        $id_dp = $request->id_dp;

        if($id_dp == 17) {
            $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
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
                          'provinsi.name  as nama_provinsi',
                          't_detail_kta.waktu_pengajuan'


                      )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
        } else {
            $pengajuan  = DB::table('t_kta')
            ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
            ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
            ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
            ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
            ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
            ->join('t_invoice_kta', 't_detail_kta.id', '=', 't_invoice_kta.id_detail_kta')
           
            ->select(
                't_kta.kualifikasi',
                't_detail_kta.jenis_pengajuan',
                't_registrasi_users.email_bu',
                't_registrasi_users.nm_bu',
                't_detail_kta.masa_berlaku',
                't_administrasi_kta.alamat',
                't_administrasi_kta.no_telp',
                't_detail_kta.id as id_detail_kta',
                't_invoice_kta.jml_tagihan',
                't_kta.id_dp',
                'provinsi.name  as nama_provinsi',
                't_detail_kta.waktu_pengajuan'


            )
            ->where('t_detail_kta.id', $idDetailKta)
            ->latest('t_invoice_kta.tgl_cetak')
            ->first();
        }

        
        $v_iuran =0;
        $year_now = date("Ym",strtotime($pengajuan->waktu_pengajuan));
        $year_min = date("Y12",strtotime($pengajuan->waktu_pengajuan));
        $startTimeStamp = strtotime($year_now);
        $endTimeStamp = strtotime($year_min);
        $month_from = date("F Y",strtotime($pengajuan->waktu_pengajuan));

        $timeDiff = abs($endTimeStamp - $startTimeStamp)+1;
        if($startTimeStamp == $endTimeStamp)
        {
            $timeDiff=1;
        }
        $price_cut =0;

        $month_cut = strtotime( date("F", mktime(0, 0, 0, 7, 10)).date("Y",strtotime($pengajuan->waktu_pengajuan)) ) ; 
        $get_month_now = strtotime($month_from);        
        $price_cut = 0;

        $tagihan_provinsi  = DewanPengurus::where('id', $pengajuan->id_dp)->first();
        $pengurus_nasional  = DewanPengurus::where('level', 1)->first();
        $jml_tagihan = 0;

         // Tagihan buat baru
        if ($pengajuan->kualifikasi == 'kecil' and $pengajuan->jenis_pengajuan == 0) {
           $v_iuran = \App\Helpers\LocalDate::get_contribution_now($tagihan_provinsi->iuran_1_thn_kecil,$timeDiff);
           if($month_cut < $get_month_now)
            {
                 $price_cut = \App\Helpers\LocalDate::get_contribution_next($tagihan_provinsi->iuran_1_thn_kecil);
            }

            $jml_tagihan = $v_iuran + $price_cut ;
            $this->jml_role_share_iuran = ($tagihan_provinsi->role_share_iuran_kecil/100) * ($jml_tagihan);


        } elseif ($pengajuan->kualifikasi == 'menengah' and $pengajuan->jenis_pengajuan == 0) {
           $v_iuran = \App\Helpers\LocalDate::get_contribution_now($tagihan_provinsi->iuran_1_thn_menengah,$timeDiff);
           if($month_cut < $get_month_now)
            {
                 $price_cut = \App\Helpers\LocalDate::get_contribution_next($tagihan_provinsi->iuran_1_thn_menengah);
            }

            $jml_tagihan = $v_iuran + $price_cut ;

            $this->jml_role_share_iuran = ($tagihan_provinsi->role_share_iuran_menengah/100) * ($jml_tagihan);

        } elseif ($pengajuan->kualifikasi == 'besar' and $pengajuan->jenis_pengajuan == 0) {
           $v_iuran = \App\Helpers\LocalDate::get_contribution_now($tagihan_provinsi->iuran_1_thn_besar,$timeDiff);
           if($month_cut < $get_month_now)
            {
                 $price_cut = \App\Helpers\LocalDate::get_contribution_next($tagihan_provinsi->iuran_1_thn_besar);
            }

            $jml_tagihan = $v_iuran + $price_cut ;
            $this->jml_role_share_iuran = ($tagihan_provinsi->role_share_iuran_besar/100) * ($jml_tagihan);
        }

        // Tagihan perpanjang
        if ($pengajuan->kualifikasi == 'kecil' and $pengajuan->jenis_pengajuan == 3) {
            
            $jml_tagihan = ($tagihan_provinsi->iuran_1_thn_kecil / 12) * 12;
            $this->jml_role_share_iuran = (($jml_tagihan) * $tagihan_provinsi->role_share_iuran_kecil/100);
            
        } elseif ($pengajuan->kualifikasi == 'menengah' and $pengajuan->jenis_pengajuan == 3) {
            $jml_tagihan = ($tagihan_provinsi->iuran_1_thn_menengah / 12) * 12;
            $this->jml_role_share_iuran = (($jml_tagihan) * $tagihan_provinsi->role_share_iuran_menengah/100);
           
        } elseif ($pengajuan->kualifikasi == 'besar' and $pengajuan->jenis_pengajuan == 3) {
            $jml_tagihan = ($tagihan_provinsi->iuran_1_thn_besar / 12) * 12;            
            $this->jml_role_share_iuran = (($jml_tagihan) * $tagihan_provinsi->role_share_iuran_besar/100);
        }

        $total_lama = 0 ;
        $total_naik = 0 ;
        $jml_tagihan_naik = 0 ;
        $jml_tagihan_lama = 0 ;

        if ($pengajuan->kualifikasi == 'kecil' and $pengajuan->jenis_pengajuan == 6) {
            
            $jml_tagihan_naik = ($tagihan_provinsi->iuran_1_thn_menengah / 12) * 12;
            $total_naik = (($jml_tagihan_naik) * $tagihan_provinsi->role_share_iuran_menengah/100);


            // Tagihan perpanjang
            if ($pengajuan->kualifikasi == 'kecil' ) {
                
                $jml_tagihan_lama = ($tagihan_provinsi->iuran_1_thn_kecil / 12) * 12;
                $total_lama = (($jml_tagihan_lama) * $tagihan_provinsi->role_share_iuran_kecil/100);
                
            } elseif ($pengajuan->kualifikasi == 'menengah' ) {
                
                $jml_tagihan_lama = ($tagihan_provinsi->iuran_1_thn_menengah / 12) * 12;
                $total_lama = (($jml_tagihan_lama) * $tagihan_provinsi->role_share_iuran_menengah/100);
               
            } elseif ($pengajuan->kualifikasi == 'besar' ) {
                
                $jml_tagihan_lama = ($tagihan_provinsi->iuran_1_thn_besar / 12) * 12;            
                $total_lama = (($jml_tagihan_lama) * $tagihan_provinsi->role_share_iuran_besar/100);
            }

            $jml_tagihan= $jml_tagihan_lama;
            $this->jml_role_share_iuran  = $total_lama;

            
        } elseif ($pengajuan->kualifikasi == 'menengah' and $pengajuan->jenis_pengajuan == 6) {
            $jml_tagihan_naik = ($tagihan_provinsi->iuran_1_thn_besar / 12) * 12;
            $total_naik = (($jml_tagihan_naik) * $tagihan_provinsi->role_share_iuran_besar/100);


            // Tagihan perpanjang
            if ($pengajuan->kualifikasi == 'kecil' ) {
                
                $jml_tagihan_lama = ($tagihan_provinsi->iuran_1_thn_kecil / 12) * 12;
                $total_lama = (($jml_tagihan_lama) * $tagihan_provinsi->role_share_iuran_kecil/100);
                
            } elseif ($pengajuan->kualifikasi == 'menengah' ) {
                
                $jml_tagihan_lama = ($tagihan_provinsi->iuran_1_thn_menengah / 12) * 12;
                $total_lama = (($jml_tagihan_lama) * $tagihan_provinsi->role_share_iuran_menengah/100);
               
            } elseif ($pengajuan->kualifikasi == 'besar' ) {
                
                $jml_tagihan_lama = ($tagihan_provinsi->iuran_1_thn_besar / 12) * 12;            
                $total_lama = (($jml_tagihan_lama) * $tagihan_provinsi->role_share_iuran_besar/100);
            }
            $jml_tagihan= $jml_tagihan_lama;
            $this->jml_role_share_iuran  = $total_lama;
        } 
        

        // Role share Uang Pangkal
        $this->jml_role_share_pangkal = ($tagihan_provinsi->uang_pangkal * $tagihan_provinsi->role_share_uang_pangkal/100);
        $total_role_share = 0;
        // Total role share
        if($pengajuan->jenis_pengajuan == 0) {
            $total_role_share = ($this->jml_role_share_iuran + $this->jml_role_share_pangkal);
        } else if ($pengajuan->jenis_pengajuan == 3) {
            $total_role_share = $this->jml_role_share_iuran;
        } else if ($pengajuan->jenis_pengajuan == 6) {
            $total_role_share = $this->jml_role_share_iuran;
        }
            

        $get_invoice_kta = InvoiceRoleShare::where('id_detail_kta',$idDetailKta)->where('jenis_pengajuan',$pengajuan->jenis_pengajuan)->first();
        $get_invoice = InvoiceRoleShare::where('id_detail_kta',$idDetailKta)->orderBy('created_at','asc')->first();
        
        $dataInvoiceAnggota=[];
        if(empty($get_invoice_kta))
        {        
            if ($id_dp == 17) {
                $publishInvoiceRoleShare = InvoiceRoleShare::create([
                    'id_detail_kta'     => $idDetailKta,
                    'no_invoice'        => "INV-DPN-INKINDO-".strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5)),
                    'jenis_pengajuan'   => $pengajuan->jenis_pengajuan,
                    'jml_tagihan_agt'   => 0,
                    'total_role_share'  => $total_role_share ,
                    'tgl_cetak'         => date('Y-m-d H:i:s'),
                    'status_pembayaran' => ($pengajuan->jenis_pengajuan == 1 or $pengajuan->jenis_pengajuan == 4) ? 1 : 0,
                ]);
            } else {
                 $updateKeterangan = HistoryApprovalPengajuan::where('id_detail_kta', $idDetailKta)
                ->update(
                [
                    'status_pengajuan' => 12,
                    'keterangan' => 'Invoice role share untuk pengajuan anda telah terbit.'
                ]);
                if($pengajuan->jenis_pengajuan==6)
                {   
                    $jml_tag = $total_naik - $total_lama ;
                    
                    $publishInvoiceRoleShare = InvoiceRoleShare::create([
                        'id_detail_kta'     => $idDetailKta,
                        'no_invoice'        => "INV-DPN-INKINDO-".strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5)),
                        'jenis_pengajuan'   => $pengajuan->jenis_pengajuan,
                        'jml_tagihan_agt'  => $jml_tagihan ,
                        'jml_tagihan_naik'  => $jml_tag ,
                        'total_role_share'  => $total_role_share ,
                        'tgl_cetak'         => date('Y-m-d H:i:s'),
                        'status_pembayaran' => ($pengajuan->jenis_pengajuan == 1 or $pengajuan->jenis_pengajuan == 4) ? 1 : 0,
                    ]);
                }
                else
                {
                    $publishInvoiceRoleShare = InvoiceRoleShare::create([
                        'id_detail_kta'     => $idDetailKta,
                        'no_invoice'        => "INV-DPN-INKINDO-".strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5)),
                        'jenis_pengajuan'   => $pengajuan->jenis_pengajuan,
                        'jml_tagihan_agt'  => $jml_tagihan ,
                        'total_role_share'  => $total_role_share ,
                        'tgl_cetak'         => date('Y-m-d H:i:s'),
                        'status_pembayaran' => ($pengajuan->jenis_pengajuan == 1 or $pengajuan->jenis_pengajuan == 4) ? 1 : 0,
                    ]);
                }
            }

            if ($publishInvoiceRoleShare) {
                
                $dataInvoiceRoleShare = [
                    'invoice'  => $publishInvoiceRoleShare,
                    'kta'      => $pengajuan,
                    'dpp'      => $tagihan_provinsi,
                    'dpn'      => $pengurus_nasional
                ];
                
                $council =  DewanPengurus::find($pengajuan->id_dp);
                    $to      =  UsersDppDpn::whereId_dp($council->id)->first();
                    
                    $notificationData = [
                        'id_dp' => $council->id,
                        'message' => 'Anda memiliki 1 invoice role sharing'               
                    ];
    
                    Notification::send($to, new NotifyCouncil($notificationData));
                    return $dataInvoiceRoleShare;
            }
        }
        else
        {
            if($pengajuan->jenis_pengajuan==6)
            {

                $updateKeterangan = HistoryApprovalPengajuan::where('id_detail_kta', $idDetailKta)
                ->update(
                [
                    'status_pengajuan' => 12,
                    'keterangan' => 'Invoice role share untuk pengajuan anda telah terbit.'
                ]);
                $jml_tag = $total_naik - $total_lama ;
                $dataInvoiceRoleShare = InvoiceRoleShare::where('id_detail_kta',$idDetailKta)
                ->where('jenis_pengajuan',6)
                ->update([
                    'jml_tagihan_agt'       => ($jml_tagihan == null) ? 0 : $jml_tagihan,
                    'tgl_cetak'         => date('Y-m-d H:i:s'),
                    'jml_tagihan_naik'  => $jml_tag ,
                    'total_role_share'  => $total_role_share
                ]);
            }
            else
            {
                $dataInvoiceRoleShare = InvoiceRoleShare::where('id_detail_kta',$idDetailKta)
                ->update([
                    'jml_tagihan_agt'       => ($jml_tagihan == null) ? 0 : $jml_tagihan,
                    'tgl_cetak'         => date('Y-m-d H:i:s'),
                    'total_role_share'  => $total_role_share
                ]);
            }
            

            return $dataInvoiceRoleShare;
        }
   
    }


    public function getInvoiceAnggotaPublished()
    {
        $invoicePublished = DB::table('t_invoice_role_share')
                          ->join('t_detail_kta', 't_invoice_role_share.id_detail_kta', '=', 't_detail_kta.id')
                          ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                          ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                          ->select('t_invoice_role_share.*', 't_registrasi_users.nm_bu', 't_kta.id_dp', 't_detail_kta.id as id_detail_kta');  
        //dd($invoicePublished);
                          
        return Datatables::of($invoicePublished)
        ->addColumn('action', function ($invoice) {
            return '
            <a href="'. route('dpn.invoice.show-role-share', ['no_invoice' => $invoice->no_invoice, 'id_detail_kta' => $invoice->id_detail_kta]) .'" class="btn btn-sm btn-primary"  id="publish-member-invoice"  title="Publish invoice for this member">INVOICE</a>
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
            if ($jenis_pengajuan->jenis_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'>Naik Kualifikasi</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 7) {
                return "<a class='btn btn-xs btn-warning'>Turun Kualifikasi</a>";
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
            if ($total_role_share->jenis_pengajuan === 6) {
                return "IDR.".number_format($total_role_share->jml_tagihan_naik);
            }
            else
            {
                return "IDR.".number_format($total_role_share->total_role_share);    
            }
            
        })
        ->rawColumns(['action', 'jenis_pengajuan', 'status_pembayaran'])
        ->make(true);
    }

    public function showInvoice($noInvoice, $idDetailKta)
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
                          'provinsi.name  as nama_provinsi',
                          't_detail_kta.waktu_pengajuan'

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
            return view('backend/dpn/content-pages/invoice/roleshare-invoice-template', compact('dataInvoiceRoleShare'));
        } else {
            abort(404);
        }
    }


    public function downloadInvoice($noInvoice, $idDetailKta)
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
                          'provinsi.name  as nama_provinsi',
                          't_detail_kta.waktu_pengajuan'


                      )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
        
                      $tagihan_provinsi  = DewanPengurus::where('id', $pengajuan->id_dp)->first();
                      $pengurus_nasional  = DewanPengurus::where('level', 1)->first();
                       
    

        if ($dataInvoice && $pengajuan && $tagihan_provinsi && $pengurus_nasional) {
            $dataInvoiceRoleShare = [
                'invoice' => $dataInvoice,
                'kta'     => $pengajuan,
                'dpp'     => $tagihan_provinsi,
                'dpn'     => $pengurus_nasional,
            ];
            $pdf = PDF::loadView('prints-template.invoice-role-share', compact('dataInvoiceRoleShare'))->setPaper('a4', 'landscape');
            return $pdf->stream('invoice |'.$pengajuan->nm_bu.'.pdf');
        } else {
            abort(404);
        }

       
    }

    public function publishInvoiceAnggotaAfiliasi(Request $request)
    {
        $idDetailKta = $request->id_detail_kta;

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                      ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                     
                      ->select(
                          't_kta.jenis_bu',
                          't_kta.kualifikasi',
                          't_detail_kta.jenis_pengajuan',
                          't_registrasi_users.email_bu',
                          't_registrasi_users.nm_bu',
                          't_detail_kta.masa_berlaku',
                          't_administrasi_kta.alamat',
                          't_administrasi_kta.no_telp',
                          't_detail_kta.id as id_detail_kta',
                          't_kta.id_dp',
                          'provinsi.name  as nama_provinsi',
                          't_detail_kta.waktu_pengajuan'
                      )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
                      
        $pengurus_nasional  = DewanPengurus::where('level', 1)->first();
        
        
    
        // Tagihan anggota afiliasi
        if ($pengajuan->kualifikasi == 'besar' and $pengajuan->jenis_pengajuan == 0) {
            $this->jml_tagihan_agt = ($pengurus_nasional->iuran_1_thn_besar + $pengurus_nasional->uang_pangkal);
        } elseif($pengajuan->kualifikasi == 'besar' and $pengajuan->jenis_pengajuan == 3) {
            $this->jml_tagihan_agt = ($pengurus_nasional->iuran_1_thn_besar);
        }
       
        

        $publishInvoiceAnggotaAfiliasi = InvoicePengajuanKta::create([
          'id_detail_kta'     => $idDetailKta,
          'no_invoice'        => "INV-DPN-INKINDO-".substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5),
          'jenis_pengajuan'   => $pengajuan->jenis_pengajuan,
          'jml_tagihan'       => ($pengajuan->jenis_pengajuan == 0 or $pengajuan->jenis_pengajuan == 3) ? $this->jml_tagihan_agt : 0,
          'tgl_cetak'         => date('Y-m-d H:i:s'),
          'status_pembayaran' => ($pengajuan->jenis_pengajuan == 1 or $pengajuan->jenis_pengajuan == 4) ? 1 : 0,
        ]);

        if($publishInvoiceAnggotaAfiliasi) {
            $updateKeterangan = HistoryApprovalPengajuan::where('id_detail_kta', $idDetailKta)
            ->update(
                [
                    'status_pengajuan' => ($pengajuan->jenis_pengajuan == 0 or $pengajuan->jenis_pengajuan == 3) ? 5 : 6,
                    'keterangan' => ($pengajuan->jenis_pengajuan == 0 or $pengajuan->jenis_pengajuan == 3) ? 'Invoice untuk pengajuan anda telah terbit, Silahkan lihat pada menu invoice.' : 'Menunggu Nomor KTA'
                ]
                );
            $updataNotification = DetailKta::findOrFail($idDetailKta)
                                  ->update(['view_notifikasi' => 0]);

                                  $dataInvoiceAnggotaAfiliasi = [
                'invoice'  => $publishInvoiceAnggotaAfiliasi,
                'kta'      => $pengajuan,
                'dpn'      => $pengurus_nasional
            ];
            dispatch(new SendInvoiceAnggotaAfiliasi($dataInvoiceAnggotaAfiliasi));
            return $dataInvoiceAnggotaAfiliasi;
        }
        
    }

    public function getInvoiceAnggotaAfiliasiPublished()
    {
        $invoicePublished = DB::table('t_invoice_kta')
                          ->join('t_detail_kta', 't_invoice_kta.id_detail_kta', '=', 't_detail_kta.id')
                          ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                          ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                          ->select('t_invoice_kta.*', 't_registrasi_users.nm_bu', 't_kta.id_dp', 't_detail_kta.id as id_detail_kta')
                          ->where('t_kta.jenis_bu', '=', 'pma');  
        //dd($invoicePublished);
                          
        return Datatables::of($invoicePublished)
        ->addColumn('action', function ($invoice) {
            return '
            <a href="'. route('dpn.invoice.show-afiliasi', ['no_invoice' => $invoice->no_invoice, 'id_detail_kta' => $invoice->id_detail_kta]) .'" class="btn btn-sm btn-primary"  id="publish-member-invoice"  title="Publish invoice for this member">INVOICE</a>
            ';
        })

        ->editColumn('jenis_pengajuan', function ($jenis_pengajuan) {
             if ($jenis_pengajuan->jenis_pengajuan === 0) {
                return "<a class='btn btn-xs btn-primary'>buat baru</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 1) {
                return "<a class='btn btn-xs btn-success'>Daftar ulang</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 3) {
                return "<a class='btn btn-xs btn-warning'>Perpanjang</a>";
            }
            if ($jenis_pengajuan->jenis_pengajuan === 6) {
                return "<a class='btn btn-xs btn-warning'>Naik Kualifikasi</a>";
            }

            if ($jenis_pengajuan->jenis_pengajuan === 7) {
                return "<a class='btn btn-xs btn-warning'>Turun Kualifikasi</a>";
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

    public function showInvoiceAfiliasi($noInvoice, $idDetailKta)
    {
        $dataInvoice = InvoicePengajuanKta::where('no_invoice', $noInvoice)->first();

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                      ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                      
                      ->select(
                          't_kta.jenis_bu',
                          't_kta.kualifikasi',
                          't_detail_kta.jenis_pengajuan',
                          't_registrasi_users.email_bu',
                          't_registrasi_users.nm_bu',
                          't_detail_kta.masa_berlaku',
                          't_administrasi_kta.alamat',
                          't_administrasi_kta.no_telp',
                          't_detail_kta.id as id_detail_kta',
                          't_kta.id_dp',
                          'provinsi.name  as nama_provinsi',
                          't_detail_kta.waktu_pengajuan'

                      )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
        
        $pengurus_nasional  = DewanPengurus::where('level', 1)->first();
              
        if ($dataInvoice && $pengajuan && $pengurus_nasional) {
            $dataInvoiceAfiliasi = [
                'invoice'  => $dataInvoice,
                'kta'      => $pengajuan,
                'dpn'      => $pengurus_nasional
            ];
            return view('backend/dpn/content-pages/invoice/afiliasi-invoice-template', compact('dataInvoiceAfiliasi'));
        } else {
            abort(404);
        }
    }

    public function downloadInvoiceAfiliasi($noInvoice, $idDetailKta)
    {
        $dataInvoice = InvoicePengajuanKta::where('no_invoice', $noInvoice)->first();

        $pengajuan  = DB::table('t_kta')
                      ->join('t_detail_kta', 't_kta.id', '=', 't_detail_kta.id_kta')
                      ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                      ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                      ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                      ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                      ->select(
                          't_kta.jenis_bu',
                          't_kta.kualifikasi',
                          't_detail_kta.jenis_pengajuan',
                          't_registrasi_users.email_bu',
                          't_registrasi_users.nm_bu',
                          't_detail_kta.masa_berlaku',
                          't_administrasi_kta.alamat',
                          't_administrasi_kta.no_telp',
                          't_detail_kta.id as id_detail_kta',
                          't_kta.id_dp',
                          'provinsi.name  as nama_provinsi',
                          't_detail_kta.waktu_pengajuan'


                      )
                      ->where('t_detail_kta.id', $idDetailKta)
                      ->first();
        
                  $pengurus_nasional  = DewanPengurus::where('level', 1)->first();
                       
    

        if ($dataInvoice && $pengajuan && $pengurus_nasional) {
            $dataInvoiceAnggotaAfiliasi = [
                'invoice' => $dataInvoice,
                'kta'     => $pengajuan,
                'dpn'     => $pengurus_nasional,
            ];
            $pdf = PDF::loadView('prints-template.invoice-anggota-afiliasi', compact('dataInvoiceAnggotaAfiliasi'))->setPaper('a4', 'landscape');
            return $pdf->stream('invoice |'.$pengajuan->nm_bu.'.pdf');
        } else {
            abort(404);
        }

       
    }




}
