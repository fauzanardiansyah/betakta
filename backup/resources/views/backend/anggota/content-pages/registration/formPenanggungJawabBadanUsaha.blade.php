@extends('backend/anggota/base.main-page')
@section('title','Form Penanggung Jawab Badan Usaha')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Formulir Pendaftaran</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">


      <span class="section">Penanggung Jawab Badan Usaha</span>
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
            <a href="#step-2" class="done" isdone="1" rel="2">
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
      <div class="form-group">
        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda bintang(<span
            style="color:red">*</span>) wajib di isi</label>
      </div>

      <form action="{{ route('anggota.registration.penanggungJawabBadanUsaha') }}" method="POST"
        class="form-horizontal form-label-left" id="simpan-data-pjbu">
        @csrf

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Nama Penanggung Jawab<span
              class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="nm_pjbu" id="w4-username" value="{{ old('nm_pjbu') }}"
              placeholder="Nama Penanggung Jawab" required>
            {!! $errors->first('nm_pjbu', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Kewarganegaraan<span class="required">*</span></label>
          <div class="col-sm-9">
            <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="wni">WNI</option>
              <option value="wna">WNA</option>
            </select>
            {!! $errors->first('kewarganegaraan', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">NIK<span class="required">*</span></label>
          <div class="col-sm-9">
            <input name="nik" id="nik" class="form-control" placeholder="NIK"
              oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
              type="number" maxlength="17" value="{{ old('nik') }}" required />
            {!! $errors->first('nik', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Passport<span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" name="passport" id="passport" class="form-control" value="{{ old('passport') }}"
              placeholder="Passport" required />
            {!! $errors->first('passport', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>


        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Jabatan<span class="required">*</span></label>
          <div class="col-sm-9">
            <select name="jabatan_pjbu" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="1">Direktur</option>
              <option value="2">Direktur Utama</option>
              <option value="3">Presiden Direktur</option>
            </select>
            {!! $errors->first('jabatan_pjbu', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Pendidikan Formal Tertinggi<span
              class="required">*</span></label>
          <div class="col-sm-9">
            <select name="pendidikan_formal_pjbu" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="0">S1</option>
              <option value="1">S2</option>
              <option value="2">S3</option>
              <option value="3">> S3</option>
            </select>
            {!! $errors->first('pendidikan_formal_pjbu', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Tempat, Tanggal Lahir<span
              class="required">*</span></label>
          <div class="col-sm-3">
            <input type="text" class="form-control" name="tempat" value="{{ old('tempat') }}" placeholder="Tempat"
              required>
            {!! $errors->first('tempat', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
          <div class="col-sm-3">
            <input type="date" class="form-control" name="tgl_lahir" value="{{ old('tgl_lahir') }}"
              placeholder="Tanggal Lahir" required>
            {!! $errors->first('tgl_lahir', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>


        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Alamat<span class="required">*</span></label>
          <div class="col-sm-9">
            <textarea class="form-control" name="alamat_pjbu" value="{{ old('alamat_pjbu') }}" placeholder="Alamat"
              required></textarea>
            {!! $errors->first('alamat_pjbu', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Nomor Handphone<span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" data-mask="0000-000-000-000" class="form-control" name="no_hp_pjbu"
              value="{{ old('no_hp_pjbu') }}" placeholder="Nomor Handphone" required>
            {!! $errors->first('no_hp_pjbu', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">Email PJBU<span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="email" class="form-control" name="email_pjbu" value="{{ old('email_pjbu') }}"
              placeholder="Email PJBU" required>
            {!! $errors->first('email_pjbu', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>


        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-username">NPWP PJBU<span class="required">*</span></label>
          <div class="col-sm-9">
            <input type="text" data-mask="00.000.000.0-000.000" max="16" class="form-control npwp" name="no_npwp_pjbu"
              value="{{ old('no_npwp_pjbu') }}" placeholder="NPWP PJBU" required>
            {!! $errors->first('no_npwp_pjbu', '<p class=""
              style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

    </div>
    <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
        <button id="send" type="submit" class="btn btn-success">Simpan Data PJBU</button>
      </div>
    </div>
    </form>
  </div>
</div>
</div>

@endsection