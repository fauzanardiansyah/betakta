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
                        <div class="col-md-6 align-self-center text-center">
                            <h1 class="title">
                                F. A. Q
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-blog justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Faq</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="faq" id="faq">
            <div class="container">
                <div class="accordion" id="faqAccordion">
                    @if (empty($faq))
                    <h3>FAQ Tidak Di Temukan</h3>
                    @else
                    <?php $no= 0; ?>
                    @foreach ($faq as $faq_item)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-primary" type="button" data-toggle="collapse"
                                    data-target="#collapse-{{ $no }}" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#collapse-{{ $no }}" aria-expanded="true" aria-controls="collapseOne">
                                    {!! $faq_item->question !!}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse-{{ $no }}" class="collapse" aria-labelledby="headingOne"
                            data-parent="#faqAccordion">
                            <div class="card-body">
                                {!! $faq_item->answer !!}
                            </div>
                        </div>
                    </div>
                    <?php $no++; ?>
                    @endforeach
                    @endif
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