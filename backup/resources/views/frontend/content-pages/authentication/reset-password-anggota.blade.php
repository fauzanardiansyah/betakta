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
                                        Dedikasi pada Pelanggan
                                    </b>
                                </h5>
                                <p class="text-white">Di INKINDO kami percaya bahwa pelanggan harus menjadi prioritas utama. Kami ada untuk memberikan yang terbaik bagi Anda.</p>
                                <a href="{{ route('front.home') }}" class="btn btn-outline-light">
                                    Kembali Ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 p-0">
                        <div class="login-register">
                            <!-- Heading -->
                            <div class="d-lg-none d-md-none d-block pr-5 pl-5 pb-4 pt-0">
                                <img src="{{ asset('frontend/frontV2/') }}/assets/img/logo.png" class="img-fluid">
                            </div>
        
                            <h1>LUPA PASSWORD</h1>
                            <small class="text-center">Masukan email anda untuk mendapatkan akses untuk melakukan reset password anda</small>
                            <!-- Form -->
                            <form action="{{ route('auth.user.send-reset') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="npwp_email_bu" placeholder="NPWP/Email Badan Usaha"
                                            class="form-control" required>
                                        <span
                                            style="color:brown;font-size:14px">{{ Session::get('failSendResetPassword') }}</span>
                                    </div>
            
                                    <p class="text-center">
                                        <button class="btn btn-template-outlined"><i class="fa fa-sign-in"></i>Reset</button>
                                    </p>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Source JS We Use -->
    <script type="text/javascript" src="assets/packages/bootstrap/jquery.js"></script>
    <script type="text/javascript" src="assets/packages/bootstrap/popper.js"></script>
    <script type="text/javascript" src="assets/packages/bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="assets/packages/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="assets/packages/select2/select2.js"></script>
    <script type="text/javascript" src="assets/packages/fancybox/fancybox.js"></script>
    <script type="text/javascript" src="assets/js/theme.js"></script>
    <!-- End Source JS We Use -->
</body>
</html>