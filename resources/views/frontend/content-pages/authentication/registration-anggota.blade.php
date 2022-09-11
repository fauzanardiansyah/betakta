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
    <link rel="stylesheet" href="{{ asset('frontend/frontV2') }}/assets/packages/owl-carousel/owl.carousel.css">
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
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/frontV2') }}/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('frontend/frontV2') }}/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('frontend/frontV2') }}/assets/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="http://inkindo.com/index.html">

    <!-- Sweet Alert 2  -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.12.1/dist/sweetalert2.all.min.js"></script>
</head>
<body>
@include('frontend/includes.alert')
    <main>
        <div class="login-register-section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 p-0">
                        <div class="background">
                            <a href="{{ route('front.home') }}">
                                <img src="{{ asset('frontend/frontV2') }}/assets/img/logo-white.png" class="float-logo">
                            </a>
                            <div class="text-feature-area">
                                <h5 class="text-white">
                                    <b>
                                        Dedikasi pada Member
                                    </b>
                                </h5>                        
                                <p class="text-white">Member selalu menjadi prioritas utama kami. Sebelum membuat keputusan, kami selalu memikirkan member, terutama soal apa yang dapat kami lakukan untuk melayani Anda lebih baik lagi.</p>
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
                                <img src="{{ asset('frontend/frontV2') }}/assets/img/logo.png" class="img-fluid">
                            </div>

                            <h1>DAFTAR</h1>
                            <!-- Form -->
                            <form action="{{ route('auth.user.regist') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input name="npwp_bu" class="form-control input" placeholder="NPWP Badan Usaha"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            type="text" maxlength="17" value="{{old('npwp_bu')}}" data-mask="00.000.000.0-000.000" required>
            
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email_bu" value="{!! old('email_bu') !!}"
                                            placeholder="Email Badan Usaha" class="form-control input" required>
            
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="nm_bu" value="{!! old('nm_bu') !!}" placeholder="Nama Badan Usaha"
                                            class="form-control" required>
            
                                    </div>
                                    <div class="form-group">
                                        <select name="bentuk_bu" id="" class="form-control" required>
                                            <option value="">--Bentuk Badan Usaha--</option>
                                            <option value="pt">PT</option>
                                            <option value="cv">CV</option>
                                            <option value="kjpp">KJJP</option>
                                            <option value="firma">Firma</option>
                                            <option value="representative Office">Representative Office</option>
                                            <option value="koprasi">Koprasi</option>
                                            <option value="lainya">Lainya</option>
                                        </select>
            
            
                                    </div>
            
                                    <div class="form-group">
                                        <select name="status_bu" id="" class="form-control" required>
                                            <option value="">--Status Badan Usaha--</option>
                                            <option value="pusat">pusat</option>
                                            <option value="cabang">cabang</option>
                                        </select>
                                    </div>
            
                                    <div class="form-group">
                                        <input type="password" name="password" value="" placeholder="Password" class="form-control input"
                                            required>
            
            
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                                            class="form-control input" required>
            
                                    </div>
                                    <div class="form-group">
                                        <div class="g-recaptcha" data-sitekey="6LfGB7sUAAAAAC55ve1JGLFCOcnLQ7HTw78R1xCz"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="tac" required> <label for="">Saya memahami alur & menyetujui
                                            ketentuan yang dibuat INKINDO</label>
                                    </div>
                                    <p class="text-center">
                                        <button class="btn btn-template-outlined form-control"><i
                                                class="fa fa-sign-in"></i>Daftar</button>
                                    </p>
            
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Source JS We Use -->
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/bootstrap/jquery.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/bootstrap/popper.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/bootstrap/bootstrap.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/select2/select2.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/packages/fancybox/fancybox.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/frontV2') }}/assets/js/theme.js"></script>
    <!-- Jquery Input Mask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <!-- End Source JS We Use -->
</body>
</html>