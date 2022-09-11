<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kartu Identitas Ikatan Nasional Konsultan Indonesia</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0%;
            padding: 0%
        }

        body {
            background: #fff;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            width: 700px;
            margin: auto;


        }

        .front,
        .back {
            width: 9.2cm;
            height: 6.1cm;
            margin: 100px auto;
            background: #ffff;
            padding: 15px;
            border: 1px dotted dimgray
        }

        .inner-bg {
            position: relative;
            z-index: 999;
            padding: 10px;
            background-position: center;
            background: #ecf0f1;
            
           
            
        }

        .content-1 .left {
            width: 5px;
            float: left;
        }


        .content-1 .center {
            width: 310px;
            float: left;

        }


        .content-1 .right {
            width: 20px;
            float: right;
        }

        .content-1 .left img {
            width: 25px;
            margin-top: -25px;
        }

        .content-1 .right img {
            width: 40px;
            margin-top: -5px;
            margin-right: 5px
        }

        .content-1 .center h5 {
            font-size: 9px;
            text-align: center;
            line-height: 10px;
        }


        .content-2 {
            clear: both;
        }

        .content-2 label {
            font-size: 9px;
            font-weight: bold
        }

        .content-2 td {
            padding: -3px
        }


        #image-footer {
            width: 200px;
            margin-left: 163px;
            margin-top: -134px;
        }


        .inner-bg-back {
            position: relative;
            z-index: 999;
            padding: 10px 15px;
            background: #ecf0f1;
            background-position: center;
        }

        .inner-bg-back .header img {
            width: 30px;
        }

        .inner-bg-back .article small {
            font-size: 9px;
        }

        .inner-bg-back .article li {
            font-size: 9px;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="front">
            <div class="inner-bg">
                <div class="content-1">
                    <div class="left">
                        <img src="{{ public_path('assets-kta/images/ribbon.png') }}" alt="" srcset="">
                    </div>
                    <div class="center">
                        <h5>KARTU IDENTITAS ANGGOTA<br>
                            IKATAN NASIONAL KONSULTAN INDONESIA<br>
                            (NATIONAL ASSOCIATION OF INDONESIAN CONSULTANTS)</h5>
                    </div>
                    <div class="right">
                        <center>
                            <img src="{{ public_path('assets-kta/images/Logo Inkindo.png') }}" alt="" srcset="">
                        </center>
                    </div>
                </div>


                <div class="content-2">
                    <table width="100%" border="0">
                        <tr>
                            <td><label>Nomor Keanggotaan</label></td>
                            <td>:</td>
                            <td><label>&nbsp; 7210/P/0082/DKI.JAYA</label></td>
                            <td rowspan="6">
                                <img src="{{ public_path('storage/legalitas-files/'.$dataKta->file_foto_pjbu) }}"
                                    style="width:50px; margin-left: 15px; margin-top:-24px; border:1px solid #000"
                                    alt="">
                            </td>
                        </tr>

                        <tr>
                            <td><label>Kepengurusan</label></td>
                            <td>:</td>
                            <td><label>&nbsp; {!! $dataKta->province_name !!}</label></td>

                        </tr>

                        <tr>
                            <td><label>Badan Usaha</label></td>
                            <td>:</td>
                            <td><label>&nbsp; {!! str_limit(ucwords($dataKta->nm_bu), 50, ".") !!}</label></td>

                        </tr>

                        <tr>
                            <td><label>Penanggung Jawab</label></td>
                            <td>:</td>
                            <td><label>&nbsp; {!! $dataKta->nm_pjbu !!}</label></td>

                        </tr>

                        <tr>
                            <td><label>Alamat</label></td>
                            <td>:</td>
                            <td><label>&nbsp; {!! str_limit(ucwords($dataKta->alamat),25,".") !!}</label></td>

                        </tr>

                        <tr>
                            <td><label>Masa Berlaku </label></td>
                            <td>:</td>
                            <td><label>&nbsp;
                                    {{ Carbon\Carbon::parse($dataKta->masa_berlaku)->formatLocalized('%d %B %Y')}}</label>
                            </td>

                        </tr>



                    </table>
                </div>

                <div class="content-3">
                    <table width="100%" border="0">
                        <tr>
                            <td><?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($dataKta->npwp_bu, "QRCODE",2,2,array(1,1,1)) . '" alt="barcode"   />'; ?>
                            </td>
                            <td> <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($dataKta->npwp_bu, "C128B",1,30,array(1,1,1)) . '" alt="barcode" style="float:right"   />'; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <img src="{{ public_path('assets-kta/images/Pita.png') }}" id="image-footer" alt="" srcset="">
        </div>
        <div class="back">
            <div class="inner-bg-back">
                <div class="header">
                    <center>
                        <img src="{{ public_path('assets-kta/images/Logo Inkindo.png') }}" alt="" srcset="">
                    </center>
                </div>
                <div class="article">
                    <ol style="margin-bottom:5px">
                        <li><small>Penggunaan KTA diatur dalam ketentuan organisasi.</small></li>
                        <li><small>Kartu Anggota ini berlaku selama 1 tahun sejak diterbitkan.</small></li>
                        <li><small>Kartu Anggota ini tidak boleh dipindah tangankan.</small></li>
                        <li><small>Apabila Kartu Anggota Rusak / Hilang / Mutasi, dimohon
                                menghubungi sekretariat Nasional DPN INKINDO.</small></li>
                        <li><small>Setiap Pemegang Kartu Anggota Wajib membayar iuran anggota.</small></li>
                    </ol>
                    <center><small>Dewan Pengurus Nasional<br>
                            Ikatan Nasional Konsultan Indonesia</small></center>

                    <center><img src="{{ public_path('storage/signature/'.$dpnSignature->ttd_ketum) }}"
                            style="width:60px; margin-top:-8px; height:50px"></center>
                    <center><small><b>{{ $dpnSignature->nm_ketum }}</b><br>Ketua Umum</small></center>
                </div>
            </div>
        </div>
    </div>
</body>

</html>