@extends('backend/anggota/base.main-page')
@section('title','Registrasi Calon Anggota')
@section('content-pages')
<style type="text/css">
  #kualifikasi{
    pointer-events: none !important;  
  }
  #jenis_bu{
    pointer-events: none !important;  
  }
  #provinsi_asal{
    pointer-events: none !important;  
  }
  
</style>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Formulir Pindah DPP</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <form action="{{ route('action_pindah_dpp') }}" enctype="multipart/form-data"  method="POST"
      class="form-horizontal form-label-left">
      @csrf
      <span class="section"></span>
      <div class="item form-group">
        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda bintang(<span
          style="color:red">*</span>) wajib di isi</label>
        </div>
        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status penanaman modal <span
            class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="jenis_bu" class="form-control col-md-7 col-xs-12" id="jenis_bu" readonly required>
              <option value="">--Pilih--</option>
              <option value="pmdn" {{ ($kta->jenis_bu == "pmdn") ? "selected":"" }}>Pemilik Modal Dalam Negeri</option>
              <option value="pma" {{ ($kta->jenis_bu == "pma") ? "selected":"" }}>Pemilik Modal Asing</option>
            </select>
          </div>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="w4-first-name">Kualifikasi <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="kualifikasi" id="kualifikasi" readonly class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="kecil" {{ ($kta->kualifikasi == "kecil") ? "selected":"" }}>Kecil</option>
              <option value="menengah" {{ ($kta->kualifikasi == "menengah") ? "selected":"" }}>Menengah</option>
              <option value="besar" {{ ($kta->kualifikasi == "besar") ? "selected":"" }}>Besar</option>
            </select>
          </div>

        </div>

        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lokasi Pengurusan<span
            class="required"></span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="hidden" name="lokasi_pengurusan" readonly id="lokasi-pengurusan"
            class="form-control col-md-7 col-xs-12 lokasi-pengurusan">
            <input type="text" name="" readonly id="lokasi-pengurusan" value="{{ $kta->lokasi_pengurusan }}" class="form-control col-md-7 col-xs-12 lokasi-pengurusan"
            disabled>
          </div>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inputDisabled"> Provinsi Asal <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="provinsi_asal" readonly id="provinsi_asal" class="form-control col-md-7 col-xs-12" required>
              <option value="">-- Provinsi --</option>
              @foreach ($allDPP as $allDPPRows)
              <option value="{{ $allDPPRows->id }}" {{ ($kta->id_dp == $allDPPRows->id) ? "selected":"" }}>{{ $allDPPRows->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inputDisabled"> Provinsi Tujuan <span class="required">*</span></label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="provinsi_tujuan" id="provinsi-dpp" class="form-control col-md-7 col-xs-12" required>
              <option value="">-- Provinsi --</option>
              @foreach ($allDPP as $allDPPRows)
              <option value="{{ $allDPPRows->id }}" {{ ( old('provinsi_tujuan')  == $allDPPRows->id ) ? "selected" :""  }}>{{ $allDPPRows->name }}</option>
              @endforeach
            </select>
          </div>
        </div>


        <div class="item form-group">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Surat permohonan perpindahan (PDF , 2MB) <span
            class="required">*</span>
          </label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="file" name="surat_permohonan" value="{{  old('surat_permohonan') }}"  id="surat_permohonan" class="form-control col-md-7 col-xs-12 surat_permohonan">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-6 col-md-offset-3">
            <button id="send" type="submit" class="btn btn-sm btn-success">Proses Permohonan</button>
          </div>
        </div>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div style="color:red">{{$error}}</div>
        @endforeach
        @endif
      </form>
    </div>
  </div>
</div>
@endsection