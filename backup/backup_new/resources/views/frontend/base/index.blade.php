<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KTA Online Inkindo</title>
    <meta name="description" content="KTA Online Inkindo">
    <!-- Source CSS We Use -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/owl-carousel/owl.theme.default.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/select2/select2.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/fancybox/fancybox.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/animate/animate.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/themify-icon/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/css/theme.css">
    <!-- End Source CSS We Use -->
    <link rel='shortcut icon' type='image/x-icon'href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="#">
    <style>
        @media only screen and (max-width: 767px) {
            .banner-area .banner-4 .content {
                margin-top: -50px !important;
            }

            .banner-area .banner-4 .img {
                display: none;
            }
        }

        @media only screen and (max-width: 400px) {
            .banner-area .banner-4 .content {
                margin-top: -240px !important;
            }

            .banner-area .banner-4 .img {
                display: none;
            }
        }

        .back-to-top {
            left: -10rem !important;
        }

        .back-to-top.in {
            transform: translateX(210px) !important;
        }
    </style>

    <!-- Sweet Alert 2  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.12.1/dist/sweetalert2.all.min.js"></script>

</head>

<body>
    @include('frontend/includes.alert')

    <header class="header_area">
        {{-- <div class="container">
            <div class="row">
                <div class="alert alert-warning alert-dismissible" role="alert">
                         <marquee><p style="font-family: Impact; font-size: 10pt">Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor</marquee>
                </div>
            </div>
        </div> --}}
        <nav class="navbar navbar-expand-lg menu_one menu_four">
            <div class="container">
                <a class="navbar-brand sticky_logo" href="{{ url('/') }}">
                    <img src="https://res.cloudinary.com/dbbjuoizs/image/upload/c_scale,w_200/v1580033789/ktaonline/logo-white_dwpskf.png"
                        srcset="https://res.cloudinary.com/dbbjuoizs/image/upload/c_scale,w_200/v1580033789/ktaonline/logo-white_dwpskf.png" alt="logo">
                    <img src="https://res.cloudinary.com/dbbjuoizs/image/upload/c_scale,w_200/v1580033932/ktaonline/logo_zbocie.png"
                        srcset="https://res.cloudinary.com/dbbjuoizs/image/upload/c_scale,w_200/v1580033932/ktaonline/logo_zbocie.png 2x" alt="">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
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
                            <a class="nav-link btn btn-primary dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <div class="banner-4 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="container px-lg-0">
                                <div class="row justify-content-lg-between">
                                    <div class="col-lg-7 d-flex align-items-center">
                                        <div class="content">
                                            <h2 class="wow fadeInLeft" data-wow-delay="0.2s">
                                                KTA ONLINE INKINDO
                                            </h2>
                                            <p class="wow fadeInLeft" data-wow-delay="0.4s">
                                                Sistem Layanan Keanggotaaan INKINDO Berbasis Online
                                            </p>
                                            <div class="btn-group wow fadeInLeft" data-wow-delay="0.6s">
                                                <a href="https://play.google.com/store/apps/details?id=com.project.ktaonline" target="_blank" class="btn one wow fadeInLeft" data-wow-delay="0.5s"><img
                                                        src="{{ asset('frontend/frontV2/') }}/assets/img/google_icon.png"
                                                        alt="">Google Play</a>
                                                <a href="#" class="btn two wow fadeInLeft" data-wow-delay="0.6s"><i
                                                        class="fab fa-apple"></i>App Store</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 wow fadeInDown">
                                        <div class="img">
                                            <img class="banner-img one wow fadeInUp"
                                                src="{{ asset('frontend/frontV2/') }}/assets/img/banner/banner-image-1.svg"
                                                alt="">
                                            <img class="banner-img two float-animation wow fadeInDown"
                                                src="{{ asset('frontend/frontV2/') }}/assets/img/banner/banner-image-2.svg"
                                                alt="">
                                            <img class="banner-img three float-animation wow fadeInDown"
                                                src="{{ asset('frontend/frontV2/') }}/assets/img/banner/banner-image-3.png"
                                                alt="">
                                            <img class="banner-img four float-animation wow fadeInDown"
                                                src="{{ asset('frontend/frontV2/') }}/assets/img/banner/banner-image-4.svg"
                                                alt="">
                                            <img class="banner-img five float-animation"
                                                src="{{ asset('frontend/frontV2/') }}/assets/img/banner/banner-image-5.svg"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="search" style="z-index: 999">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-end">
                    <div class="col-12 col-lg-7">
                        <form action="{{ route('frontend.member.validity') }}" method="POST">
                            @csrf
                            <div class="search-area">
                                <input type="text" name="npwp_email_bu" id="" class="form-control"
                                    placeholder="Masukkan NPWP atau Email Badan Usaha">
                                <div class="cta">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> 
                                        Cek Keabsahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-sm-6">
                        <div class="features-1 text-center wow fadeInUp" data-wow-delay="0.3s">
                            <div class="img">
                                <img src="{{ asset('frontend/frontV2/') }}/assets/img/alur.svg" alt="">
                            </div>
                            <div class="caption">
                                <h4>
                                    Alur Sistem Layanan
                                </h4>
                                <p>
                                    Pahami tatacara <a href="{{ route('front.alur') }}">alur sistem</a> layanan sebelum
                                    melakukan registrasi
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="features-1 text-center wow fadeInUp" data-wow-delay="0.5s">
                            <div class="img">
                                <img src="{{ asset('frontend/frontV2/') }}/assets/img/pedoman.svg" alt="">
                            </div>
                            <div class="caption">
                                <h4>
                                    Syarat & Ketentuan
                                </h4>
                                <p>
                                    Seluruh anggota inkindo wajib mematuhi syarat dan ketentuan yang di atur oleh
                                    inkindo
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="features-1 text-center wow fadeInUp" data-wow-delay="0.7s">
                            <div class="img">
                                <img src="{{ asset('frontend/frontV2/') }}/assets/img/seminar.svg" alt="">
                            </div>
                            <div class="caption">
                                <h4>
                                    Seminar/Workshop
                                </h4>
                                <p>
                                    Info seminar dan workshop yang di adakan oleh inkindo
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

     
        <section class="call-to-action get-started">
            <div class="shape one"></div>
            <div class="shape two"></div>
            <div class="shape three"></div>
            <div class="shape four"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-5 d-flex align-items-center">
                        <div class="content">
                            <h3 class="wow fadeInLeft" data-wow-delay="0.2s">KTA ONLINE INKINDO</h3>
                            <h2 class="wow fadeInLeft" data-wow-delay="0.3s">Download Aplikasinya Sekarang</h2>
                            <p class="wow fadeInLeft" data-wow-delay="0.4s">
                                Sistem Keanggotaan Inkindo juga hadir dalam platform mobile application, yang dapat di download pada Google Play dan App Store
                            </p>
                            <div class="btn-group">
                                <a href="#" class="btn one wow fadeInLeft" data-wow-delay="0.5s"><img
                                        src="{{ asset('frontend/frontV2/') }}/assets/img/google_icon.png" alt="">Google
                                    Play</a>
                                <a href="#" class="btn two wow fadeInLeft" data-wow-delay="0.6s"><i
                                        class="fab fa-apple"></i>App
                                    Store</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-7 text-right wow fadeInRight" data-wow-delay="0.7s">
                        <img src="https://res.cloudinary.com/dbbjuoizs/image/upload/c_scale,w_445/v1580033790/ktaonline/mobile-cta_mqxafh.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-5 d-lg-flex align-items-lg-center">
                        <div class="testimonials-images wow fadeInLeft" data-wow-delay="0.5s">
                            <img src="{{ asset('frontend/frontV2/') }}/assets/img/testimonial.svg" alt="">
                            <img src="{{ asset('storage/foto-testimonial/'.$testimonials->profile_picture) }}"
                                class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 d-lg-flex align-items-lg-center">
                        <div class="testimonials-content">
                            <div class="title small text-left wow fadeInLeft" data-wow-delay="0.8s">
                                <p>
                                    TESTIMONIAL
                                </p>
                                <h2>
                                    {{ strtoupper($testimonials->position) }}
                                </h2>
                            </div>
                            <h5 class="wow fadeInLeft text-justify" data-wow-delay="1.1s">
                                {{ $testimonials->message }}
                            </h5>
                            <h4 class="wow fadeInLeft" data-wow-delay="1.4s">
                                {{ $testimonials->name }}
                            </h4>
                            <h6 class="wow fadeInLeft" data-wow-delay="1.7s">
                                {{ ucwords($testimonials->position) }}
                            </h6>
                            <!-- <a href="#" class="btn btn-primary">
                                Download CV
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <section class="map">
            <div class="container">
                <div class="row flex-lg-row-reverse">
                    <div class="col-12 col-lg-6 d-lg-flex align-items-lg-center">
                        <div class="testimonials-images wow fadeInLeft" data-wow-delay="0.5s">
                            <!-- <img src="assets/img/shape-bg.png" class="img-fluid" alt=""> -->
                            <!-- <img src="assets/img/img-1-right.svg" alt=""> -->

                            <!-- GOOGLE MAP -->
                            <script type="text/javascript"
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSDlMWErr_gwT5d5wze8oK9muKPuHLtKQ">
                            </script>

                            <div id="map-canvas"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="0" height="0" id="daSVG">
                                <clipPath id="chopChop">
                                    <path id="svgPath" class="st2" d="M133.9,98.2l187.2-57.2c73.9-22.6,152.2,19,174.8,93l57.2,187.2c22.6,73.9-19,152.2-93,174.8L273,553.1
	c-73.9,22.6-152.2-19-174.8-93L40.9,273C18.3,199,59.9,120.8,133.9,98.2z" />
                                </clipPath>
                                <path class="svgMask" class="st2" d="M133.9,98.2l187.2-57.2c73.9-22.6,152.2,19,174.8,93l57.2,187.2c22.6,73.9-19,152.2-93,174.8L273,553.1
	c-73.9,22.6-152.2-19-174.8-93L40.9,273C18.3,199,59.9,120.8,133.9,98.2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 d-lg-flex align-items-lg-center">
                        <div class="testimonials-content text-center text-lg-right">
                            <div class="title small text-right wow fadeInLeft" data-wow-delay="0.8s">
                                <p>
                                    GOOGLE MAPS
                                </p>
                                <h2>
                                    Lokasi Kantor Pusat Inkindo
                                </h2>
                            </div>
                            <h5 class="wow fadeInLeft" data-wow-delay="1.1s">
                                Jl. Bendungan Hilir Raya No. 29 Jakarta 10210
                            </h5>
                            <a href="https://goo.gl/maps/UvovGPBjMRydGVve9" target="_blank"
                                class="btn btn-primary wow fadeInLeft" data-wow-delay="1.4s">
                                Open In Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="subscribe-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-5 d-lg-flex align-items-lg-center">
                        <div class="testimonials-images wow fadeInLeft" data-wow-delay="0.8s">
                            <img src="{{ asset('frontend/frontV2/') }}/assets/img/testimonial.svg" alt="">
                            <img src="https://res.cloudinary.com/dbbjuoizs/image/upload/c_scale,w_445/v1580033730/ktaonline/subscribe_ho54vz.png" class="img-fluid"
                                alt="">
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 d-lg-flex align-items-lg-center">
                        <div class="testimonials-content">
                            <div class="title small text-left wow fadeInLeft" data-wow-delay="1.1s">
                                <p>
                                    TENTANG INKINDO
                                </p>
                                <h2>
                                    Ikuti Berita Terbaru Kami
                                </h2>
                            </div>
                            <h5 class="wow fadeInLeft" data-wow-delay="1.4s">
                                Dapatkan info update berita terbaru kami dengan cara subscribe melalui alamat email
                                Anda.
                            </h5>
                            <form class="subscribe-form wow fadeInLeft" data-wow-delay="1.7s">
                                <div class="input-group subcribes">
                                    <input type="email" name="email" class="form-control memail"
                                        placeholder="Masukkan Email">
                                    <button class="btn btn-primary">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="blogs">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="blogs-content">
                            <div class="title center wow fadeInLeft" data-wow-delay="0.2s">
                                <div class="title-small">
                                    <p>
                                        Berita & Blog
                                    </p>
                                    <span></span>
                                </div>
                                <div class="title-big">
                                    <h2>
                                        Berita & Blog <br>
                                        Terbaru INKINDO
                                    </h2>
                                </div>
                            </div>
                            <div class="container wow fadeInLeft" data-wow-delay="0.5s">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="owl-carousel owl-theme" id="blogs">
                                            @if (empty($news))
                                                <h4 class="text-center">Berita Tidak Di Temukan</h4>
                                            @else
                                            @foreach ($news as $news_item)
                                            <div class="item">
                                                    <div class="blog-item">
                                                        <div class="image">
                                                            <img src="{{ asset('storage/news-cover/'.$news_item->cover) }}"
                                                                class="img-fluid" alt="">
                                                        </div>
                                                        <div class="content">
                                                            <div class="meta">
                                                                <a href="#">
                                                                    <i class="ti-user"></i> Admin Post
                                                                </a>
                                                                <a href="#">
                                                                    <i class="ti-calendar"></i> {{ \Carbon\Carbon::parse($news_item->date)->format('d/m/Y')}}
                                                                </a>
                                                            </div>
                                                            <a href="{{ route('frontend.blog.detail-blog', ['slug' => str_slug($news_item->title)]) }}" class="d-block">
                                                                <h4>
                                                                    {{ $news_item->title }}
                                                                </h4>
                                                            </a>
                                                            <div class="text-wrap">
                                                                <p>
                                                                        {!! str_limit($news_item->news, 150) !!}
                                                                </p>
                                                            </div>
                                                            <a href="{{ route('frontend.blog.detail-blog', ['slug' => str_slug($news_item->title)]) }}" class="readmore">
                                                                Baca Selengkapnya <i class="fas fa-chevron-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="clients">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="clients-content">
                            <div class="title center wow fadeInDown" data-wow-delay="0.2s">
                                <div class="title-small">
                                    <p>
                                        Partner Kami
                                    </p>
                                    <span></span>
                                </div>
                                <div class="title-big">
                                    <h2>
                                        DIDUKUNG OLEH
                                    </h2>
                                </div>
                            </div>
                            <div class="container wow fadeInLeft" data-wow-delay="0.5s">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="owl-carousel owl-theme" id="partner">
                                          @if (empty($sponsorship))
                                              <h4>Data Sponsorship Tidak Di Temukan</h4>
                                          @else
                                             @foreach ($sponsorship as $sponsorship_item)
                                             <div class="item">
                                                    <div class="logo-item">
                                                        <a href="#">
                                                            <img src="{{ asset('storage/sponsorship/'.$sponsorship_item->logo_bu) }}"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                             @endforeach 
                                          @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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


    {{-- Modal popup --}}
    <div class="modal fade" id="popupFront" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Info Anggota</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
                @if(empty($warning))
                    <img src="{{ asset('frontend/frontV2/assets/img/popups/FlyerKTAOnline-v.2.png') }}" class="img-fluid" alt="" srcset="">
                @else
                    <img src="{{ asset('storage/warning/'.$warning->image) }}" class="img-fluid" alt="" srcset="">
                @endif
                {{-- <img src="{{ asset('frontend/frontV2/assets/img/popups/FlyerKTAOnline-v.2.png') }}" class="img-fluid" alt="" srcset=""> --}}
            </div>
          </div>
        </div>
      </div>
 

    <div class="back-to-top">
        <a href="javascript:void(0);">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>

    <!-- Source JS We Use -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.1/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/js/theme.js"></script>
    <!-- End Source JS We Use -->

    <!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5d2f255ebfcb827ab0cc467d/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->


    <script type="text/javascript">
        $(window).on('load',function(){
            $('#popupFront').modal('show');
        });
    </script>
</body>

</html>