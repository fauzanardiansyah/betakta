<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KTA Online Inkindo | Login Anggota</title>
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

    <!-- Script JS we use -->
    {!! NoCaptcha::renderJs() !!}
    <!-- Sweet Alert 2  -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.12.1/dist/sweetalert2.all.min.js"></script>
</head>
<body>
        @include('frontend/includes.alert')
    <main>
        <div class="login-register-section">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-lg-5 p-0">
                        <div class="background">
                            <a href="index.html">
                                <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo-white.png" class="float-logo">
                            </a>
                            <div class="text-feature-area">
                                <h5 class="text-white">
                                    <b>
                                        Dedikasi pada Member
                                    </b>
                                </h5>
                                <p class="text-white">Di Inkindo kami percaya bahwa member harus menjadi prioritas utama. Kami ada untuk memberikan yang terbaik bagi Anda.</p>
                                <a href="{{ url('/') }}" class="btn btn-outline-light">
                                    Kembali Ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 p-0">
                        <div class="login-register">
                            <!-- Heading -->
                            <div class="d-lg-none d-md-none d-block pr-5 pl-5 pb-4 pt-0 text-center">
                                <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo.png" class="img-fluid" style="width: 200px;">
                            </div>
        
                            <h1>MASUK</h1>
                            <!-- Form -->
                            <form action="{{ route('auth.user.login') }}" method="post">
                                @csrf
                                <!-- name input -->
                                <div class="input-block">
                                        <input type="text" name="npwp_email_bu" placeholder="NPWP/Email Badan Usaha"
                                        value="{{ old('npwp_email_bu') }}" class="form-control input">
                                        <span
								style="color:brown;font-size:14px">{{ Session::get('failEmailOrNpwpLoginRegistrationUser') }}</span>
                                </div>
                                <!-- password input -->
                                <div class="input-block">
                                        <input id="password_modal" name="password" type="password" placeholder="password"
                                        class="form-control input">
                                    <span
                                        style="color:brown;font-size:14px">{{ Session::get('failPasswordLoginRegistrationUser') }}</span>
                                </div>

                                <div class="form-group">
                                    {!! app('captcha')->display() !!}
                                        {{-- <div class="g-recaptcha" data-sitekey="6Leu160ZAAAAAE3hkPMZzzHMlX_qsE242yRjKmV7"></div> --}}
                                    </div>
                                <!-- sign in button -->
                                <button type="submit" class="btn btn-primary btn-block">
                                    Masuk
                                </button>
                                <div class="forgot-register my-2 mt-4 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('auth.user.show-forgot-password') }}" id="to-recover" class="text-dark">
                                        Lupa Password?
                                    </a>
                                    <p class="mb-0">
                                        Tidak punya akun? <a href="{{ route('auth.user.show-registration') }}">Daftar sekarang</a>
                                    </p>
                                </div>
                                <br>

                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @elseif ($errors->has('g-recaptcha-response'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                                @endif
                            </form>
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