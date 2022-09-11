@extends('backend/anggota/base.main-page')
@section('title','Profile Badan Usaha')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2><i class="fa fa-bars"></i> Profile Badan Usaha <small>{{ Session::get('nm_bu') }}</small></h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <div class="col-xs-3">
        <!-- required for floating -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-left">
          <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Profile</a>
          </li>
          <li class=""><a href="#reset-password" data-toggle="tab" aria-expanded="false">Reset Password</a>
          </li>
        </ul>
      </div>

      <div class="col-xs-9">
        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="profile">
            <div class="col-md-3">
                <div class="small-12 medium-2 large-2 columns">
                    <div class="circle">
                      <!-- User Profile Image -->
                      @if (empty($dataRegistrasiUser->foto_profile))
                      <img class="profile-pic" src="{{ asset('backend/images/user.png') }}">
                      @else
                      <img class="profile-pic" src="{{ asset('storage/logo-badan-usaha/'.$dataRegistrasiUser->foto_profile) }}">
                      @endif
                     
               
                      <!-- Default Image -->
                      <!-- <i class="fa fa-user fa-5x"></i> -->
                    </div>
                    <div class="p-image">
                      <form action="{{ route('anggota.profile.upload') }}" class="forms-with-spinner" method="POST" enctype="multipart/form-data">
                        @csrf
                          <i class="fa fa-camera upload-button" title="Upload Your Company Logo Here"></i>
                          <input class="file-upload" name="foto_profile" type="file" accept="image/*"/ req>
                          <button id="upload-profile-submit" type="submit">Upload</button>
                          {!! $errors->first('file_nib', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
                      </form> 
                    </div>
                 </div>
            </div>
            <div class="col-md-6">
              <form>

                <div class="row">
                    <div class="item form-group">
                        <label class="col-sm-6 control-label" for="w4-first-name">Nama Badan Usaha </label>
                        <div class="col-sm-6">
                          <label for="">{{ $dataRegistrasiUser->nm_bu }}</label>
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="item form-group">
                        <label class="col-sm-6 control-label" for="w4-first-name">NPWP Badan Usaha</label>
                        <div class="col-sm-6">
                          <label for="">{{ $dataRegistrasiUser->npwp_bu }}</label>
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="item form-group">
                        <label class="col-sm-6 control-label" for="w4-first-name">Email Badan Usaha</label>
                        <div class="col-sm-6">
                          <label for="">{{ $dataRegistrasiUser->email_bu }}</label>
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="item form-group">
                        <label class="col-sm-6 control-label" for="w4-first-name">Bentuk Badan Usaha</label>
                        <div class="col-sm-6">
                          <label for="">{{ $dataRegistrasiUser->bentuk_bu }}</label>
                        </div>
                      </div>
                </div>

                <div class="row">
                    <div class="item form-group">
                        <label class="col-sm-6 control-label" for="w4-first-name">Password</label>
                        <div class="col-sm-6">
                          <label for="">******&nbsp; <a href="#reset-password" data-toggle="tab" aria-expanded="false" style="color:#00447E">Ubah Password</a></label>
                        </div>
                      </div>
                </div>


              </form>
            </div>
          </div>
          <div class="tab-pane" id="reset-password">

              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Formulir Reset Password</h2>
                
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                
                      <form action="{{ route('anggota.profile.reset-pwd') }}" method="POST" class="form-horizontal form-label-left forms-with-spinner" >
                        @csrf
                        <span class="section">Masukan Data Badan Usaha Anda</span>
                        <div class="item form-group">
                          <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda bintang(<span style="color:red">*</span>) wajib di isi</label>
                        </div>
                        <div class="item form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">NPWP/EMAIL Terdaftar<span class="required">*</span>
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="npwp_email_bu"  class="form-control col-md-7 col-xs-12" placeholder="NPWP/EMAIL Terdaftar" required >
                            {!! $errors->first('npwp_email_bu', '<p class=""
                            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                          </div>  
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password Baru<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="password" name="password"  class="form-control col-md-7 col-xs-12" placeholder="Password Baru" required >
                              {!! $errors->first('password', '<p class=""
                              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ketik Ulang Password<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="password" name="password_confirmation"  class="form-control col-md-7 col-xs-12" placeholder="Ketik Ulang Password" required >
                              {!! $errors->first('password_confirmation', '<p class=""
                              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-3">
                            <button id="send" type="submit" class="btn btn-sm btn-danger">Reset Password</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
          </div>
        </div>
      </div>

      <div class="clearfix"></div>

    </div>
  </div>
</div>
@endsection