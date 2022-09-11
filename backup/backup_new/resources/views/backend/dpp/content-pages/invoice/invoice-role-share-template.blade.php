<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Invoice By DPN Inkindo </title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/build/css/custom.min.css') }}" rel="stylesheet">
    <style>
        @page { margin: 0px; }

        body {
            color: #000 !important;
            margin: 0px;
        }
        .container {
            width: 91% !important;
            padding: 0;
        }

        .watermarked {
            width: 243px;
            margin-top: -30px;
            margin-right: -24px;
        }

        table th  {
            background: #0c2461;
            color:#fff !important;
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
            margin-bottom: 10px !important;
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
                            {{-- @if ($dataInvoiceRoleShare['invoice']->status_pembayaran == 1)
                            <img src="{{ asset('backend/kta-assets/paid-watermark.png') }}" class="watermarked" alt=""> 
                            @endif --}}
                      
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1>
                                        <a>
                                            <img src="{{ asset('backend/kta-assets/logo-invoice.png') }}"
                                                style="width:180px; max-width:300px; margin-bottom:10px;">
                                        </a>
                                        
                                                @if ($dataInvoiceRoleShare['invoice']->status_pembayaran == 0)
                                                <img src="{{ asset('backend/kta-assets/UNPAID.png') }}" class="watermarked pull-right" alt=""> 
                                                @endif
                                                @if ($dataInvoiceRoleShare['invoice']->status_pembayaran == 1)
                                                <img src="{{ asset('backend/kta-assets/Paid.png') }}" class="watermarked pull-right" alt=""> 
                                                @endif
                                                
                                        
                                    </h1>
                                </div>

                            </div>

                            <div class="row invoice-info">
                                <div class="col-sm-4 col-xs-4 invoice-col">
                                    From
                                    <address>
                                        <strong>Dewan Pengurus Nasional<br> Ikatan Nasional Konsultan Indonesia</strong>
                                        <br>{!! $dataInvoiceRoleShare['dpn']->alamat !!}
                                        <br>Phone: {!! $dataInvoiceRoleShare['dpn']->no_telp_dewan_pengurus !!}
                                        <br>Email: {!! $dataInvoiceRoleShare['dpn']->email_dewan_pengurus !!}
                                    </address>
                                </div>

                                <div class="col-sm-4 col-xs-4 invoice-col">
                                    To
                                    <address>
                                        <strong>Dewan Pengurus Provinsi {!! $dataInvoiceRoleShare['kta']->nama_provinsi !!}<br> Ikatan Nasional Konsultan Indonesia</strong>
                                        <br>{!! $dataInvoiceRoleShare['dpp']->alamat !!}
                                        <br>Phone: {!! $dataInvoiceRoleShare['dpp']->no_telp_dewan_pengurus !!}
                                        <br>Email: {!! $dataInvoiceRoleShare['dpp']->email_dewan_pengurus !!}
                                    </address>
                                </div>

                                <div class="col-sm-4 col-xs-4 invoice-col">
                                    <b>No Invoice : <span style="color:#000">{!! $dataInvoiceRoleShare['invoice']->no_invoice !!}</span></b>
                                    <br>
                                    <span>Invoice : Role Sharing Anggota</span>
                                    <br>
                                    <span>Invoice Date : {!! Carbon\Carbon::parse($dataInvoiceRoleShare['invoice']->tgl_cetak)->formatLocalized('%d %B %Y') !!}</span>
                                    <br>  
                                    <span>Due Date : {!! Carbon\Carbon::parse($dataInvoiceRoleShare['invoice']->tgl_cetak)->modify( 'next month')->formatLocalized('%d %B %Y') !!}</span>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-xs-12 table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th style="width: 20%">Deskripsi</th>
                                                <th>Permohonan</th>
                                                <th>Kualifikasi</th>
                                                <th>Total Tagihan Ke Anggota</th>
                                                <th>Role Sharing DPN</th>
                                                <th>Masa Berlaku</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="r1">
                                                <td>1</td>
                                                <td>Uang Pangkal</td>
                                                <td>
                                                        @if ($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 0 )
                                                        Anggota Baru
                                                        @elseif($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 1)
                                                        Daftar Ulang
                                                        @elseif($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 3)
                                                        Perpanjangan
                                                        @endif 
                                                </td>
                                                <td>{!! $dataInvoiceRoleShare['kta']->kualifikasi !!}</td>
                                                <td>IDR. {!! number_format($dataInvoiceRoleShare['dpp']->uang_pangkal) !!}</td>
                                                <td>
                                                        {!! $dataInvoiceRoleShare['dpp']->role_share_uang_pangkal !!}%
                                                </td>
                                                <td>-</td>
                                                <td>
                                                        @if($dataInvoiceRoleShare['kta']->kualifikasi == 'kecil')
                                                        IDR. {!! number_format($dataInvoiceRoleShare['dpp']->uang_pangkal * $dataInvoiceRoleShare['dpp']->role_share_uang_pangkal/100) !!}
                                                        @elseif($dataInvoiceRoleShare['kta']->kualifikasi == 'menengah')
                                                        IDR. {!! number_format($dataInvoiceRoleShare['dpp']->uang_pangkal * $dataInvoiceRoleShare['dpp']->role_share_uang_pangkal/100) !!}
                                                        @elseif($dataInvoiceRoleShare['kta']->kualifikasi == 'besar')
                                                        IDR. {!! number_format($dataInvoiceRoleShare['dpp']->uang_pangkal * $dataInvoiceRoleShare['dpp']->role_share_uang_pangkal/100) !!}
                                                        @endif
                                                    
                                                </td>
                                            </tr>
                                            <tr id="r2">
                                                    <td>2</td>
                                                    <td>
                                                    Iuran Keanggotaan untuk bulan : <br>
                                                        @if ($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 0 )
                                                            @php 
                                                            $date_now = \App\Helpers\LocalDate::date_invoice_now($dataInvoiceRoleShare['kta']->waktu_pengajuan);
                                                            $date_next = \App\Helpers\LocalDate::date_invoice_next($dataInvoiceRoleShare['kta']->waktu_pengajuan);

                                                            echo $date_now;
                                                            echo $date_next;
                                                          
                                                            @endphp
                                                        @elseif($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 1)
                                                        @elseif($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 3)
                                                        @php
                                                           
                                                            $date_now = \App\Helpers\LocalDate::date_invoice_now($dataInvoiceRoleShare['kta']->waktu_pengajuan);
                                                            $date_next = \App\Helpers\LocalDate::date_invoice_next($dataInvoiceRoleShare['kta']->waktu_pengajuan);

                                                            echo $date_now;
                                                            echo $date_next;

                                                        @endphp
                                                        @endif
                                                    </td>
                                                    <td>
                                                            @if ($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 0 )
                                                            Anggota Baru
                                                            @elseif($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 1)
                                                            Daftar Ulang
                                                            @elseif($dataInvoiceRoleShare['invoice']->jenis_pengajuan == 3)
                                                            Perpanjangan
                                                            @endif 
                                                    </td>
                                                    <td>{!! $dataInvoiceRoleShare['kta']->kualifikasi !!}</td>
                                                    <td>
                                                        IDR. {{ number_format($dataInvoiceRoleShare['invoice']->jml_tagihan_agt) }}
                                                    </td>
                                                    <td>
                                                        @if($dataInvoiceRoleShare['kta']->kualifikasi == 'kecil')
                                                        {!! $dataInvoiceRoleShare['dpp']->role_share_iuran_kecil !!}%
                                                        @elseif($dataInvoiceRoleShare['kta']->kualifikasi == 'menengah')
                                                        {!! $dataInvoiceRoleShare['dpp']->role_share_iuran_menengah !!}%
                                                        @elseif($dataInvoiceRoleShare['kta']->kualifikasi == 'besar')
                                                        {!! $dataInvoiceRoleShare['dpp']->role_share_iuran_besar !!}%
                                                        @endif
                                                    </td>
                                                    <td>{{ $dataInvoiceRoleShare['kta']->masa_berlaku }}</td>
                                                    <td>
                                    
                                                            @if($dataInvoiceRoleShare['kta']->kualifikasi == 'kecil')
                                                            IDR. {!! number_format($dataInvoiceRoleShare['invoice']->jml_tagihan_agt * $dataInvoiceRoleShare['dpp']->role_share_iuran_kecil/100) !!}
                                                            @elseif($dataInvoiceRoleShare['kta']->kualifikasi == 'menengah')
                                                            IDR. {!! number_format($dataInvoiceRoleShare['invoice']->jml_tagihan_agt * $dataInvoiceRoleShare['dpp']->role_share_iuran_menengah/100) !!}
                                                            @elseif($dataInvoiceRoleShare['kta']->kualifikasi == 'besar')
                                                            IDR. {!! number_format($dataInvoiceRoleShare['invoice']->jml_tagihan_agt * $dataInvoiceRoleShare['dpp']->role_share_iuran_besar/100) !!}
                                                            @endif
                                                        
                                                    </td>
                                                </tr>    
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="row bottom-row">
                                <div class="col-xs-8">
                                    <p class="lead">Metode Pembayaran:</p>
                                    <div class="text-muted well well-sm no-shadow rek" style="margin-top: 10px;">
                                            <span>Pembayaran melalui transfer bank : </span>
                                           
                                        <table class="table2" width="400">
                                                    <tr>
                                                        <td><span>No Rekening</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceRoleShare['dpn']->no_rek !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Atas Nama</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceRoleShare['dpn']->nm_rek !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Nama Bank</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceRoleShare['dpn']->nm_bank !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span>Kode Bank</span>&nbsp;&nbsp;</td>
                                                        <td>:</td> 
                                                        <td>&nbsp;{!! $dataInvoiceRoleShare['dpn']->kode_bank !!}</td>
                                                    </tr>
                                                </table>

                                                <p>Catatan :</p>
                                                <ol>
                                                    <li>Untuk kenyamanan anda saat menggunakan layanan ini silahkan lakukan pembayaran minimal 2 hari sebelum jatuh tempo</li>
                                                    <li> Harap lakukan konfirmasi pembayaran apabila anda telah melakukan pembayaran</li>
                                                </ol>
                                    </div>
                                </div>

                                <div class="col-xs-4">
                                   
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td style="width:12%"></td>
                                                    <td><strong>Grand Total:</strong></td>
                                                    <td ><strong>IDR.{!! number_format($dataInvoiceRoleShare['invoice']->total_role_share) !!}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div id="qr" style="padding-top:30px; padding-left:60px">
                                                {!! DNS2D::getBarcodeHTML(url('panel/dpn/invoice/invoice-role-share-showing/'.$dataInvoiceRoleShare['invoice']->no_invoice.'/'.$dataInvoiceRoleShare['kta']->id_detail_kta), "QRCODE", 3,3) !!}
                                        </div>
                                        </div>

                                        {{-- <div class="row no-print">
                                            <div class="col-xs-12">
                                                <a href="#" class="btn btn-success pull-right" data-toggle="modal" data-target="#confirmPaymentRoleSharingForm"><i class="fa fa-money"></i> Submit Payment</a>
                                            </div>
                                        </div> --}}
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>



{{-- 
      <!-- Modal -->
<div class="modal fade" id="confirmPaymentRoleSharingForm" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Konfirmasi Pembayaran Role Sharing Ke DPN</h4>
        </div>
        <div class="modal-body">
                <form action="" id="save-roleshare-confirmation" enctype="multipart/form-data" method="POST">
                        No Invoice:
                        <input type="text" id="no_invoice"  name="no_invoice"
                            placeholder="nomor invoice" class="form-control" value="">
                        <lable style="display:block" id="invoice-not-found"></lable>
                       
                        Nominal Role Sharing:
                        <input type="text" id="nominal" class="form-control" name="nominal" placeholder="nominal"
                            value="">
                        <lable style="display:block" id="nominal-error"></lable>
                        Atas Nama:
                        <input type="text" name="atas_nama" class="form-control" placeholder="atas nama" value="">
                        <lable style="display:block" id="atas-nama-error"></lable>
                        Nama Bank Anda:
                        <input type="text" name="nama_bank_anda" class="form-control" placeholder="nama bank anda"
                            value="">
                        Upload Bukti Transfer:
                        <input type="file" name="upload_bukti_trf" class="form-control" placeholder="nama bank anda"
                            value="">
                        <lable style="display:block" id="nama-bank-anda-error"></lable><br>
                      
                        <input type="hidden" name="id_invoice_role_share" value="{!! $dataInvoiceRoleShare['invoice']->id !!}">
                        <input type="submit"  value="Confirm My Payment"> <img id="loader"
                            src='{{ asset('assets/images/ajax-spinner.gif') }}' style="display:none;width: 30px;
                        position: relative;
                        top: 10px;">

                        <ul id="message-error"></ul>
                    </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div> --}}


    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend/build/js/custom.min.js') }}" type="953f9ddfbd71f1ba52dbf194-text/javascript"></script>
    <!-- Jquery Input Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>     
    <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/95c75768/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="953f9ddfbd71f1ba52dbf194-|49" defer=""></script>
        
</body>

</html>


<script>
// Save payment confirmation
$(document).ready(function(){
    $("#save-roleshare-confirmation").submit(function( event ){
            event.preventDefault();
            const csrf_token = $('meta[name="csrf-token"]').attr('content');
            var formData = new FormData($(this)[0]);

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf_token
            }
        });

            $.ajax({
                type: 'POST',
                url: '{!! route('dpp.invoice.roleshare-save') !!}',
                enctype: 'multipart/form-data',
                traditional: true,
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                   
                },
                success: function(response) {
                    //console.log(Object.values(response))
                    Swal.fire({
                        type: 'success',
                        title: 'Berhasil',
                        text: Object.values(response),
                        }).then(function() {
                            window.location = "/panel/dpp/invoice/invoice-role-share";
                        });
                        $('#save-roleshare-confirmation').trigger("reset");
                },

               error: function (jqXhr) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors['errors'], function (index, value) {
                    errorsHtml += "<li><small style='color:red'>" + value + "</small></li>";
                    $('#message-error').html(errorsHtml);
                });
           },

  
                complete:function(data){
                // Hide image container
                $("#loader").hide();
               
            }
            });
        });
    });
</script>

<script>
$(document).ready(function(){
  $('#nominal').mask('000.000.000.000.000', {reverse: true});
});

</script>



