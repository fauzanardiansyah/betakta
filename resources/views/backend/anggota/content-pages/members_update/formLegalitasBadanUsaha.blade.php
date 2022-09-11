@extends('backend/anggota/base.main-page')
@section('title','Form Legalitas Badan Usaha')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Formulir Perubahan Data</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">


      <span class="section">Legalitas Badan Usaha</span>
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
            <a href="#step-3" class="done" isdone="1" rel="3">
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

      <form action="{{ route('anggota.update.legalitasBadanUsaha') }}" method="POST"
      class="form-horizontal form-label-left forms-with-spinner">
      @csrf
      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <h4>Akte Pendirian Badan Usaha</h4>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc">Nomor Akte Pendirian<span class="required">*</span></label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="no_akte" value="{{ $dataLegalitasBu[0]->no_akte }}"
            placeholder="Nomor Akte Pendirian" required="">
          {!! $errors->first('no_akte', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc">Nama Notaris<span class="required">*</span></label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="nm_notaris" value="{{ $dataLegalitasBu[0]->nm_notaris }}"
            placeholder="Nama Notaris" required="">
          {!! $errors->first('nm_notaris', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>


      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc">Tanggal Di Keluarkan<span class="required">*</span></label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="tgl_keluar_akte" value="{{ $dataLegalitasBu[0]->tgl_keluar_akte }}"
            id="w4-cc" required="">
          {!! $errors->first('tgl_keluar_akte', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc">Maksud Dan Tujuan Badan Usaha<span class="required">*</span></label>
        <div class="col-sm-9">
          <textarea name="maksud_tujuan_akte" class="form-control" id="" cols="30" rows="10" placeholder="Maksud dan tujuan badan usaha">{{ $dataLegalitasBu[0]->maksud_tujuan_akte }}</textarea>
          {!! $errors->first('maksud_tujuan_akte', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <h4>Akte Perubahan Badan Usaha (Jika Ada Perubahan)</h4>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <div class="input_fields_wrap_akte">
            <button class="add_field_button_akte btn btn-primary">Add Akte Perubahan</button>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <h4>SK Pendirian Badan Usaha</h4>
        </div>
      </div>


      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Nomor SK Pendirian<span
            class="required">*</span></label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="no_sk_pendirian" value="{{ $dataLegalitasBu[0]->no_sk_pendirian }}"
            placeholder="Nomor SK Pendirian" required>
          {!! $errors->first('no_sk_pendirian', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan <span
            class="required">*</span></label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="tgl_sk_pendirian_keluar"
            value="{{ $dataLegalitasBu[0]->tgl_sk_pendirian_keluar }}" placeholder="Masa Berlaku" required>
          {!! $errors->first('tgl_sk_pendirian_keluar', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>


      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <h4>SK Perubahan Badan Usaha (Jika Ada Perubahan)</h4>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <div class="input_fields_wrap_sk">
            <button class="add_field_button_sk btn btn-primary">Add SK Perubahan</button>
          </div>
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name"></label>
        <div class="col-sm-9">
          <h4>Surat Keterangan Domisili Perusahaan (SKDP)</h4>
        </div>
      </div>


      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Nomor SKDP</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="no_skdp" value="{{ $dataLegalitasBu[0]->no_skdp }}" placeholder="Nomor SKDP">
          {!! $errors->first('no_skdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="penerbit_skdp" value="{{ $dataLegalitasBu[0]->penerbit_skdp }}"
            placeholder="Di Keluarkan Oleh">
          {!! $errors->first('penerbit_skdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan</label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="tgl_keluar_skdp" value="{{ $dataLegalitasBu[0]->tgl_keluar_skdp }}"
            placeholder="Masa Berlaku">
          {!! $errors->first('tgl_keluar_skdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>
      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Masa Berlaku</label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="masa_berlaku_skdp" value="{{ $dataLegalitasBu[0]->masa_berlaku_skdp }}"
            id="" placeholder="Masa Berlaku">
          {!! $errors->first('masa_berlaku_skdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>


      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name"></label>
        <div class="col-sm-9">
          <h4>Surat Ijin Usaha Perdagangan (SIUP)</h4>
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Nomor SIUP</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="no_siup" id="" value="{{ $dataLegalitasBu[0]->no_siup }}"
            placeholder="Nomor SIUP">
          {!! $errors->first('no_siup', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="penerbit_siup" id="" value="{{ $dataLegalitasBu[0]->penerbit_siup }}"
            placeholder="Di Keluarkan Oleh">
          {!! $errors->first('penerbit_siup', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan</label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="tgl_keluar_siup" id="" value="{{ $dataLegalitasBu[0]->tgl_keluar_siup }}"
            placeholder="Tanggal Di Keluarkan">
          {!! $errors->first('tgl_keluar_siup', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Masa Berlaku</label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="masa_berlaku_siup" id=""
            value="{{ $dataLegalitasBu[0]->masa_berlaku_siup }}" placeholder="Masa Berlaku">
          {!! $errors->first('masa_berlaku_siup', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>


      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <h4>Tanda Daftar Perusahaan (TDP)</h4>
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Nomor TDP</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="no_tdp" id="" value="{{ $dataLegalitasBu[0]->no_tdp }}"
            placeholder="Nomor TDP">
          {!! $errors->first('no_tdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="penerbit_tdp" id="" value="{{ $dataLegalitasBu[0]->penerbit_tdp }}"
            placeholder="Di Keluarkan Oleh">
          {!! $errors->first('penerbit_tdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan</label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="tgl_keluar_tdp" id="" value="{{ $dataLegalitasBu[0]->tgl_keluar_tdp }}"
            placeholder="Masa Berlaku">
          {!! $errors->first('tgl_keluar_tdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>
      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Masa Berlaku</label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="masa_berlaku_tdp" id="" value="{{ $dataLegalitasBu[0]->masa_berlaku_tdp }}"
            placeholder="Masa Berlaku">
          {!! $errors->first('masa_berlaku_tdp', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <h4>Nomor Induk Berusaha (NIB)</h4>
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Nomor NIB </label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="no_nib" id="" value="{{ $dataLegalitasBu[0]->no_nib }}"
            placeholder="Nomor NIB">
          {!! $errors->first('no_nib', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="item form-group">
        <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan </label>
        <div class="col-sm-3">
          <input type="date" class="form-control" name="tgl_keluar_nib" id="" value="{{ $dataLegalitasBu[0]->tgl_keluar_nib }}"
            placeholder="Masa Berlaku">
          {!! $errors->first('tgl_keluar_nib', '<p class=""
            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label" for="w4-cc"></label>
        <div class="col-sm-9">
          <div class="input_fields_wrap_kbli">
            <button class="add_field_button_klbi btn btn-primary">Add Nama KBLI Dan No KBLI NIB</button>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <input type="hidden" name="id_form_legalitas_bu" value="{{ $dataLegalitasBu[0]->id }}">
            <input type="hidden" name="id_kta" value="{{ Request::segment(6) }}">
          <button id="send" type="submit" class="btn btn-success">Simpan Perbubahan Legalitas Badan Usaha</button>
        </div>
      </div>


  
  </form>
  </div>
</div>
</div>
@endsection