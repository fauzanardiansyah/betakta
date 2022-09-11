<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sertifikat Ikatan Nasional Konsultan Indonesia</title>
    <link rel="stylesheet" href="{{ public_path('assets-kta/styleSertifikat.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="inner-bg">

            <div class="content-1">
                <div class="left">
                    <img src="{{ public_path('assets-kta/images/ribbon.png') }}" alt="" srcset="">
                </div>
                <div class="center">
                    <div class="center-top">
                        <center>
                            <img src="{{ public_path('assets-kta/images/Logo Inkindo.png') }}" alt="" srcset="">
                        </center>
                    </div>
                    <div class="center-bottom">
                        <h4>KARTU TANDA ANGGOTA<br>
                            IKATAN NASIONAL KONSULTAN INDONESIA<br>
                            (NATIONAL ASSOCIATION OF INDONESIAN CONSULTANTS)</h4>
                    </div>
                </div>
                <div class="right">
                   <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($dataKta->npwp_bu, "C128B",1,80,array(1,1,1), "green") . '" alt="barcode"   />'; ?>
                </div>
            </div>


            <div class="content-2">
                <p>Berdasarkan ketentuan Anggaran Dasar Bab VII Pasal 12 dan Anggaran Rumah Tangga Bab III Pasal 9, maka
                    bersama ini
                    Dewan Pengurus Nasional INKINDO menetapkan dan menerangkan perusahaan yang sudah memenuhi
                    persyaratan
                    untuk menjadi anggota dengan keterangan sebagai berikut :</p>
            </div>


            <div class="content-3">
                <table width="100%">
                    <tr>
                        <td><small>Nomor Keanggotaan</small></td>
                        <td>:</td>
                        <td><small>{!! $dataKta->no_kta !!}</small></td>
                        <td rowspan="8">
                            <img src="{{ public_path('storage/legalitas-files/'.$dataKta->file_foto_pjbu) }}"
                                style="width:142px; height:169px">
                        </td>
                    </tr>
                    <tr>
                        <td><small>Dewan Pengurus Provinsi </small></td>
                        <td>:</td>
                        <td><small>{!! strtoupper($dataKta->province_name) !!}</small></td>

                    </tr>
                    <tr>
                        <td><small>Nama Badan Usaha</small></td>
                        <td>:</td>
                        <td><small>{!! str_limit(strtoupper($dataKta->nm_bu), 46, ',') !!}</small></td>

                    </tr>
                    <tr>
                        <td><small>Alamat</small></td>
                        <td>:</td>
                        <td><small>{!! str_limit(ucwords($dataKta->alamat), 50,",") !!} Kecamatan {!! ucwords($dataKta->kecamatan) !!}, Kota {!! ucwords($dataKta->kota) !!}</small></td>

                    </tr>
                    <tr>
                        <td><small>Telepon / Fax </small></td>
                        <td>:</td>
                        <td><small>{!! ($dataKta->no_telp) !!} / {!! $result = (!empty($dataKta->no_fax)) ? $dataKta->no_fax : ''; !!}</small></td>

                    </tr>
                    <tr>
                        <td><small>Email</small></td>
                        <td>:</td>
                        <td><small>{!! ($dataKta->email_bu) !!}</small></td>

                    </tr>
                    <tr>
                        <td><small>Website</small></td>
                        <td>:</td>
                        <td><small>{!! ($dataKta->website) !!}</small></td>

                    </tr>
                    <tr>
                        <td><small>Penanggung Jawab</small></td>
                        <td>:</td>
                        <td><small>{!! ($dataKta->nm_pjbu) !!}</small></td>

                    </tr>
                </table>
            </div>




            <div class="content-4">
                <div class="content-4-top">
                    <h4>ADALAH ANGGOTA IKATAN NASIONAL KONSULTAN INDONESIA DENGAN STATUS KEANGGOTAAN</h4>
                </div>
                <div class="content-4-bottom">
                    <center><strong><a>{{ $result = ($dataKta->status_bu == "pusat") ? "PENUH" : "TERBATAS" }}</a></strong></center><br>
                    <p>Tanda Anggota ini berlaku sampai dengan tanggal <strong>{{ Carbon\Carbon::parse($dataKta->masa_berlaku)->formatLocalized('%d %B %Y')}}</strong></p>
                </div>
            </div>



            <div class="content-5">
                <table width="100%" height="100" border="0" style="margin-left:20px;">
                    <tr>
                        <td colspan="2">
                            <span style="display:block; text-align:center;font-weight:bold">Dewan Pengurus
                                Provinsi</span>
                            <span style="display:block; text-align:center;font-weight:bold">{{ $dataKta->province_name }}</span>
                        </td>
                        <td rowspan="2">
                            <center><?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($dataKta->no_kta, "QRCODE",3,3,array(1,1,1), "green") . '" alt="barcode"   />'; ?></center>
                         
                        </td>
                        <td colspan="2" style="text-align:center">
                            <span style="font-weight:bold">Disahkan dan diregistrasi,<br>
                                Jakarta, {{ Carbon\Carbon::parse($dataKta->tgl_terbit)->formatLocalized('%d %B %Y')}}, Dewan Pengurus Nasional</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center><img src="{{ public_path('storage/signature/'.$dataKta->ttd_ketua_provinsi) }}" style="width:35px"
                                    alt="" srcset=""></center>
                        </td>
                        <td>
                            <center><img src="{{ public_path('storage/signature/'.$dataKta->ttd_sekretaris_provinsi) }}" style="width:35px"
                                    alt="" srcset=""></center>
                        </td>
                        <td>
                            <center><img src="{{ public_path('storage/signature/'.$dpnSignature->ttd_ketum) }}" style="width:35px"
                                    alt="" srcset=""></center>
                        </td>
                        <td>
                            <center><img src="{{ public_path('storage/signature/'.$dpnSignature->ttd_sekjen) }}" style="width:35px"
                                    alt="" srcset=""></center>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <span style="display:block; text-align:center;font-weight:bold">{!! $dataKta->nm_ketua_provinsi  !!}</span>
                            <span style="display:block; text-align:center;">Ketua Provinsi</span>
                        </td>
                        <td>
                            <span style="display:block; text-align:center;font-weight:bold">{!! $dataKta->nm_sekretaris_provinsi  !!}
                                M.M</span>
                            <span style="display:block; text-align:center">Sekretaris Provinsi</span>
                        </td>

                        <td></td>
                        <td>
                            <span style="display:block; text-align:center;font-weight:bold">{!! $dpnSignature->nm_ketum !!}</span>

                            <span style="display:block; text-align:center">Ketua Umum</span>
                        </td>
                        <td>
                            <span style="display:block; text-align:center;font-weight:bold">{!! $dpnSignature->nm_sekjen !!}</span>
                            <span style="display:block; text-align:center">Sekretaris Jenderal</span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
        <img src="{{ public_path('assets-kta/images/Pita.png') }}" id="image-footer" alt="" srcset="">
    </div>




    <div class="container-2">
        <div class="bg-inner-2">
            <div class="header">
                <table width="100%">
                    <tr>
                        <td style="width:90px">
                            <img src="{{ public_path('assets-kta/images/Logo Inkindo.png') }}" id="logo-back" alt=""
                                srcset="">
                        </td>
                        <td>
                            <h3 id="kode-etik">KODE ETIK</h3>
                            <h3>IKATAN NASIONAL KONSULTAN INDONESIA</h3>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="content">
                <p>
                    Dengan menjunjung tinggi Etika Ikatan Nasional Konsultan Indonesia sebagai dasar yang dinamis untuk
                    melayani
                    sesama manusia, maka tiap Anggota Ikatan Nasional Konsultan Indonesia wajib untuk:
                </p>

                <ul>
                    <li><p>1. Menjunjung tinggi kehormatan, kemuliaan, dan nama baik profesi konsultan dalam hubungan kerja
                        dengan
                        pemberi tugas sesama rekan konsultan dan masyarakat.</p></li>
                    <li><p>2. Bertindak jujur, tidak memihak, serta penuh dedikasi melayani pemberi tugas dan masyarakat.</p></li>
                    <li><p>3. Tukar menukar pengetahuan bidang keahlian secara wajar dengan rekan konsultan dan kelompok
                        profesi serta
                        meningkatkan pengetahuan masyarakat terhadap profesi konsultan sehingga dapat lebih menghayati
                        karya
                        konsultan.</p></li>
                    <li><p>4. Menghormati prinsip pemberian imbalan jasa yang layak dan memadai bagi konsultan, sehingga dapat
                        dipertanggungjawabkan secara profesional dan moral yang menjamin dapat dilaksanakannya tugas
                        yang
                        dipercayakan memenuhi semua persyaratan yang terkait dengan keahlian, kompetensi, dan integritas
                        tinggi.</p></li>
                    <li>
                        <p>5. Menghargai dan menghormati reputasi profesional rekan konsultan dan setiap perjanjian kerja yang
                        berhubungan
                        dengan profesinya.</p>
                    </li>
                    <li>
                        <p>6. Mendapatkan tugas terutama berdasarkan standar keahlian profesional tanpa melalui cara-cara
                        persaingan yang
                        tidak sehat.</p>
                    </li>
                    <li>
                        <p>7. Bekerjasama sebagai konsultan hanya dengan rekan konsultan atau tenaga ahli lain yang memiliki
                        integritas tinggi.</p>

                    </li>
                    <li>
                        <p>8. Menjalankan asas pembangunan berkelanjutan dalam semua aspek pelayanan jasa konsultan sebagai
                        bagian
                        integral dari tanggung jawabnya terhadap sesama, lingkungan kehidupan yang luas, dan generasi
                        yang akan datang</p>

                    </li>
                </ul>

            </div>
        </div>
    </div>

</body>

</html>