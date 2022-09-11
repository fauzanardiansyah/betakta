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
    <link rel="stylesheet" href="{{ asset('frontend/frontV2/') }}/{{ asset('frontend/frontV2/') }}/assets/packages/animate/animate.css">
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
        <div class="login-superadmin">
            <div class="login-form-superadmin">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-12 col-md-5 text-center text-lg-left">
                            <div class="card border-0 mb-3" style="border-radius: 10px; overflow: hidden;     box-shadow: 0 0 25px 2px rgba(0,0,0,.05);">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="login-area">
                                            <form action="{{ route('admin.auth.login') }}" method="post" autocomplete="off">
                                                @csrf
                                                <a href="{{ url('/') }}">
                                                    <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo.png" class="mb-4" alt="">
                                                </a>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                                    {!! $errors->first('email', '<p class="alert alert-danger" style="margin-top:5px">:message</p>') !!}
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                                    {!! $errors->first('password', '<p class="alert alert-danger" style="margin-top:5px">:message</p>') !!}
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12 col-md-12 text-center">
                                                        @if (Session::has('failPasswordLogin'))
                                                            <div class="alert alert-danger">Password anda salah</div>
                                                        @endif
                                                        @if (Session::has('failEmailLogin'))
                                                            <div class="alert alert-danger">Email Tidak Di Temukan</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-block btn-primary">
                                                    Login
                                                </button>
                                                <div class="row mt-4">
                                                    <div class="col-12 col-md-12 text-center text-md-center">
                                                        {{-- <a class="text-muted" href="register-superadmin.html">
                                                            <Small>
                                                                Belum punya akun? <strong>Daftar Disini</strong>
                                                            </Small>
                                                        </a> --}}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="text-white" href="{{ url('/') }}">
                                <i class="fas fa-arrow-left mr-1"></i> Back To Home
                            </a>
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