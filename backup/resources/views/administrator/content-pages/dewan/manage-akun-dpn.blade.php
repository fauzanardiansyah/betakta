@extends('administrator/base.home-page')
@section('title', 'Dashboard')
@section('content-pages')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Administrator Dewan Pengurus Nasional Inkindo
                    <div class="page-title-subheading">Ini merupakan halaman administrator Dewan Pengurus Nasional
                        Inkindo untuk memanage data mulai dari Akses akun dan data DPN.
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
                        <a href="{{ route('administrator.dewan.manage-data-dpn') }}"
                            style="text-decoration: none; color:#fff">
                            <div class="widget-heading">Manage Data DPN</div>
                            <div class="widget-subheading">Mengatur data DPN</div>
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
                        <a href="{{ route('administrator.dewan.manage-account-dpn') }}"
                            style="text-decoration: none; color:#fff">
                            <div class="widget-heading">Manage Akun DPN</div>
                            <div class="widget-subheading">Mengatur akun akses DPN</div>
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

    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Akun Dewan Pengurus Pusat Inkindo</h5>
                <form action="{{ route('administrator.dewan.save-akun-dpn') }}" method="POST">
                    @csrf

                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Kepengurusan</label>
                        <div class="col-sm-10">
                            <select name="id_dp" id="" class="form-control">
                                @if (! empty($user_dpn))
                                @foreach ($pengurus as $pengurus_item)
                                <option value="{{ $pengurus_item->id }}"
                                    {{ ($pengurus_item->id == $user_dpn->id_dp) ? 'selected' : '' }}>
                                    {{ $pengurus_item->provinsi->name }}</option>
                                @endforeach
                                @else
                                @foreach ($pengurus as $pengurus_item)
                                <option value="{{ $pengurus_item->id }}">{{ $pengurus_item->provinsi->name }}</option>
                                @endforeach
                                @endif

                            </select>
                            {!! $errors->first('id_dp', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">NPWP Pengurus</label>
                        <div class="col-sm-10"><input name="npwp_pengurus" id="exampleEmail" placeholder="NPWP Pengurus"
                                type="text" class="form-control" value="{{ (!empty($user_dpn)) ? $user_dpn->npwp_pengurus : "" }}" required>
                            {!! $errors->first('npwp_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Email Pengurus</label>
                        <div class="col-sm-10"><input name="email_pengurus" id="exampleEmail"
                                placeholder="Email Pengurus" type="text" class="form-control" value="{{ (!empty($user_dpn)) ? $user_dpn->email_pengurus : "" }}" required>
                            {!! $errors->first('email_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>

                    </div>

                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10"><input name="password" id="exampleEmail" placeholder="Password"
                                type="password" class="form-control" required >
                            {!! $errors->first('password', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>

                    </div>


                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-10"><input name="password_confirmation" id="exampleEmail"
                                placeholder="Konfirmasi Password" type="password" class="form-control" required >
                            {!! $errors->first('konfirmasi_password', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>

                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"> <button class="btn btn-success">Simpan Akun Dewan Pengurus
                                Nasional</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection