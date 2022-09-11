@extends('backend/anggota/base.main-page')
@section('title','Form Administrasi Badan Usaha')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Formulir Pendaftaran Ulang Anggota</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <form action="{{ route('anggota.re-registration.administrasiBadanUsaha') }}" method="POST"
        class="form-horizontal form-label-left">
        @csrf
        <span class="section">Administrasi Badan Usaha</span>
        <div id="wizard" class="form_wizard wizard_horizontal">
          <ul class="wizard_steps anchor">
            <li>
              <a href="#step-1" class="done" isdone="1" rel="1">
                <span class="step_no">1</span>
                <span class="step_descr">
                  Step 1<br>
                  <small>Administrasi Badan Usaha</small>
                </span>
              </a>
            </li>
            <li>
              <a href="#step-2" class="selected" isdone="1" rel="2">
                <span class="step_no">2</span>
                <span class="step_descr">
                  Step 2<br>
                  <small>Data Penanggung Jawab Badan Usaha</small>
                </span>
              </a>
            </li>
            <li>
              <a href="#step-3" class="" isdone="1" rel="3">
                <span class="step_no">3</span>
                <span class="step_descr">
                  Step 3<br>
                  <small>Legalitas Badan Usaha</small>
                </span>
              </a>
            </li>
            <li>
              <a href="#step-4" class="" isdone="1" rel="4">
                <span class="step_no">4</span>
                <span class="step_descr">
                  Step 4<br>
                  <small>Upload Dokumen Pendukung</small>
                </span>
              </a>
            </li>
          </ul>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda bintang(<span
              style="color:red">*</span>) wajib di isi</label>
        </div>


        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Nama Badan Usaha <span
              class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="first-name" id="w4-first-name" value="{{ $dataUser->nm_bu }}"
              disabled="">
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Bentuk Badan Usaha <span
              class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" value="{{ $dataUser->bentuk_bu }}" disabled="">
          
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">NPWP Badan Usaha <span
              class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" value="{{ $dataUser->npwp_bu }}" disabled="">
            
        
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Status Badan Usaha <span
              class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" value="{{ $dataUser->status_bu }}" disabled="">
            
        
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Email Badan Usaha <span
              class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" value="{{ $dataUser->email_bu }}" disabled="">
        
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Alamat Perusahaan <span
              class="required">*</span></label>
          <div class="col-sm-9">
            <textarea name="alamat_bu" id="" class="form-control" cols="30" rows="10" placeholder="Alamat Perusahaan"
              required>{{ old('alamat_bu') }}</textarea>
              {!! $errors->first('alamat_bu', '<p class="" style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Kecamatan <span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" name="kecamatan" class="form-control" id="" value="{{ old('kecamatan') }}" placeholder="Kecamatan" required>
            {!! $errors->first('kecamatan', '<p class="" style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Kota <span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" name="kota" class="form-control" id="" value="{{ old('kota') }}" placeholder="Kota" required>
            {!! $errors->first('kota', '<p class="" style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Kode Pos <span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="number"  name="kd_pos" class="form-control" id="" value="{{ old('kd_pos') }}" placeholder="Kode Pos" required>
            {!! $errors->first('kd_pos', '<p class="" style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">No Telp <span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="number" name="no_telp" class="form-control" id="" value="{{ old('no_telp') }}" placeholder="No Telp" required>
            {!! $errors->first('no_telp', '<p class="" style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">No Fax </label>
          <div class="col-sm-9">
            <input type="number"   name="no_fax" class="form-control" id="" value="{{ old('no_fax') }}" placeholder="No Fax">
            {!! $errors->first('no_fax', '<p class="" style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Website</label>
          <div class="col-sm-9">
            <input type="text" name="website" class="form-control" id="" value="{{ old('website') }}" placeholder="Website">
            {!! $errors->first('website', '<p class="" style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-3">
            <button id="send" type="submit" class="btn btn-success">Simpan Data Badan Usaha</button>
          </div>
        </div>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
        @endforeach
        @endif

      </form>
    </div>
  </div>
</div>
@endsection