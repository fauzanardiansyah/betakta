<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="sess-id" content="{{ Session::get('id_dp') }}">




  <link rel="icon" href="{{ asset('backend/images/favicon.ico') }}" type="image/ico" />

  <title>@yield('title')</title>

  <!-- Bootstrap -->
  <link href="{{ asset('backend/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('backend/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
  <!-- iCheck -->
  <link href="{{ asset('backend/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">

  <!-- bootstrap-progressbar -->
  <link href="{{ asset('backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}"
    rel="stylesheet">
  <!-- JQVMap -->
  <link href="{{ asset('backend/vendors/jqvmap/dist/jqvmap.min.css') }}" rel="stylesheet" />
  <!-- bootstrap-daterangepicker -->
  <link href="{{ asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset('backend/build/css/custom.min.css') }}" rel="stylesheet">
  <!-- Datatables CSS -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
  <!-- Pnotify -->
  <link href="{{ asset('backend/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">


  <!-- My Css -->
  <link href="{{ asset('backend/css/MyCss/DppStyle.css') }}" rel="stylesheet">\
  {{-- <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> --}}
  <!-- Highchart -->
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <!-- Sweet Alert 2  -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <!-- Jquery Input Mask -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/95c75768/cloudflare-static/rocket-loader.min.js"
    data-cf-settings="953f9ddfbd71f1ba52dbf194-|49" defer=""></script>



</head>

<body class="nav-md">
  @include('backend/dpp/includes.alert')
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0; padding-bottom:5px">
            <a href="{{ url('/') }}" class="site_title">
              <img src="{{ asset('backend/kta-assets/logo-white.png') }}" id="main-logo" alt="" srcset="">
              <span class="title_logo">KTA ONLINE INKINDO</span>
            </a>
          </div>
          <?php
              $fotoProfile = DB::table('t_dp')->whereId(Session::get('id_dp'))->first();
            ?>
          <div class="clearfix"></div>
          <div class="profile_pic">
            @if (!is_file(public_path('storage/profile-dpp/'.$fotoProfile->foto_profile_dpp)))
            <img src="{{ asset('backend/kta-assets/user.png') }}" class="img-circle profile_img" alt="" srcset="">
            @else
            <img src="{{ asset('storage/profile-dpp/'.$fotoProfile->foto_profile_dpp) }}" alt="..." class="img-circle profile_img">    
            @endif

          </div>
          <div class="profile_info">
            <span>Welcome,</span>
            <h2>Dewan Pengurus Provinsi {{ Session::get('nm_dpp') }}</h2>
          </div>
          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>General</h3>
              <ul class="nav side-menu">
                <li><a href="{{ route('dpp.dashboard') }}"><i class="fa fa-home"></i> Dashboard <span
                      class="fa fa-chevron-right"></span></a></li>
                <li><a><i class="fa fa-user"></i> Master Anggota <span class="fa fa-chevron-right"></span></a>
                  <ul class="nav child_menu" style="display: none;">
                    <li><a href="{{ route('dpp.master-anggota.baru') }}">Pengajuan</a></li>
                    <li><a href="{{ route('dpp.master-anggota.berhenti') }}">Pemberhentian</a></li>
                  </ul>
                </li>

                <li><a><i class="fa fa-money"></i> Invoice <span class="fa fa-chevron-right"></span></a>
                  <ul class="nav child_menu" style="display: none;">
                    <li><a href="{{ route('dpp.invoice.anggota') }}">Terbitkan Invoice Anggota</a></li>
                    <li><a href="{{ route('dpp.invoice.roleshare') }}">Invoice Role Sharing</a></li>
                  </ul>
                </li>
                <li><a href="{{ route('dpp.payment.main') }}"><i class="fa fa-bank"></i> Pembayaran Anggota <span
                      class="fa fa-chevron-right"></span></a>
                <li><a href="{{ route('dpp.akses.kta') }}"><i class="fa fa-edit"></i> Buka Akses KTA <span
                      class="fa fa-chevron-right"></span></a></li>
                      <li><a href="{{ route('dpp.download-kta') }}"><i class="fa fa-download"></i> Download KTA<span
                        class="fa fa-chevron-right"></span></a></li>
                <li><a href="{{ route('dpp.report.main') }}"><i class="fa fa-file-pdf-o"></i> Reports <span
                      class="fa fa-chevron-right"></span></a></li>

              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
          <!-- /menu footer buttons -->
        </div>
      </div>
      <!-- top navigation -->
      <div id="app">
        <div id="notification">
          <div class="top_nav">
            <div class="nav_menu">
              <nav>
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>

                <ul class="nav navbar-nav navbar-right">

                  <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                      aria-expanded="false">
                      Dewan Pengurus Provinsi {{ Session::get('nm_dpp') }}
                      <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                      <li><a href="{{ route('dpp.administrator.main') }}"> Administrator</a></li>
                      <li>
                        <a href="{{ route('dpp.auth.logout') }}" onclick="event.preventDefault();     
                          document.getElementById('logout-form').submit();">
                          <i class="fa fa-sign-out pull-right"></i>
                          Logout
                        </a>

                        <form id="logout-form" action="{{ route('dpp.auth.logout') }}" method="POST"
                          style="display: one;">
                          {{ csrf_field() }}
                        </form>

                      </li>
                    </ul>
                  </li>
                  <Notifications v-bind:notifications="notifications"></Notifications>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>


      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        @yield('content-pages')
      </div>
      <!-- /page content -->

      <!-- footer content -->
      <footer>
        <div class="pull-right">
          &copy; <a href="https://www.inkindo.org/" target="_blank">INKINDO </a><span style="font-style:italic">All
            Rights Reserved</span>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!-- /footer content -->
    </div>
  </div>





  <!-- App JS -->
  <script src="{{ asset('js/app.js') }}"></script>
  <!-- Jquery Core CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <!-- Pusher JS -->
  <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('backend/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('backend/vendors/fastclick/lib/fastclick.js') }}"></script>
  <!-- NProgress -->
  <script src="{{ asset('backend/vendors/nprogress/nprogress.js') }}"></script>
  <!-- DateJS -->
  <script src="{{ asset('backend/vendors/DateJS/build/date.js') }}"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="{{ asset('backend/vendors/moment/min/moment.min.js') }}"></script>
  <script src="{{ asset('backend/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <!-- Pnotify -->
  <script src="{{ asset('backend/vendors/pnotify/dist/pnotify.js') }}" type="8c3dc6235cb72baa62c3c0e5-text/javascript">
  </script>
  <!-- jQuery Smart Wizard -->
  <script src="{{ asset('backend/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>
  <!-- Custom Theme Scripts -->
  <script src="{{ asset('backend/build/js/custom.min.js') }}"></script>
  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <!-- Mycustom Js -->
  <script src="{{ asset('backend/js/dpp/mycustom.js') }}"></script>
  <!-- PDF Object Plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
  <!-- App scripts -->
  <script src="{{ asset('backend/js/dpp/myalerts.js') }}"></script>
  @stack('scripts')

</body>

</html>