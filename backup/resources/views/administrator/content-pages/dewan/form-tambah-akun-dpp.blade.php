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
                <h5 class="card-title">Form Tambah Akun Dewan Pengurus Provinsi</h5>
                <form action="{{ route('administrator.dewan.add-akun-dpp-process') }}" method="POST">
                    @csrf


                    <div class="position-relative row form-group"><label for="exampleEmail"
                        class="col-sm-2 col-form-label">Provinsi</label>
                    <div class="col-sm-10">
                        <select name="id_dp" class="form-control" id="">
                            @foreach ($data_dpp as $provinsi_item)
                                <option value="{{ $provinsi_item->id }}">{{ $provinsi_item->provinsi->name }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('npwp_pengurus', '<p class=""
                            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                        !!}
                    </div>
                </div>
                    
                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">NPWP Pengurus</label>
                        <div class="col-sm-10"><input name="npwp_pengurus" id="exampleEmail" placeholder="NPWP Pengurus"
                                type="text" class="form-control" value="{{ old('no_rek') }}" required>
                            {!! $errors->first('npwp_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Email Pengurus</label>
                        <div class="col-sm-10"><input name="email_pengurus" id="examplePassword" value="{{ old('nm_rek') }}" type="text" class="form-control"  placeholder="Email Pengurus" type="text" class="form-control"  required>
                            {!! $errors->first('email_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>


                    <div class="position-relative row form-group"><label for="examplePassword"
                        class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10"><input name="password" id="examplePassword" value="{{ old('nm_rek') }}" 
                        type="text" class="form-control"  placeholder="Password" type="text" class="form-control"  required>
                        {!! $errors->first('password', '<p class=""
                            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                        !!}
                    </div>
                   </div>

                   <div class="position-relative row form-group"><label for="examplePassword"
                    class="col-sm-2 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-10"><input name="password_confirmation" id="examplePassword" value="{{ old('nm_rek') }}"
                     type="text" class="form-control"  placeholder="Konfirmasi Password" type="text" class="form-control"  required>
                    {!! $errors->first('password_confirmation', '<p class=""
                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                    !!}
                </div>
            </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"> <button class="btn btn-success">Simpan Akun Dewan Pengurus
                                Provinsi</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection