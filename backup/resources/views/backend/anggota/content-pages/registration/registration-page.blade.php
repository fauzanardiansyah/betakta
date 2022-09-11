@extends('backend/anggota/base.main-page')
@section('title','Registrasi Calon Anggota')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Formulir Pendaftaran</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <form action="{{ route('anggota.registration.infoUmumBadanUsaha') }}" method="POST"
        class="form-horizontal form-label-left">
        @csrf
        <span class="section">Informasi Umum Badan Usaha</span>
        <div class="item form-group">
          <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda bintang(<span
              style="color:red">*</span>) wajib di isi</label>
        </div>
        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status Penanaman Modal <span
              class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="jenis_bu" class="form-control col-md-7 col-xs-12" id="jenis-bu" required>
              <option value="">--Pilih--</option>
              <option value="pmdn">Pemilik Modal Dalam Negeri</option>
              <option value="pma">Pemilik Modal Asing</option>
            </select>
          </div>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="w4-first-name">Kualifikasi <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="kualifikasi" id="kualifikasi" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="kecil">Kecil</option>
              <option value="menengah">Menengah</option>
              <option value="besar">Besar</option>
            </select>
          </div>

        </div>

        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lokasi Pengurusan<span
              class="required"></span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="hidden" name="lokasi_pengurusan" id="lokasi-pengurusan"
              class="form-control col-md-7 col-xs-12 lokasi-pengurusan">
            <input type="text" name="" id="lokasi-pengurusan" class="form-control col-md-7 col-xs-12 lokasi-pengurusan"
              disabled>
          </div>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inputDisabled">Provinsi <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="provinsi" id="provinsi-dpp" class="form-control col-md-7 col-xs-12" required>
              <option value="">-- Provinsi --</option>
              @foreach ($allDPP as $allDPPRows)
              <option value="{{ $allDPPRows->id }}">{{ $allDPPRows->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-3">
            <button id="send" type="submit" class="btn btn-sm btn-success">Proses Permohonan</button>
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