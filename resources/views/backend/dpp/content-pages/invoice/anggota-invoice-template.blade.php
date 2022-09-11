<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice | {!! $dataInvoiceAnggota['kta']->nm_bu !!} </title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/build/css/custom.min.css') }}" rel="stylesheet">
    <style>
        body {
            color: #000 !important;
        }
        .container {
            width: 91% !important;
            padding: 0;
        }

        .watermarked {
            width: 243px;
            position: absolute;
            top: -26px;
            right: -14px;
        }

        table th {
            background: #0c2461;
            color:#fff
        }

        table #r1 {
            background: #DEEAF6;
            color: #000;
        }

        table #r2 {
            background: #FCC9B9;
            color: #000;
        }

        .bottom-row {
            background: #EEEEEE;
            padding: 10px;
            margin-bottom:10px; 
        }

        .rek {
            background: #C4EFF6;
            color: #000;
            font-weight: bold;
        }

        .table {
            margin-bottom: 0px !important;
        }
        
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <section class="content invoice">
                            {{-- @if ($dataInvoiceAnggota['invoice']->status_pembayaran == 1)
                            <img src="{{ asset('backend/kta-assets/paid-watermark.png') }}" class="watermarked" alt=""> 
                            @endif --}}
                      
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1>
                                        <a>
                                            <img src="{{ asset('backend/kta-assets/logo-invoice.png') }}"
                                                style="width:180px; max-width:300px; margin-bottom:10px;">
                                        </a>
                                        
                                                @if ($dataInvoiceAnggota['invoice']->status_pembayaran == 0)
                                                <img src="{{ asset('backend/kta-assets/UNPAID.png') }}" class="watermarked pull-right" alt=""> 
                                                @endif
                                                @if ($dataInvoiceAnggota['invoice']->status_pembayaran == 1)
                                                <img src="{{ asset('backend/kta-assets/Paid.png') }}" class="watermarked pull-right" alt=""> 
                                                @endif
                                                
                                        
                                    </h1>
                                </div>

                            </div>

                            <div class="row invoice-info">
                                <div class="col-sm-4 col-xs-4 invoice-col">
                                    From
                                    <address>
                                        <strong>Dewan Pengurus Ikatan Nasional Konsultan Indonesia</strong>
                                        <br>{!! $dataInvoiceAnggota['pengurus']->alamat !!}
                                        <br>Phone: {!! $dataInvoiceAnggota['pengurus']->no_telp_dewan_pengurus !!}
                                        <br>Email: {!! $dataInvoiceAnggota['pengurus']->email_dewan_pengurus !!}
                                    </address>
                                </div>

                                <div class="col-sm-4 col-xs-4 invoice-col">
                                    To
                                    <address>
                                        <strong>{!! $dataInvoiceAnggota['kta']->nm_bu !!}</strong>
                                        <br>{!! $dataInvoiceAnggota['kta']->alamat !!}

                                        <br>Phone: {!! $dataInvoiceAnggota['kta']->no_telp !!}
                                        <br>Email:{!! $dataInvoiceAnggota['kta']->email_bu !!}
                                    </address>
                                </div>

                                <div class="col-sm-4 col-xs-4 invoice-col">
                                    <b>No Invoice : <span style="color:#000">{!! $dataInvoiceAnggota['invoice']->no_invoice !!}</span></b>
                                    <br>
                                    <span>Invoice : Registrasi Anggota Inkindo</span>
                                    <br>
                                    <span>Invoice Date : {!! Carbon\Carbon::parse($dataInvoiceAnggota['invoice']->tgl_cetak)->formatLocalized('%d %B %Y') !!}</span>
                                    <br>  
                                    <span>Due Date : {!! Carbon\Carbon::parse($dataInvoiceAnggota['invoice']->tgl_cetak)->modify( 'next month')->formatLocalized('%d %B %Y') !!}</span>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-xs-12 table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th style="width: 40%">Deskripsi</th>
                                                <th>Permohonan</th>
                                                <th>Kualifikasi</th>
                                                <th>Masa Berlaku</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="r1">
                                                <td>1</td>
                                                <td>Uang Pangkal</td>
                                                <td>
                                                        @if ($dataInvoiceAnggota['invoice']->jenis_pengajuan == 0 )
                                                        Anggota Baru
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 1)
                                                        Daftar Ulang
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)
                                                        Perpanjangan
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 6)
                                                        Naik Kualifikasi
                                                        @endif 
                                                </td>
                                                <td>{!! $dataInvoiceAnggota['kta']->kualifikasi !!}</td>
                                                <td>-</td>
                                                <td>
                                                        @if ($dataInvoiceAnggota['invoice']->jenis_pengajuan == 0)
                                                        IDR. {!! number_format($dataInvoiceAnggota['pengurus']->uang_pangkal) !!}
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)
                                                        -
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 6)
                                                        
                                                        @else
                                                            IDR. {!! number_format($dataInvoiceAnggota['pengurus']->uang_pangkal) !!}
                                                        @endif
                                                </td>
                                            </tr>
                                            <tr id="r2">
                                                <td>2</td>
                                                <td>
                                                    Iuran Keanggotaan untuk bulan : <br>
                                                        @if ($dataInvoiceAnggota['invoice']->jenis_pengajuan == 0 )
                                                            @php 
                                                            $date_now = \App\Helpers\LocalDate::date_invoice_now($dataInvoiceAnggota['kta']->waktu_pengajuan);
                                                            $date_next = \App\Helpers\LocalDate::date_invoice_next($dataInvoiceAnggota['kta']->waktu_pengajuan);

                                                            echo $date_now;
                                                            echo $date_next;
                                                          
                                                            @endphp
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 1)
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 6)
                                                       
                                                        

                                                        Jumlah Tagihan Baru = 
                                                        @if ($dataInvoiceAnggota['kta']->kualifikasi == 'kecil')
                                                            IDR. {!! number_format(($dataInvoiceAnggota['pengurus']->iuran_1_thn_menengah / 12) *  12) !!}
                                                        @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'menengah')
                                                            IDR. {!! number_format( ($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar /12 )  * 12) !!}    
                                                        @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'besar')
                                                            IDR. {!! number_format( ($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar / 12) * 12) !!}       
                                                        @endif

                                                        - 
                                                        
                                                        Jumlah Tagihan Lama = IDR. {!! number_format($dataInvoiceAnggota['invoice']->jml_tagihan) !!} 
                                                        

                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)
                                                        @php
                                                           
                                                            $date_now = \App\Helpers\LocalDate::date_invoice_now($dataInvoiceAnggota['kta']->waktu_pengajuan);
                                                            $date_next = \App\Helpers\LocalDate::date_invoice_next($dataInvoiceAnggota['kta']->waktu_pengajuan);

                                                            echo $date_now;
                                                            echo $date_next;

                                                        @endphp
                                                        @endif
                                                    
                                                </td>
                                                <td>
                                                    @if ($dataInvoiceAnggota['invoice']->jenis_pengajuan == 0 )
                                                    Anggota Baru
                                                    @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 1)
                                                    Daftar Ulang
                                                    @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)
                                                    Perpanjangan
                                                    @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 6)
                                                        Naik Kualifikasi
                                                    @endif
                                                </td>
                                                <td>{!! $dataInvoiceAnggota['kta']->kualifikasi !!}</td>
                                                <td>{!! $dataInvoiceAnggota['kta']->masa_berlaku !!}</td>
                                                <td>
                                                        @php  
                                                            $v_iuran =0;
                                                    
                                                            $year_now = date("Ym",strtotime($dataInvoiceAnggota['kta']->waktu_pengajuan));
                                                            $year_min = date("Y12",strtotime($dataInvoiceAnggota['kta']->waktu_pengajuan));
                                                            $startTimeStamp = strtotime($year_now);
                                                            $endTimeStamp = strtotime($year_min);
                                                            $month_from = date("F Y",strtotime($dataInvoiceAnggota['kta']->waktu_pengajuan));

                                                            $timeDiff = abs($endTimeStamp - $startTimeStamp)+1;
                                                            if($startTimeStamp == $endTimeStamp)
                                                            {
                                                                $timeDiff=1;
                                                            }
                                                            $price_cut =0;

                                                            $month_cut = strtotime( date("F", mktime(0, 0, 0, 7, 10)).date("Y",strtotime($dataInvoiceAnggota['kta']->waktu_pengajuan)) ) ; 
                                                            $get_month_now = strtotime($month_from);



                                                        @endphp
                                                                
                                                                @if($dataInvoiceAnggota['invoice']->jenis_pengajuan == 0)
                                                                    @if ($dataInvoiceAnggota['kta']->kualifikasi == 'kecil')
                                                                        @php 
                                                                        $v_iuran = \App\Helpers\LocalDate::get_contribution_now($dataInvoiceAnggota['pengurus']->iuran_1_thn_kecil,$timeDiff);
                                                                        @endphp
                                                                        <br>
                                                                        IDR. {!! number_format($v_iuran) !!} <br>
                                                                        @if($month_cut < $get_month_now)
                                                                            IDR.
                                                                            @php 
                                                                               $price_cut = \App\Helpers\LocalDate::get_contribution_next($dataInvoiceAnggota['pengurus']->iuran_1_thn_kecil);
                                                                               echo number_format($price_cut);

                                                                            @endphp

                                                                        @endif
                                                                        

                                                                    @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'menengah')
                                                                        @php 
                                                                        $v_iuran = \App\Helpers\LocalDate::get_contribution_now($dataInvoiceAnggota['pengurus']->iuran_1_thn_menengah,$timeDiff);
                                                                        @endphp
                                                                        <br>
                                                                        IDR. {!! number_format( $v_iuran) !!}  <br>
                                                                        @if($month_cut < $get_month_now)
                                                                            IDR.
                                                                            @php 
                                                                                $price_cut = \App\Helpers\LocalDate::get_contribution_next($dataInvoiceAnggota['pengurus']->iuran_1_thn_menengah);
                                                                                echo number_format($price_cut);
                                                                            @endphp
                                                                        @endif
                                                                
                                                                    @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'besar')
                                                                        @php
                                                                            $v_iuran = \App\Helpers\LocalDate::get_contribution_now($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar,$timeDiff);
                                                                        @endphp
                                                                        IDR. {!! number_format( $v_iuran ) !!}   <br>
                                                                        @if($month_cut < $get_month_now)
                                                                            IDR.
                                                                            @php 
                                                                                $price_cut = \App\Helpers\LocalDate::get_contribution_next($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar);
                                                                                echo number_format($price_cut);
                                                                            @endphp
                                                                        @endif
                                                                    @endif
                                                                
                                                                @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 1)

                                                                    @if ($dataInvoiceAnggota['kta']->kualifikasi == 'kecil')
                                                                        @php 
                                                                        $v_iuran = \App\Helpers\LocalDate::get_contribution_now($dataInvoiceAnggota['pengurus']->iuran_1_thn_kecil,$timeDiff);
                                                                        @endphp
                                                                        
                                                                        IDR. {!! number_format($v_iuran) !!} 
                                                                        @if($month_cut < $get_month_now)
                                                                            IDR.
                                                                            @php 
                                                                               $price_cut = \App\Helpers\LocalDate::get_contribution_next($dataInvoiceAnggota['pengurus']->iuran_1_thn_kecil);
                                                                                echo number_format($price_cut);
                                                                            @endphp
                                                                        @endif
                                                                        

                                                                    @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'menengah')
                                                                        @php 
                                                                        $v_iuran = \App\Helpers\LocalDate::get_contribution_now($dataInvoiceAnggota['pengurus']->iuran_1_thn_menengah,$timeDiff);
                                                                        
                                                                        @endphp
                                                                        
                                                                        IDR. {!! number_format( $v_iuran) !!}  
                                                                        @if($month_cut < $get_month_now)
                                                                            IDR.
                                                                            @php 
                                                                                $price_cut = \App\Helpers\LocalDate::get_contribution_next($dataInvoiceAnggota['pengurus']->iuran_1_thn_menengah);
                                                                                echo number_format($price_cut);
                                                                            @endphp
                                                                        @endif
                                                                
                                                                    @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'besar')
                                                                        @php
                                                                            
                                                                            $v_iuran = \App\Helpers\LocalDate::get_contribution_now($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar,$timeDiff);
                                                                        @endphp
                                                                        IDR. {!! number_format( $v_iuran) !!}   
                                                                        @if($month_cut < $get_month_now)
                                                                            IDR.
                                                                            @php 
                                                                                $price_cut = \App\Helpers\LocalDate::get_contribution_next($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar);
                                                                                echo number_format($price_cut);
                                                                            @endphp
                                                                        @endif
                                                                    @endif
                                                                   
                                                                @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)

                                                                    @if ($dataInvoiceAnggota['kta']->kualifikasi == 'kecil')
                                                                        IDR. {!! number_format(( $dataInvoiceAnggota['pengurus']->iuran_1_thn_kecil / 12) *  12) !!}
                                                                        @php 
                                                                            $v_iuran = ($dataInvoiceAnggota['pengurus']->iuran_1_thn_kecil / 12) * 12;
                                                                        @endphp
                                                                    @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'menengah')
                                                                        IDR. {!! number_format( ($dataInvoiceAnggota['pengurus']->iuran_1_thn_menengah /12 )  * 12) !!}    
                                                                        @php 
                                                                            $v_iuran = ($dataInvoiceAnggota['pengurus']->iuran_1_thn_menengah / 12) * 12;
                                                                        @endphp
                                                                    @elseif($dataInvoiceAnggota['kta']->kualifikasi == 'besar')
                                                                        IDR. {!! number_format( ($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar / 12) * 12) !!}       
                                                                        @php 
                                                                            $v_iuran = ($dataInvoiceAnggota['pengurus']->iuran_1_thn_besar/12) * 12;
                                                                        @endphp
                                                                    @endif
                                                                
                                                                @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 6)
                                                                    IDR. {!! number_format( $dataInvoiceAnggota['invoice']->jml_tagihan_naik) !!}

                                                                   
                                                                @endif 
                                                </td>
                                            </tr>

                                            <tr id="r2">
                                                <td>3</td>
                                                <td>Sumbangan Uang Gedung dan lain-lain</td>
                                                <td>
                                                        @if ($dataInvoiceAnggota['invoice']->jenis_pengajuan == 0 )
                                                        Anggota Baru
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 1)
                                                        Daftar Ulang
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)
                                                        Perpanjangan
                                                        @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 6)
                                                        Naik Kualifikasi
                                                        @endif 
                                                </td>
                                                <td>{!! $dataInvoiceAnggota['kta']->kualifikasi !!}</td>
                                                <td>{!! $dataInvoiceAnggota['kta']->masa_berlaku !!}</td>
                                                <td>
                                                    @if ($dataInvoiceAnggota['invoice']->jenis_pengajuan == 0)
                                                    IDR. {!! number_format($dataInvoiceAnggota['pengurus']->uang_gedung) !!}
                                                    @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)
                                                    -
                                                    @else 
                                                    IDR. {!! number_format($dataInvoiceAnggota['pengurus']->uang_gedung) !!}
                                                    @endif
                                                </td>
                                            </tr>
                                                
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="row bottom-row">
                                <div class="col-xs-9">
                                    <p class="lead">Metode Pembayaran:</p>
                                    <div class="text-muted well well-sm no-shadow rek" style="margin-top: 10px;">
                                            <span>Pembayaran melalui transfer bank : </span>
                                           
                                        <table class="table2">
                                                    <tr>
                                                        <td><span>No Rekening</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceAnggota['pengurus']->no_rek !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Atas Nama</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceAnggota['pengurus']->nm_rek !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Nama Bank</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceAnggota['pengurus']->nm_bank !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Kode Bank</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceAnggota['pengurus']->kode_bank !!}</td>
                                                    </tr>
                                                </table>

                                                <p>Catatan :</p>
                                                <ol>
                                                    <li>Untuk kenyamanan anda saat menggunakan layanan ini silahkan lakukan pembayaran minimal 7 hari
                                                        sebelum jatuh tempo</li>
                                                        <li>Harap lakukan konfirmasi pembayaran apabila anda telah melakukan pembayaran</li>
                                                </ol>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                   
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Grand Total:</strong></td>
                                                    <td ><strong>IDR   
                                                    @php 
                                                     $jml_role_share_pangkal = ($dataInvoiceAnggota['pengurus']->uang_pangkal * $dataInvoiceAnggota['pengurus']->tagihan_provinsi/100);
                                                    @endphp

                                                    @if($dataInvoiceAnggota['invoice']->jenis_pengajuan == 1)
                                                        @php echo 0; @endphp
                                                    @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 3)
                                                        @php 
                                                            echo number_format($v_iuran); 
                                                        @endphp
                                                    
                                                    @elseif($dataInvoiceAnggota['invoice']->jenis_pengajuan == 6)
                                                        @php 
                                                            echo number_format($dataInvoiceAnggota['invoice']->jml_tagihan_naik);
                                                        @endphp
                                                    @else 
                                                        @php 
                                                        $jum = $dataInvoiceAnggota['pengurus']->uang_gedung + $dataInvoiceAnggota['pengurus']->uang_pangkal + $v_iuran + $price_cut;

                                                        echo number_format($jum);  

                                                        @endphp
                                                    @endif
                                                        
                                                        </strong></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div id="qr" style="padding-top:30px; padding-left:80px">
                                                {!! DNS2D::getBarcodeHTML(url('panel/dpp/invoice/invoice-anggota-showing/'.$dataInvoiceAnggota['invoice']->no_invoice.'/'.$dataInvoiceAnggota['kta']->id_detail_kta), "QRCODE", 3,3) !!}
                                        </div>
                                        </div>
                                </div>

                            </div>

                            <div class="row no-print">
                                <div class="col-xs-12">
                                    <a href="{{ route('dpp.invoice.download', ['no_invoice' => $dataInvoiceAnggota['invoice']->no_invoice, 'id_detail_kta' => $dataInvoiceAnggota['kta']->id_detail_kta]) }}" class="btn btn-default pull-right"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend/build/js/custom.min.js') }}" type="953f9ddfbd71f1ba52dbf194-text/javascript">
    </script>
    <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/95c75768/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="953f9ddfbd71f1ba52dbf194-|49" defer=""></script>
        
</body>

</html>