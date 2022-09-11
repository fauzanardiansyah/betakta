@include('backend/anggota/includes.head')
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title">
            <a href="{{ url('/') }}" class="site_title">
              <img src="{{ asset('backend/kta-assets/logo-white.png') }}" id="main-logo" alt="" srcset="">
              <span class="title_logo">KTA ONLINE INKINDO</span>
            </a>
          </div>
          <div class="clearfix"></div>
          <!-- /menu profile quick info -->
          <br />
          <!-- sidebar menu -->
          @include('backend/anggota/includes.sidebar-menu')
          <!-- /sidebar menu -->
          <!-- /menu footer buttons -->
        </div>
      </div>
      <!-- top navigation -->
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
                  <?php
                    $fotoProfile = \App\RegistrationUsers::find(Session::get('id_registrasi_user'))
                  ?>
                  <img src="{{ asset('storage/logo-badan-usaha/'.$fotoProfile->foto_profile) }}" alt="">
                  {{ Session::get('nm_bu') }}
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="{{ route('anggota.profile') }}"> Profile</a></li>
                  <li>
                    <a href="{{ route('auth.user.logout') }}" onclick="event.preventDefault();     
                      document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out pull-right"></i>
                      Logout
                    </a>

                    <form id="logout-form" action="{{ route('auth.user.logout') }}" method="POST" style="display: one;">
                      {{ csrf_field() }}
                    </form>


                  </li>
                </ul>
              </li>
              <li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <?php
                  
                  $anggotaNotify = DB::table('t_detail_kta')
                               ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                               ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                               ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
                               ->select('t_app_kta.keterangan', 't_detail_kta.id as id_detail_kta')
                               ->where('t_registrasi_users.id', '=', Session::get('id_registrasi_user'))
                               ->where('t_detail_kta.view_notifikasi', '=', 0)
                               ->get();
                              
                  ?>
                  <span class="badge bg-green">{{ count($anggotaNotify) }}</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">

                  @if (count($anggotaNotify) == 0)
                  <li>No notification</li>
                  @else
                  @foreach ($anggotaNotify as $notify)
                  <li>
                    <form action="{{ route('anggota.notification.read') }}" id="notify_read" method="POST">
                      @csrf
                      <a onclick="document.getElementById('notify_read').submit(); return false;">
                        <span class="message">
                          {!! $result = ($notify->keterangan == '') ? 'No notification' : $notify->keterangan !!}
                          <input type="hidden" name="id_detail_kta" value="{!! $notify->id_detail_kta !!}">
                        </span>
                      </a>
                    </form>
                  </li>
                  @endforeach
                  @endif
                </ul>
              </li>
            </ul>
          </nav>
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

  @include('backend/anggota/includes.js-asset')
  @include('backend/anggota/includes.alert')
  @stack('scripts')
</body>

</html>