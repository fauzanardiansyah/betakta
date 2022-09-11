<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BUKTI REGISTRASI
            SISTEM KARTU TANDA ANGGOTA ONLINE INKINDO</title>
</head>

<body>
    <header style="border-bottom:5px solid #000;">
        <center>
            <img src="{{ public_path('backend/kta-assets/logo-kta-inkindo.png') }}" alt="" srcset="">
            <br>
            <span style="color:#204395">INKINDO</span>
            <h3 style="text-align:center">
                BUKTI REGISTRASI <br>
                SISTEM KARTU TANDA ANGGOTA ONLINE INKINDO
            </h3>
        </center>
    </header>
    <article>
        <div class="body-top">
            <table style="margin-top:20px;" width="100%">
                <tr>
                    <th>No. Keanggotaan </th>
                    <td>:</td>
                    <td>{!! $dataKta->no_kta !!}</td>
                    <td rowspan="5">
                            <img src="{{ public_path('storage/legalitas-files/'.$dataKta->file_foto_pjbu) }}" style="width:150px;" alt="">
                    </td>
                </tr>
                <tr>
                    <th>Nama Badan Usaha</th>
                    <td>:</td>
                    <td>{!! $dataKta->nm_bu !!}</td>

                </tr>
                <tr>
                    <th>Nama Penanggung Jawab</th>
                    <td>:</td>
                    <td>{!! $dataKta->nm_pjbu !!}</td>

                </tr>
                <tr>
                    <th>Alamat Badan Usaha</th>
                    <td>:</td>
                    <td>{!! $dataKta->alamat !!}</td>

                </tr>
                <tr>
                    <th>Tanggal Registrasi Pendaftaran </th>
                    <td>:</td>
                    <td>{!! \Carbon\Carbon::parse(substr($dataKta->waktu_pengajuan, 0, 10))->format('d/m/Y') !!}</td>

                </tr>
            </table>
        </div>
        <div class="body-bottom">
            <ol>
                <li>Selamat, Anda telah berhasil terdaftar di sistem Kartu Tanda Anggota (KTA) Online INKINDO</li>
                <li>Kartu ini digunakan untuk mengikuti proses penataran kode etik di masing – masing DPP</li>
                <li>Kartu ini digunakan untuk mendapatkan akses cetak Kartu Tanda Anggota (KTA) INKINDO di Masing
                    masing DPP
                </li>
            </ol>
        </div>
        <div class="qr-code">
               <table width="100%">
                   <tr>
                       <td></td>
                       <td> <center><img src="data:image/png;base64,{{DNS2D::getBarcodePNG(url('cek-keabsahan?qrcode='.$dataKta->npwp_bu), 'QRCODE', 4, 4)}}" alt="barcode" /></center></td>
                       <td></td>
                   </tr>
               </table>
        </div>
    </article>
    <footer>
        <p style="text-align:center">
                Demikian data badan usaha ini saya buat dengan sebenarnya dan bila ternyata isian yang dibuat tidak benar saya bersedia
                menanggung akibat hukum yang ditimbulkannya
        </p>
    </footer>
</body>

</html>