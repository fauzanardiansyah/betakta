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
 <?php
                  
$anggotaNotify = DB::table('t_detail_kta')
             ->join('t_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
             ->join('t_registrasi_users', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
             ->join('t_app_kta', 't_detail_kta.id', '=', 't_app_kta.id_detail_kta')
             ->select('t_app_kta.keterangan', 't_detail_kta.id as id_detail_kta','t_kta.id as id_kta', 't_kta.no_kta','t_kta.kualifikasi', 't_kta.lokasi_pengurusan', 't_kta.status_kta', 't_detail_kta.waktu_pengajuan', 't_detail_kta.jenis_pengajuan', 't_detail_kta.masa_berlaku', 't_detail_kta.id as id_detail_kta', 't_app_kta.status_pengajuan','t_kta.jenis_bu')
             ->where('t_registrasi_users.id', '=', Session::get('id_registrasi_user'))
             ->where('t_detail_kta.view_notifikasi', '=', 0)
             ->whereNotNull('no_kta')
             ->orderBy('t_kta.created_at','desc')
             ->first();

?>
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

                              @if(!empty($anggotaNotify) )
                                @if($anggotaNotify->jenis_bu == 'pmdn')            
                                    <li><a href="{{ route('pindah_dpp') }}"><i class="fa fa-user"></i>
                                              Pindah DPP <span class="fa fa-chevron-right"></span></a></li>
                                    @if($anggotaNotify->kualifikasi == 'kecil' )
                                        <li><a href="{{ route('index_naik_kualifikasi') }}"><i class="fa fa-user"></i>
                                                Naik Kualifikasi <span class="fa fa-chevron-right"></span></a></li>
                                    @elseif($anggotaNotify->kualifikasi == 'menengah')
                                      <li><a href="{{ route('index_naik_kualifikasi') }}"><i class="fa fa-user"></i>
                                                Naik Kualifikasi <span class="fa fa-chevron-right"></span></a></li>
                                      <li><a href="{{ route('index_turun_kualifikasi') }}"><i class="fa fa-user"></i>
                                                Turun Kualifikasi <span class="fa fa-chevron-right"></span></a></li>
                                    @elseif($anggotaNotify->kualifikasi == 'besar')
                                      <li><a href="{{ route('index_turun_kualifikasi') }}"><i class="fa fa-user"></i>
                                                Turun Kualifikasi <span class="fa fa-chevron-right"></span></a></li>
                                    @endif
                                @endif
                              @endif
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