<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KTA Online Inkindo</title>
    <meta name="description" content="KTA Online Inkindo">

    <!-- Source CSS We Use -->
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/owl-carousel/owl.theme.default.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/select2/select2.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/fancybox/fancybox.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/animate/animate.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/themify-icon/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/packages/fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/assets/css/theme.css">
    <!-- End Source CSS We Use -->

    <link rel='shortcut icon' type='image/x-icon'
        href='{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon.ico' />
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/safari-pinned-tab.svg"
        color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="http://inkindo.com/index.html">
</head>

<body>
    <header class="header_area">
        <nav class="navbar navbar-expand-lg menu_one menu_four">
            <div class="container">
                <a class="navbar-brand sticky_logo" href="{{ url('/') }}">
                    <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo-white.png"
                        srcset="{{ asset('frontend/frontV2/') }}/assets/img/logo-white.png 2x" alt="logo">
                    <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo.png"
                        srcset="{{ asset('frontend/frontV2/') }}/assets/img/logo.png 2x" alt="">
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
            <div class="banner-6">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-9 align-self-center text-center">
                            <h1 class="title">
                                Daftar Anggota Inkindo
                            </h1>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 col-lg-5">
                                        <form action="{{ route('frontend.informasi.members-by-province') }}" method="GET">
                                            @csrf
                                            <div class="form-group">
                                                <select class="form-control" name="provinsi_id" id="" required>
                                                    @foreach ($provinsi as $provinsi)
                                                    <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                            <div class="form-group">
                                                <button type="submit" class="form-control">Filter Anggota</button>
                                           </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="information" id="information">
            <div class="container">
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="title">
                            <h2 class="wow fadeInUp" data-wow-delay="0.1s">
                                Daftar Anggota Inkindo
                            </h2>
                        </div>
                    </div>
                </div> -->
                <div class="row justify-content-center">
                    @if (count($anggotaSemuaProvinsi) == 0)
                    <div class="col-12 col-md-6 col-lg-4">
                        <h4>Data Tidak Di Temukan</h4>
                    </div>
                    @else
                        
                    
                    @foreach ($anggotaSemuaProvinsi as $anggotaSemuaProvinsiRow)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card-member">
                            <div class="content">
                                <h4 class="name">
                                    <a href="#">
                                        {{ strtoupper($anggotaSemuaProvinsiRow->nm_bu)  }}
                                    </a>
                                </h4>
                                <p class="position">
                                    <i class="fas fa-map-marker-alt"></i> {{ $anggotaSemuaProvinsiRow->nama_provinsi  }}
                                </p>
                                <div class="social">
                                    <ul>
                                        <li>
                                            <b>No KTA :</b> {{ $anggotaSemuaProvinsiRow->no_kta  }}
                                        </li>
                                        <li>
                                            <b>Bentuk Badan Usaha :</b> {{ strtoupper($anggotaSemuaProvinsiRow->bentuk_bu)  }}
                                        </li>
                                        <li>
                                            <b>Penanggung Jawab Badan Usaha :</b>
                                            {{ $anggotaSemuaProvinsiRow->nm_pjbu  }}
                                        </li>
                                        <li class="mt-2">
                                            <a href="javascript:void"
                                                class="showmore-member font-weight-bold text-primary"
                                                data-toggle="collapse" data-target="#showmore-1" aria-expanded="false"
                                                aria-controls="showmore-1">
                                                Lihat Selengkapnya
                                            </a>
                                        </li>
                                        <div class="collapse" id="showmore-1">
                                            <hr>
                                            <li class="d-flex justify-content-start align-items-start">
                                                <i class="fas fa-map-marker-alt mr-2 mt-1"></i>
                                                <span>
                                                    {{ $anggotaSemuaProvinsiRow->alamat  }}
                                                </span>
                                            </li>
                                            <li class="d-flex justify-content-start align-items-start">
                                                <i class="fas fa-phone mr-2 mt-1"></i>
                                                <span>
                                                    {{ $anggotaSemuaProvinsiRow->no_telp  }}
                                                </span>
                                            </li>
                                            <li class="d-flex justify-content-start align-items-start">
                                                <i class="fas fa-envelope mr-2 mt-1"></i>
                                                <span>
                                                    {{ $anggotaSemuaProvinsiRow->email_bu  }}
                                                </span>
                                            </li>
                                            <li class="d-flex justify-content-start align-items-start">
                                                <i class="fas fa-globe mr-2 mt-1"></i>
                                                <span>
                                                    {{ $anggotaSemuaProvinsiRow->website  }}
                                                </span>
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <nav aria-label="Page navigation example">
                            {{ $anggotaSemuaProvinsi->appends(Request()->all())->links() }}
                        </nav>
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
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/bootstrap/jquery.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/bootstrap/popper.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/bootstrap/bootstrap.js">
    </script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/owl-carousel/owl.carousel.js">
    </script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/select2/select2.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/fancybox/fancybox.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/js/theme.js"></script>
    <!-- End Source JS We Use -->
</body>

</html>