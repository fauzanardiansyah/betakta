<!DOCTYPE html>
<html>
<head>
<title>Sertifikat-{!! str_limit(strtoupper($dataKta->nm_bu), 46, ',') !!}</title>
  <link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets-kta/ktaV3/') }}/download_kta.css" media="all">
</head>
<style type="text/css">
    #watermark {
    position: fixed;
    margin: 0px auto;
    background-repeat: repeat-x;
    background-image: url('assets-kta/ktaV3/assets/copy.png');
    z-index:  -1000;
      opacity: 0.1;
  }#watermark2 {
    position: fixed;
    display: block;
    height: 660px;
    
    /*background-repeat: repeat-x;*/
    background-image: url('assets-kta/ktaV3/assets/bg.png');
    z-index:  -1;
      opacity: 0.1;
  }
</style>
<body>
    <div class="ikindo big-container" id="ikindo">
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle.png" class="bg-rectagle-top rectagle-big-top">
        

        {{-- <div class="star-wrapper">
            <img src="{{ asset('assets-kta/ktaV3/') }}/assets/star-wrapper.png" class="img-responsive">
            <img src="{{ asset('assets-kta/ktaV3/') }}/assets/star.png" class="star img-responsive">
        </div> --}}
        <div class="content-wrapper-top">
            <div class="block-header">
                <table style="width: 100%;" >
                    <tr>
                        <td width="20%" class="text-left"><img width="100px" height="100px" src="{{ asset('assets-kta/ktaV3/') }}/assets/logo.png"></td>
                        <td width="55%" class="text-center">
                            <p class="text-semi-bold" style="font-size: 12px">KARTU TANDA ANGGOTA</p>
                            <div id="watermark">
                                {{-- <img src="{{ url('assets-kta/ktaV3/assets/copy.png/') }}"> --}}
                            </div>
                            <div id="watermark-1">
                                {{-- <img src="{{ url('assets-kta/ktaV3/assets/copy.png/') }}"> --}}
                            </div>
                            <p class="text-semi-bold" style="font-size: 12px">IKATAN NASIONAL KONSULTAN INDONESIA</p>
                            <p class="text-semi-bold margin-less" style="font-size: 12px">(NATIONAL ASSOCIATION OF INDONESIAN CONSULTANTS)</p>
                        </td>
                        <td width="25%" align="center" style="padding-top: 10px;">
                            <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($dataKta->npwp_bu, "C128B",1,65) . '"  alt="barcode"   />'; ?>
                            <br>
                            <center><span>{{ implode(' ',str_split($dataKta->npwp_bu)) }}</span></center>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="block-identity">
                <p class="text-center space-16-bottom" style="font-size: 12px;padding-bottom: 10px;padding-left: 10px">Berdasarkan ketentuan Anggaran Dasar Bab VII Pasal 12 dan Anggaran Rumah Tangga Bab III Pasal 9, maka bersama ini Dewan
                Pengurus Nasional INKINDO menetapkan dan menerangkan perusahaan yang sudah memenuhi persyaratan untuk menjadi anggota
                dengan keterangan sebagai berikut</p>
                <div id="watermark">
                </div>
                <div id="watermark2">
                </div>
                <table style="width: 100%;">
                    <tr>
                        <td width="75%">
                            <table style="width: 100%;" >
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Nomor Keanggotaan</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! $dataKta->no_kta !!}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Dewan Pengurus</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! strtoupper($dataKta->province_name) !!}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Nama Badan Usaha</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! str_limit(strtoupper($dataKta->nm_bu), 46, ',') !!}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Alamat</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! ucwords($dataKta->alamat) !!} Kecamatan {!! ucwords($dataKta->kecamatan) !!}, {!! ucwords($dataKta->kota) !!}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Telepon / Fax</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! ($dataKta->no_telp) !!} / {!! $result = (!empty($dataKta->no_fax)) ? $dataKta->no_fax : ''; !!}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Email</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! ($dataKta->email_bu) !!}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Website</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! ($dataKta->website) !!}</td>
                                </tr>
                                <tr>
                                    <td width="30%" style="font-size: 12px;padding-left: 10px">Penanggung Jawab</td>
                                    <td width="5%">:</td>
                                    <td width="65%" style="font-size: 12px">{!! ($dataKta->nm_pjbu) !!}</td>
                                </tr>
                            </table>
                        </td>
                        <td width="15%" class="text-right align-top">
                            <img src="{{ asset('storage/legalitas-files/'.$dataKta->file_foto_pjbu) }}"
                            style="width:142px; height:169px">
                        </td>
                    </tr>
                </table>
                <p class="text-center text-semi-bold space-8-bottom" style="letter-spacing: 0.06em;font-size: 11px">ADALAH ANGGOTA IKATAN NASIONAL KONSULTAN INDONESIA DENGAN STATUS KEANGGOTAAN</p>
                <center  style="background-color: #00b9f5;color:#fff;margin: 0 auto;text-align: center;width: 100px;">{{ $result = ($dataKta->status_bu == "pusat" OR $dataKta->status_bu == "Pusat") ? "PENUH" : "TERBATAS" }}</center>
                <p class="text-center" style="font-size: 11px">Berlaku sampai dengan tanggal</p>
                        <p class="text-center text-semi-bold" style="font-size: 11px">{!! App\Helpers\LocalDate::toIndonesia($dataKta->masa_berlaku) !!}</p>
            </div>

            @if($dataKta->jenis_bu == 'pmdn')
            <table style="width: 100%;" >
                <tr>
                    <td width="35%" colspan="2">
                        <p class="text-semi-bold text-center" style="font-size: 11px">Dewan Pengurus
                            Provinsi {{ $dataKta->province_name }}</p>
                    </td>
                    <td width="30%"></td>
                    <td width="35%" colspan="2">
                        <p class="text-semi-bold text-center" style="font-size: 11px">Disahkan dan diregistrasi</p>
                        <p class="text-semi-bold text-center" style="font-size: 11px">Jakarta, {!! App\Helpers\LocalDate::toIndonesia($dataKta->tgl_terbit) !!}</p>
                        <p class="text-semi-bold text-center" style="font-size: 11px">Dewan Pengurus Nasional</p>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <center><img class="" style="width: 60px;" src="{{ asset('storage/signature/'.$dataKta->ttd_ketua_provinsi) }}"></center>
                        <br>
                        {!! $dataKta->nm_ketua_provinsi  !!}
                        <br>
                        Ketua
                    </td>
                    <td  align="center">
                        <center><img class="" style="width: 60px; margin-top:0px" src="{{ asset('storage/signature/'.$dataKta->ttd_sekretaris_provinsi) }}"></center>
                       {!! $dataKta->nm_sekretaris_provinsi  !!}
                       <br>
                        Sekretaris

                    </td>
                    <td align="center">
                        <center><?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($dataKta->no_kta, "QRCODE",3,3,array(1,1,1), "green") . '" style="margin-top:0px"  alt="barcode"   />'; ?></center>
                        <br>
                        QR CODE
                    </td>
                    <td  align="center">
                        <center><img class="" style="width: 60px; margin-top:0px" src="{{ asset('storage/signature/'.$dpnSignature->ttd_ketum) }}"></center>
                        {!! $dpnSignature->nm_ketum !!}
                        <br>
                        Ketua Umum
                    </td>
                    <td  align="center">
                        <center><img class="" style="width: 60px; margin-top:0px" src="{{ asset('storage/signature/'.$dpnSignature->ttd_sekjen) }}"></center>
                        {!! $dpnSignature->nm_sekjen !!}
                        <br>
                        Sekretaris Jenderal
                    </td>
                </tr>
            </table>
            @else
                 <table style="width: 100%;" >
                <tr>
                    <td width="35%" colspan="2">
                        <p class="text-semi-bold text-center">Badan Koordinasi Keanggotaan Afiliasi</p>

                    </td>
                    <td width="30%"></td>
                    <td width="35%" colspan="2">
                        <p class="text-semi-bold text-center" style="font-size: 11px">Disahkan dan diregistrasi</p>
                        <p class="text-semi-bold text-center" style="font-size: 11px">Jakarta, {!! App\Helpers\LocalDate::toIndonesia($dataKta->tgl_terbit) !!}</p>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <center><img class="" style="width: 60px;" src="{{ asset('storage/signature/'.$dataKta->ttd_ketua_bkka) }}"></center>
                        <p class="text-semi-bold text-center" style="font-size: 12px">{!! $dataKta->ketua_bkka !!}</p>
                        <p>Ketua BKKA</p>
                        
                    </td>
                    <td  align="center">
                        <center><img class="" style="width: 60px; margin-top:0px" src="{{ asset('storage/signature/'.$dataKta->ttd_sekretaris_bkka) }}"></center>
                        <p class="text-semi-bold text-center" style="font-size: 12px"> {!! $dataKta->sekretaris_bkka !!}</p>
                        <p class="text-center">Sekretaris BKKA</p>

                    </td>
                    <td align="center">
                        <center><?php echo '<img src="data:image/png;base64,' . DNS2D::getBarcodePNG($dataKta->no_kta, "QRCODE",3,3,array(1,1,1), "green") . '" style="margin-top:0px"  alt="barcode"   />'; ?></center>
                        <br>
                        QR CODE
                    </td>
                    <td  align="center">
                        <center><img class="" style="width: 60px; margin-top:0px" src="{{ asset('storage/signature/'.$dpnSignature->ttd_ketum) }}"></center>
                        {!! $dpnSignature->nm_ketum !!}
                        <br>
                        Ketua Umum
                    </td>
                    <td  align="center">
                        <center><img class="" style="width: 60px; margin-top:0px" src="{{ asset('storage/signature/'.$dpnSignature->ttd_sekjen) }}"></center>
                        {!! $dpnSignature->nm_sekjen !!}
                        <br>
                        Sekretaris Jenderal
                    </td>
                </tr>
            </table>

            @endif

        </div>
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle.png" class="bg-rectagle-bottom rectagle-big-bottom">
    </div>
    <p style="page-break-before: always">

    <div  id="ikindo">
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle.png" class="bg-rectagle-top rectagle-big-top">
        <div class="content-wrapper-down">
            <div class="block-header">
                <table style="width: 100%;">
                    <tr>
                        <td width="10%" class="text-left"><img class="company-logo" src="{{ asset('assets-kta/ktaV3/') }}/assets/logo.png">
                        </td>
                        <td width="90%">
                            <h1 class="text-semi-bold margin-less padding-less text-blue">KODE ETIK</h1>
                            <p class="text-semi-bold">IKATAN NASIONAL KONSULTAN INDONESIA</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="watermark">
            </div>
            <div id="watermark2">
            </div>
            <div class="block-identity">
                <p class="line-height-normal">Dengan menjunjung tinggi Etika Ikatan Nasional Konsultan Indonesia sebagai dasar yang dinamis untuk melayani sesama
                manusia, maka tiap Anggota Ikatan Nasional Konsultan Indonesia wajib untuk:</p>
                <ol list-type="number">
                    <li class="line-height-normal">Menjunjung tinggi kehormatan, kemuliaan, dan nama baik profesi konsultan dalam hubungan kerja dengan pemberi tugas
                    sesama rekan konsultan dan masyarakat.</li>
                    <li class="line-height-normal">Bertindak jujur, tidak memihak, serta penuh dedikasi melayani pemberi tugas dan masyarakat.</li>
                    <li class="line-height-normal">Tukar menukar pengetahuan bidang keahlian secara wajar dengan rekan konsultan dan kelompok profesi serta meningkatkan
                    pengetahuan masyarakat terhadap profesi konsultan sehingga dapat lebih menghayati karya konsultan.</li>
                    <li class="line-height-normal">Menghormati prinsip pemberian imbalan jasa yang layak dan memadai bagi konsultan, sehingga dapat dipertanggungjawabkan
                    secara profesional dan moral yang menjamin dapat dilaksanakannya tugas yang dipercayakan memenuhi semua persyaratan yang
                    terkait dengan keahlian, kompetensi, dan integritas tinggi.</li>
                    <li class="line-height-normal">Menghargai dan menghormati reputasi profesional rekan konsultan dan setiap perjanjian kerja yang berhubungan dengan
                    profesinya.</li>
                    <li class="line-height-normal">Mendapatkan tugas terutama berdasarkan standar keahlian profesional tanpa melalui cara-cara persaingan yang tidak sehat.</li>
                    <li class="line-height-normal">Bekerjasama sebagai konsultan hanya dengan rekan konsultan atau tenaga ahli lain yang memiliki integritas tinggi.</li>
                    <li class="line-height-normal">Menjalankan asas pembangunan berkelanjutan dalam semua aspek pelayanan jasa konsultan sebagai bagian integral dari
                    tanggung jawabnya terhadap sesama, lingkungan kehidupan yang luas, dan generasi yang akan datang.</li>
                </ol>
            </div>
        </div>
        <img src="{{ asset('assets-kta/ktaV3/') }}/assets/rectangle.png" class="bg-rectagle-bottom rectagle-big-bottom">
    </div>
</body>
</html>

