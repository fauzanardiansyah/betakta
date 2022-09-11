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

    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon.ico' />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('frontend/frontV2/') }}/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="http://inkindo.com/index.html">
</head>
<body>
    <main>
        <div class="login-dpp" style="background: url({{ asset('frontend/frontV2/') }}/assets/img/map.svg);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10">
                        <div class="card border-0" style="border-radius: 10px; overflow: hidden;     box-shadow: 0 0 25px 2px rgba(0,0,0,.05);">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-5 pr-lg-0">
                                    <div class="login-area">
                                            
                                        <form action="{{ route('dpp.auth.login') }}" method="POST">
                                            @csrf
                                            <a href="{{ route('front.home') }}">
                                                <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo.png" class="mb-4" alt="">
                                            </a>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="npwp_email_pengurus" id="email" placeholder="Email Pengurus" required="" />
                                                {!! $errors->first('npwp_email_pengurus', '<p class="alert alert-danger" style="margin-top:5px">:message</p>') !!}
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="" />
                                                {!! $errors->first('password', '<p class="alert alert-danger" style="margin-top:5px">:message</p>') !!}
                                            </div>
                                            
                                            <button type="submit" class="btn btn-block btn-primary">
                                                Login
                                            </button>
                                            <br>
                                            @if (Session::has('failPasswordLoginRegistrationUser'))
                                            <p class="alert alert-success">{{ Session::get('failPasswordLoginRegistrationUser') }}</p>
                                            @elseif(Session::has('failEmailOrNpwpLoginRegistrationUser'))
                                            <p class="alert alert-success">{{ Session::get('failEmailOrNpwpLoginRegistrationUser') }}</p>
                                            @endif
                                            
                                        </form>
                                    </div>
                                </div>
                                <div class="col-12 col-md-7 pl-lg-0 d-none d-lg-flex" style="background: url({{ asset('frontend/frontV2/') }}/assets/img/login.jpg); 
                                border-top-right-radius: 10px; border-bottom-right-radius: 10px; background-size: cover; display: flex; justify-content: center; align-items: flex-end; padding: 2rem;">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-11 text-center">
                                                <h3 class="font-weight-bold text-white" style="text-shadow: 1px 1px 5px rgba(0,0,0,.5);">
                                                    DEWAN PENGURUS PROVINSI INKINDO
                                                </h3>
                                                <p class="font-weight-light text-white" style="text-shadow: 1px 1px 5px rgba(0,0,0,.5);">
                                                    Di Inkindo kami percaya bahwa member harus menjadi prioritas utama. Kami ada untuk memberikan yang terbaik bagi Anda.
                                                </p>
                                                <a href="{{ url('/') }}" class="btn btn-sm btn-outline-light">
                                                    Kembali Ke Beranda
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Source JS We Use -->
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/bootstrap/jquery.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/bootstrap/popper.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/select2/select2.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/packages/fancybox/fancybox.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2/') }}/assets/js/theme.js"></script>
    <!-- End Source JS We Use -->
</body>
</html>