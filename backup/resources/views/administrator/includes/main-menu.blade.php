<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="{{ route('administrator.dashboard.main') }}" class="">
                        <i class="metismenu-icon pe-7s-display1"></i>
                        Dashboard Administrator
                    </a>
                </li>

                <li class="app-sidebar__heading">Master Anggota</li>
                <li>
                    <a href="{{ route('administrator.masater-anggota.main') }}" class="">
                        <i class="metismenu-icon pe-7s-id"></i>
                        Anggota Inkindo Lokal/Afiliasi
                    </a>
                </li>
               
                <li class="app-sidebar__heading">CMS</li>
                <li>
                    <a href="#" class="">
                        <i class="metismenu-icon pe-7s-monitor"></i>
                        Frontend
                    </a>

                    <ul class="mm-collapse" style="">
                            <li>
                                <a href="{{ route('administrator.cms.frontend-testimonials') }}">
                                    <i class="metismenu-icon">
                                    </i>Testimonials
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('administrator.cms.frontend-sponsorship') }}">
                                    <i class="metismenu-icon">
                                    </i>Sponsorship
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('administrator.cms.frontend-faq') }}">
                                    <i class="metismenu-icon">
                                    </i>FAQ
                                </a>
                            </li>

                        </ul>
                </li>
                <li>
                    <a href="{{ route('administrator.cms.portal-main') }}" class="">
                        <i class="metismenu-icon pe-7s-radio"></i>
                        Portal Berita
                    </a>
                </li>
                <li class="app-sidebar__heading">Administrator</li>
                <li>
                    <a href="{{ route('administrator.dewan.dpn-main') }}" class="">
                        <i class="metismenu-icon pe-7s-config"></i>
                        Sekretariat Nasional
                    </a>
                </li>
                <li>
                    <a href="{{ route('administrator.dewan.dpp-main') }}" class="">
                        <i class="metismenu-icon pe-7s-config"></i>
                        Sekretariat Provinsi
                    </a>
                </li>
                <li class="app-sidebar__heading"></li>
                <li>
                    <a href="{{ route('auth.user.logout') }}" onclick="event.preventDefault();     
                      document.getElementById('logout-form').submit();">
                      <i class="fa fa-sign-out pull-right"></i>
                      Logout
                    </a>

                    <form id="logout-form" action="{{ route('admin.auth.logout') }}" method="POST" style="display: one;">
                      {{ csrf_field() }}
                    </form>

                </li>
            </ul>
        </div>
    </div>
</div>