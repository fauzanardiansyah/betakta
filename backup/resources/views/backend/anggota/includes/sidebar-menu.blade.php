<?php
    $fotoProfile = \App\RegistrationUsers::find(Session::get('id_registrasi_user'))
?>
<div class="profile clearfix">
      <div class="profile_pic">
            
            @if (!is_file(public_path('storage/logo-badan-usaha/'.$fotoProfile->foto_profile)))
            <img src="{{ asset('backend/kta-assets/user.png') }}" class="img-circle profile_img" alt="" srcset="">
            @else
            <img src="{{ asset('storage/logo-badan-usaha/'.$fotoProfile->foto_profile) }}" alt="..." class="img-circle profile_img">    
            @endif
           
      </div>
      <div class="profile_info">
            <span>Welcome,</span>
            <h2>{{ $fotoProfile->nm_bu }}</h2>
      </div>
</div>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
            <h3>General</h3>
            <ul class="nav side-menu">
                  <li><a href="{{ route('anggota.dashboard') }}"><i class="fa fa-home"></i> Dashboard <span
                                    class="fa fa-chevron-right"></span></a></li>
                  <li><a href="#"><i class="fa fa-plus-square"></i> Registrasi Anggota <span
                                    class="fa fa-chevron-right"></span></a>
                        <ul class="nav child_menu">
                              <li><a href="{{ route('anggota.registration') }}"><i class="fa fa-user"></i> Buat Baru
                                          <span class="fa fa-chevron-right"></span></a></li>
                              <li><a href="{{ route('anggota.re-registration') }}"><i class="fa fa-user"></i>
                                          Pendaftaran Ulang <span class="fa fa-chevron-right"></span></a></li>
                        </ul>
                  </li>
                  <li><a href="{{ route('anggota.status.main') }}"><i class="fa fa-sliders"></i> Status Anggota<span
                                    class="fa fa-chevron-right"></span></a></li>
                  <li><a href="{{ route('anggota.invoice.main') }}"><i class="fa fa-money"></i>Invoice<span
                                    class="fa fa-chevron-right"></span></a></li>
                  <li><a href="{{ route('anggota.download-kta') }}"><i class="fa fa-download"></i> Download KTA<span
                                    class="fa fa-chevron-right"></span></a></li>
                  <li><a href="{{ route('anggota.berangkas.main') }}"><i class="fa fa-university"></i> Berangkas<span
                                    class="fa fa-chevron-right"></span></a></li>
            </ul>
      </div>
</div>