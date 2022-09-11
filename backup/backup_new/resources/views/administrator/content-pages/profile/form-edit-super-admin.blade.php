@extends('administrator/base.home-page')
@section('title', 'Form Data Pengurus Nasional Inkindo')
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


    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Form Edit Akun Super Admin</h5>
                <form action="{{ route('administrator.profile.update-superadmin-process', ['id' => $superadmin->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Nama Admin</label>
                        <div class="col-sm-10"><input name="nama_admin" id="exampleEmail" placeholder="Nama Admin"
                                type="text" class="form-control" value="{{ $superadmin->nama_admin }}" required>
                            {!! $errors->first('nama_admin', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Email Admin</label>
                        <div class="col-sm-10"><input name="email" id="examplePassword" value="{{  $superadmin->email }}"
                                type="email" class="form-control" placeholder="Email Admin" required>
                            {!! $errors->first('email', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Foto Profile</label>
                        <div class="col-sm-10">
                                <img src="{{ asset('storage/superadmin/'.$superadmin->foto_profile) }}" style="width:100px" class="img-fluid">
                            <input name="foto_profile" id="examplePassword"
                                 type="file" class="form-control"
                                placeholder="Email Pengurus">
                            {!! $errors->first('foto_profile', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10"><input name="jabatan" id="exampleEmail" placeholder="Jabatan"
                                type="text" class="form-control" value="{{  $superadmin->jabatan }}" required>
                            {!! $errors->first('jabatan', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>


                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10"><input name="password" id="examplePassword" 
                                type="password" class="form-control" placeholder="Password" type="text" class="form-control"
                                required>
                            {!! $errors->first('password', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-10"><input name="password_confirmation" id="examplePassword"
                                 type="password" class="form-control"
                                placeholder="Konfirmasi Password" type="text" class="form-control" required>
                            {!! $errors->first('password_confirmation', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"> <button class="btn btn-success">Simpan Akun Super Admin</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection