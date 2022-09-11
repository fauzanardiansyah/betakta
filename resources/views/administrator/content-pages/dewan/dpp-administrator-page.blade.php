@extends('administrator/base.home-page')
@section('title', 'Manage Data Pengurus Nasional Inkindo')
@section('content-pages')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Administrator Dewan Pengurus Provinsi Inkindo
                    <div class="page-title-subheading">Ini merupakan halaman administrator Dewan Pengurus Provinsi
                        Inkindo untuk memanage data mulai dari Akses akun dan data DPP.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <a href="http://"></a>
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <a href="{{ route('administrator.dewan.manage-data-dpp') }}" style="text-decoration: none; color:#fff">
                            <div class="widget-heading">Manage Data DPP</div>
                            <div class="widget-subheading">Mengatur data DPP</div>
                        </a>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><i
                                    class="fa fa-database icon-gradient bg-ripe-malin"> </i></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-6">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <a href="{{ route('administrator.dewan.manage-akun-dpp') }}"
                            style="text-decoration: none; color:#fff">
                            <div class="widget-heading">Manage Akun DPP</div>
                            <div class="widget-subheading">Mengatur akun akses DPP</div>
                        </a>

                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><i class="fa fa-cog icon-gradient bg-mean-fruit">
                                </i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection