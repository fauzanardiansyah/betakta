<!DOCTYPE html>
<html>
<head>
    <title>ID CARD - {!! str_limit(ucwords($dataKta->nm_bu), 50, ".") !!}</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets-kta/ktaV3/') }}/ikindo.css">
</head>
<body>
    <div class="ikindo small-container" id="ikindo">
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle-small.png" class="img-responsive bg-rectagle-top rectagle-small-top">
        <div class="content-wrapper small-wrapper">
            <div class="block-header-small">
                <table style="width:100%;">
                    <tr>
                        <td width="20%" class="text-left"><img class="small-company-logo" src="{{ asset('assets-kta/ktaV3/') }}/assets/logo.png">
                        </td>
                        <td width="70%" class="text-center">
                            <p class="text-semi-bold">KARTU IDENTITAS ANGGOTA</p>
                            <p class="text-semi-bold">IKATAN NASIONAL KONSULTAN INDONESIA</p>
                            <p class="text-semi-bold margin-less">(NATIONAL ASSOCIATION OF INDONESIAN CONSULTANTS)</p>
                        </td>
                        <td width="20%"></td>
                    </tr>
                </table>
            </div>
            <div class="block-kta">
                <table style="width:100%;margin-bottom: 0!important;">
                    <tr>
                        <td width="65%" style="padding:0; vertical-align:top">
                            <table style="width: 100%;" class="table-identity">
                                <tr>
                                    <td width="40%">Nomor Keanggotaan</td>
                                    <td width="5%">:</td>
                                    <td width="20%">{!! $dataKta->no_kta !!}</td>
                                </tr>
                                <tr>
                                    <td width="40%">Kepengurusan</td>
                                    <td width="5%">:</td>
                                    <td width="65%">{!! $dataKta->province_name !!}</td>
                                </tr>
                                <tr>
                                    <td width="40%">Badan Usaha</td>
                                    <td width="5%">:</td>
                                    <td width="65%">{!! str_limit(ucwords($dataKta->nm_bu), 50, ".") !!}</td>
                                </tr>
                                <tr>
                                    <td width="40%">Penanggung Jawab</td>
                                    <td width="5%">:</td>
                                    <td width="65%">{!! $dataKta->nm_pjbu !!}</td>
                                </tr>
                                <tr>
                                    <td width="40%">Alamat</td>
                                    <td width="5%">:</td>
                                    <td width="65%">{!! str_limit(ucwords($dataKta->alamat),25,".") !!}</td>
                                </tr>
                                <tr>
                                    <td width="40%">Masa Berlaku</td>
                                    <td width="5%">:</td>
                                    <td width="65%">{!! App\Helpers\LocalDate::toIndonesia($dataKta->masa_berlaku) !!}</td>
                                </tr>
                            </table>
                        </td>
                        <td width="15%" class="text-right">
                            <img class="" style="width:90px; height:auto" src="{{ asset('storage/legalitas-files/'.$dataKta->file_foto_pjbu) }}">
                        </td>
                    </tr>
                </table>
                <table style="width: 100%;margin-bottom: 0!important;">
                    <tr>
                        <td width="75%">
                            <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($dataKta->no_kta, "QRCODE",2,2,array(1,1,1)) . '" class="qrcode-small" alt="barcode"   />'; ?>
                            <p class="font-8" style="letter-spacing: 1px;">QR CODE</p>
                        </td>
                        <td width="25%">
                            <?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($dataKta->no_kta, "PDF417",40,30,array(1,1,1)) . '" class="barcode-small" alt="barcode" style="float:right"   />'; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle-small.png" class="img-responsive bg-rectagle-bottom rectagle-small-bottom">
    </div>

    <div class="ikindo small-container" id="ikindo">
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle-small.png" class="bg-rectagle-top rectagle-small-top">
        <div class="content-wrapper small-wrapper">
            <div class="block-header-small">
                <img class="small-company-logo margin-auto space-8-bottom" src="{{ asset('assets-kta/ktaV3/') }}/assets/logo.png">
            </div>
            <div class="space-8-bottom">
                <ol list-type="number">
                    <li class="line-height-normal">Penggunaan Kartu Identitas Anggota diatur dalam ketentuan organisasi.</li>
                    <li class="line-height-normal">Kartu Identitas Anggota ini berlaku selama 1 tahun sejak diterbitkan.</li>
                    <li class="line-height-normal">Kartu Identitas Anggota ini tidak boleh dipindah tangankan.</li>
                    <li class="line-height-normal">Apabila Kartu Identitas Anggota Rusak / Hilang / Mutasi, dimohon menghubungi
                        sekretariat Nasional DPN INKINDO.</li>
                    <li class="line-height-normal">Setiap Pemegang Kartu Identitas Anggota Wajib membayar iuran anggota.</li>
                </ol>
            </div>
            <div>
                <p class="text-center">Dewan Pengurus Nasional</p>
                <p class="text-center">Ikatan Nasional Konsultan Indonesia</p>
                <img class="signature-small margin-auto space-16-minus-bottom" style="width:50px; margin-bottom:5px" src="{{ asset('storage/signature/'.$dpnSignature->ttd_ketum) }}">
                <p class="text-semi-bold text-center">Ir.H.Peter Frans</p>
                <p class="text-center">Ketua Umum</p>
            </div>
        </div>
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle-small.png" class="bg-rectagle-bottom rectagle-small-bottom">
    </div>
</body>

</html>
