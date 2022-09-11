<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KTA Online Inkindo</title>
    <meta name="description" content="KTA Online Inkindo">

    <!-- Source CSS We Use -->
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/{{ asset('frontend/rontV2') }}//packages/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/owl-carousel/owl.theme.default.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/select2/select2.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/fancybox/fancybox.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/animate/animate.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/themify-icon/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/css/theme.css">
    <!-- End Source CSS We Use -->

    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('frontend/frontV2') }}/assets/img/favicon/favicon.ico' />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/frontV2') }}/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/frontV2') }}/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href={{ asset('frontend/frontV2') }}/"assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('frontend/frontV2') }}/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('frontend/frontV2') }}/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="http://inkindo.com/index.html">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/css/animate.css">
</head>
<body>
    <header class="header_area">
        <nav class="navbar navbar-expand-lg menu_one menu_four">
            <div class="container">
                <a class="navbar-brand sticky_logo" href="{{ url('/') }}">
                    <img src="{{ asset('frontend/frontV2') }}/assets/img/logo-white.png" srcset="{{ asset('frontend/frontV2') }}/assets/img/logo-white.png 2x" alt="logo">
                    <img src="{{ asset('frontend/frontV2') }}/assets/img/logo.png" srcset="{{ asset('frontend/frontV2') }}/assets/img/logo.png 2x" alt="">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu_toggle">
                        <span class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                        <span class="hamburger-cross">
                            <span></span>
                            <span></span>
                        </span>
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav menu w_menu">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('front.home') }}">
                                Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.alur') }}">
                                Alur
                            </a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.informasi') }}">
                                Informasi Publik
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="blog.html">
                                Berita
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('front.faq') }}">
                                F. A. Q
                            </a>
                        </li>
                        <li class="nav-item dropdown submenu d-block d-lg-none">
                            <a class="nav-link btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Masuk
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="{{ route('auth.user.show-login') }}" class="nav-link">
                                        Masuk Sebagai Anggota
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dpp.auth') }}" class="nav-link">
                                        Masuk Sebagai DPP
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dpn.auth') }}" class="nav-link">
                                        Masuk Sebagai DPN
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="dropdown dropdown-login hidden-sm hidden-xs">
                        @if (Session::has('is_login_agt'))
                        <a class="btn btn_get btn_hover dropdown-toggle" href="{{ route('anggota.dashboard') }}" id="dropdownMenuButton">Dashboard</a>
                        @elseif(Session::has('is_login_dewan'))
                        <a class="btn btn_get btn_hover dropdown-toggle" href="{{ route('dpp.dashboard') }}" id="dropdownMenuButton">Dashboard</a>
                        @elseif(Session::has('is_login_dewan_pusat'))
                        <a class="btn btn_get btn_hover dropdown-toggle" href="{{ route('dpn.dashboard') }}" id="dropdownMenuButton">Dashboard</a>  
                        @else
                        <a class="btn btn_get btn_hover dropdown-toggle" href="" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Masuk</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('auth.user.show-login') }}">Masuk Sebagai Anggota</a>
                            <a class="dropdown-item" href="{{ route('dpp.auth') }}">Masuk Sebagai DPP</a>
                            <a class="dropdown-item" href="{{ route('dpn.auth') }}">Masuk Sebagai DPN</a>
                        </div>
                        @endif
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="banner-area">
            <div class="banner-6">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 align-self-center text-center">
                            <h1 class="title">
                                Alur Mekanisme KTA
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-blog justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Alur</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="process" id="process">
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" href="#registrasi1" role="tab" data-toggle="tab">Registrasi Baru</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#ulang" role="tab" data-toggle="tab">Registrasi Ulang</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#perpanjangan" role="tab" data-toggle="tab">Perpanjangan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#perubahan" role="tab" data-toggle="tab">Perubahan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#pemberhentian" role="tab" data-toggle="tab">Pemberhentian</a>
                  </li>
                </ul>
                
                <style>
                    .fade:not(.show) {
                        opacity: 1 !important;
                    }
                    .flowtitle {
                        margin: 20px 0 40px;
                    }
                    .flowtitle > h1 {
                        font-weight: 700;
                        font-size: 40px;
                        color: #0072BC;
                        text-align: center;
                    }
                    .box {
                        background-color: #e67e22;
                        padding: 15px;
                        color: #ffffff;
                        border-radius: 5px;
                    }
                    .box p {
                        font-size: 28px;
                    }
                </style>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="registrasi1">
                    <!-- tabs1 -->
                        <div class="flowtitle">
                            <h1>Registrasi Baru</h1>
                        </div>
                        <div class="process-list">
                            <img class="dot-img" src="{{ asset('frontend/frontV2') }}/assets/img/dot.svg" alt="">
                            <div class="row item one flex-row-reverse">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/document-1.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/1.png" alt="">
                                        <h3>
                                            PENGISIAN DOKUMEN ADMINISTRASI BADAN USAHA
                                        </h3>
                                        <p>
                                            Anggota di minta untuk mengisi beberapa form mulai dari data Badan usaha sampai legalitas dokumen badan usaha.
                                        </p>
                                        <a href="#process-2" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item two" id="process-2">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInLeft" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-1.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInRight" data-wow-delay="0.7s">
                                        <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/2.png" alt="">
                                        <h3>
                                            SCREENING DOKUMEN OLEH DPP TERKAIT
                                        </h3>
                                        <p>
                                            Jika Badan usaha terkait adalah termasuk jenis badan usaha Pemilik Modal Dalam Negri maka dokumen pengajuanya akan di periksa terlebih dahulu oleh DPP terkait.
                                        </p>
                                        <a href="#process-3" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item three flex-row-reverse" id="process-3">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/payment-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/3.png" alt="">
                                        <h3>
                                            PEMBAYARAN KEANGGOTAAN
                                        </h3>
                                        <p>
                                            Setelah dokumen di nyatakan valid oleh DPP, maka calon anggota akan mendapatkan invoice untuk di lakukan pembayaran ke anggotaan.
                                        </p>
                                        <a href="#process-4" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item four" id="process-4">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInLeft" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInRight" data-wow-delay="0.7s">
                                        <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/4.png" alt="">
                                        <h3>
                                            SCREENING DOKUMEN OLEH DPN
                                        </h3>
                                        <p>
                                            Jika calon anggota merupakan termasuk jenis badan usaha Pemilik Modal Asing, maka dokumen pengajuanya akan di periksa terlebih dahulu oleh DPN.
                                        </p>
                                        <a href="#process-5" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item five flex-row-reverse" id="process-5">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/payment-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/5.png" alt="">
                                        <h3>
                                            PEMBAYARAN KEANGGOTAAN
                                        </h3>
                                        <p>
                                            Setelah dokumen di nyatakan valid oleh DPN, maka calon anggota akan mendapatkan invoice untuk di lakukan pembayaran ke anggotaan.
                                        </p>
                                        <a href="#" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="dot middle">
                                <span class="dot1"></span>
                                <span class="dot2"></span>
                            </div>
                        </div>
                        <!-- end tabs1 -->
                      </div>
                  <div role="tabpanel" class="tab-pane fade" id="ulang">
                      <!-- tabs1 -->
                        <div class="flowtitle">
                            <h1>Registrasi Ulang</h1>
                        </div>
                        <div class="process-list">
                            <img class="dot-img" src="assets/img/dot.svg" alt="">
                            <div class="row item one flex-row-reverse">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/document-1.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">  
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/1.png" alt="">
                                        <h3>
                                            PORTAL KTA ONLINE
                                        </h3>
                                        <p>
                                            Anggota mengakses portal KTA ONLINE INKINDO di https://ktaonline.inkindo.org dan anggota dapat melihat informasi dan akun keanggotaan melalui portal KTA online.
                                        </p>
                                        <a href="#ulang-2" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item two" id="ulang-2">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInLeft" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-1.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInRight" data-wow-delay="0.7s">
                                        <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/2.png" alt="">
                                        <h3>
                                            PENDAFTARAN ULANG
                                        </h3>
                                        <p>
                                            Login menggunakan NPWP / Email badan usaha dan password yang sudah dibuat saat registrasi. Kemudian pilih menu <strong>registrasi</strong> dan  sub menu <strong>daftar ulang</strong>. Kemudia isi semua formulir yang telah disediakan. Selama berlangsung, anggota dapat melakukan tracking data untuk mengetahui proses KTA.
                                        </p>
                                        <a href="#ulang-3" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item three flex-row-reverse" id="ulang-3">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/3.png" alt="">
                                        <h3>
                                            DPP Verifikasi
                                        </h3>
                                        <p>
                                            DPP melakukan screening dan verifikasi terhadap keabsahan data calon anggota. Jika data sudah valid dan sesuai, maka DPP akan meneruskan data tersebut ke DPN.
                                        </p>
                                        <a href="#ulang-4" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item four" id="ulang-4">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInLeft" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInRight" data-wow-delay="0.7s">
                                        <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/4.png" alt="">
                                        <h3>
                                            VALIDASI DPN
                                        </h3>
                                        <p>
                                            DPN melakukan validasi data anggota  yang telah diverifikasi oleh DPP. Apabila data yang diberikan valid, DPN akan mengeluarkan Kartu Tanda Anggota INKINDO untuk dapat dicetak oleh anggota masing-masing.
                                        </p>
                                        <a href="#ulang-5" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item five flex-row-reverse" id="ulang-5">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/document-1.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/5.png" alt="">
                                        <h3>
                                            PENCETAKKAN KTA
                                        </h3>
                                        <p>
                                            Anggota melakukan cetak / print Kartu Tanda Anggota dan ID Card diaplikasi.
                                        </p>
                                        <a href="#" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="dot middle">
                                <span class="dot1"></span>
                                <span class="dot2"></span>
                            </div>
                        </div>
                        <!-- end tabs1 -->
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="perpanjangan">
                      <!-- tabs1 -->
                        <div class="flowtitle">
                            <h1>Perpanjangan</h1>
                        </div>
                        <div class="process-list">
                            <img class="dot-img" src="{{ asset('frontend/frontV2') }}/assets/img/dot.svg" alt="">
                            <div class="row item one flex-row-reverse">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/document-1.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">  
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        
                                        <img class="number" src="{{ asset('frontend/rontV2') }}/assets/img/1.png" alt="">
                                        <h3>
                                            PORTAL KTA ONLINE
                                        </h3>
                                        <p>
                                            Anggota mengakses portal KTA ONLINE INKINDO di https://ktaonline.inkindo.org dan anggota dapat melihat informasi dan akun keanggotaan melalui portal KTA online. Kemudian Calon anggota melakukan login di Portal KTA ONLINE menggunakan email / NPWP badan usaha dan password yang telah didaftarkan pada saat registrasi.
                                        </p>
                                        <a href="#perpanjangan-2" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item two" id="perpanjangan-2">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInLeft" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-1.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInRight" data-wow-delay="0.7s">
                                        <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/2.png" alt="">
                                        <h3>
                                            PERPANJANGAN KEANGGOTAAN 
                                        </h3>
                                        <p>
                                            Pilih menu status keanggotaan pada dashboard. Klik tombol perpanjangan pada kolom action. Pilih perpanjangan dan upload file KTA di tahun sebelumnya. Apabila ada perubahan data pada saat perpanjangan, silakan lakukan perubahan data terlebih dahulu dengan mengisi form yang sudah disediakan oleh sistem.
                                        </p>
                                        <a href="#perpanjangan-3" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item three flex-row-reverse" id="perpanjangan-3">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/3.png" alt="">
                                        <h3>
                                            DPP Verifikasi
                                        </h3>
                                        <p>
                                            DPP melakukan screening & memverifikasi keabsahan data anggota. Apabila data yang diberikan valid dan sesuai, maka DPP akan memberikan invoice pembayaran iuran keanggotaan.
                                        </p>
                                        <a href="#perpanjangan-4" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item four" id="perpanjangan-4">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInLeft" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/payment-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInRight" data-wow-delay="0.7s">
                                        <div class="dot"><span class="dot1"></span><span class="dot2"></span></div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/4.png" alt="">
                                        <h3>
                                            PEMBAYARAN KEANGGOTAAN & VERIFIKASI PEMBAYARAN
                                        </h3>
                                        <p>
                                            Anggota menerima invoice dari DPP terkait. Anggota melakukan pembayaran melalui bank transfer sesuai nomor rekening yang tertera didalam invoice. Kemudian DPP memverifikasi pembayaran dari anggota. DPP meneruskan data anggota ke DPN untuk dapat divalidasi.
                                        </p>
                                        <a href="#perpanjangan-5" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row item five flex-row-reverse" id="perpanjangan-5">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <img class="number" src="{{ asset('frontend/frontV2') }}/assets/img/5.png" alt="">
                                        <h3>
                                            VALIDASI DPN & PENCETAKKAN KTA
                                        </h3>
                                        <p>
                                            DPN melakukan validasi data anggota yang telah diverifikasi oleh DPP. DPP mengeluarkan invoice pembayaran role sharing ke DPP. Kemudian DPN akan memperbaharui masa aktif Kartu Anggota INKINDO apabila DPP sudah membayarkan role sharing ke DPN. Setelah semua itu selesai, maka KTA dapat dicetak oleh masing-masing anggota melalui sistem aplikasi.
                                        </p>
                                        <a href="#" class="icon"><i class="ti-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="dot middle">
                                <span class="dot1"></span>
                                <span class="dot2"></span>
                            </div>
                        </div>
                        <!-- end tabs1 -->
                  </div>

                  <div role="tabpanel" class="tab-pane fade" id="perubahan">
                        <div class="process-list">
                        
                         <div class="flowtitle">
                            <h1>Perubahan Data</h1>
                        </div>

                      	<div class="row item one flex-row-reverse" id="perpanjangan-5">
                                <div class="col-lg-6">
                                    <div class="image text-right wow fadeInRight" data-wow-delay="0.7s">
                                        <img src="{{ asset('frontend/frontV2') }}/assets/img/illustration/screening-2.svg" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="content wow fadeInLeft" data-wow-delay="0.7s">
                                        <div class="dot">
                                            <span class="dot1"></span>
                                            <span class="dot2"></span>
                                        </div>
                                        <!-- <img class="number" src="assets/img/1.png" alt=""> -->
                                        <h3>
                                            Informasi
                                        </h3>
                                        <p>
                                            Bagi seluruh anggota INKINDO yang akan melakukan perubahan data sebelum masa perpanjangan habis, silakan hubungi Customer Service kami melalui live chat yang tersedia pada sistem aplikasi.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>

                   <div role="tabpanel" class="tab-pane fade" id="pemberhentian">
                         <div class="flowtitle">
                            <h1>Pemberhentian Anggota</h1>
                        </div>
                      <div class="box">
                          <p>-</p>
                      </div>
                  </div>
                </div>
                

            </div>
        </section>
    </main>

    <footer>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 px-lg-4">
                        <div class="footer-description">
                            <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo.png" alt="" class="img-fluid">
                            <p>
                                Ikatan Nasional Konsultan Indonesia (INKINDO) merupakan Asosiasi Perusahaan Jasa Konsultan
                                di Indonesia yang didirikan pada tanggal 20 Juni 1979 di Jakarta.
                            </p>
                        </div>
                        <div class="social">
                            <a href="https://www.facebook.com/inkindo.org/" target="_blank" class="facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://www.youtube.com/channel/UCOeB00eIVKrPzw4A5V-9g-A?view_as=subscriber"
                                style="background:red" class="twitter">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="gplus">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="https://www.instagram.com/inkindo_org/?hl=id" target="_blank" class="instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 px-lg-4">
                        <div class="footer-title">
                            <h5>
                                LINKS
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <ul class="link">
                                    <li>
                                        <a href="{{ route('front.home') }}">
                                            Home
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('front.informasi') }}">
                                            Informasi Publik
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('front.faq') }}">
                                            F. A. Q
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <ul class="link">
                                    <li>
                                        <a href="{{ route('auth.user.show-login') }}">
                                            Login Anggota
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dpp.auth') }}">
                                            Login DPP
                                        </a>
                                    </li> 
                                    <li>
                                            <a href="{{ route('dpn.auth') }}">
                                                Login DPN
                                            </a>
                                        </li> 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 px-lg-4">
                        <div class="footer-title">
                            <h5>
                                CONTACT
                            </h5>
                        </div>
                        <div class="footer-contact">
                            <div class="list-contact">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Jl. Bendungan Hilir Raya No. 29 <br><br> Jakarta Pusat 10210</span>
                            </div>
                            <div class="list-contact">
                                <i class="fas fa-phone"></i> <span>(021) 573 8577</span>
                            </div>
                            <div class="list-contact">
                                <i class="fas fa-envelope"></i> <span>inkindo@inkindo.org</span>
                            </div>
    
                            <div class="list-contact">
                                <i class="fas fa-globe-asia"></i> <span>wwwinkindo.org</span>
                            </div>
                            <!-- <div class="list-contact">
                                <i class="fas fa-map-marker-alt"></i> <span>Jl. Jakarta</span>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="footer-bottom">
                            Copyright &copy; Inkindo 2019. All right reserved.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    <div class="back-to-top">
        <a href="javascript:void(0);">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>

    <!-- Source JS We Use -->
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/bootstrap/jquery.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/bootstrap/popper.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/select2/select2.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/fancybox/fancybox.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/js/theme.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/wow/wow.min.js"></script>

    <script>
  		new WOW().init();
  	</script>
    <!-- End Source JS We Use -->
</body>
</html>