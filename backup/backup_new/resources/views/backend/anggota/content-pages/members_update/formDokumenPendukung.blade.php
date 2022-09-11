@extends('backend/anggota/base.main-page')
@section('title','Form Dokumen Pendukung')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Formulir Perubahan Data</h2>

      <div class="clearfix"></div>
    </div>
    <div class="x_content">

      <span class="section">Upload Dokumen Pendukung</span>
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
            <a href="#step-4" class="done" isdone="1" rel="4">
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


      <form  action="{{ route('anggota.update.dokumen') }}" method="POST" class="form-horizontal form-label-left forms-with-spinner"
        enctype="multipart/form-data">
        @csrf
        @method('post')

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">KTP PJBU (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_ktp_pjbu" id="" >
            <input type="hidden" name="old_file_ktp_pjbu" value="{{ $dataDokumenPendukung->file_ktp_pjbu }}">
            {!! $errors->first('file_ktp_pjbu', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">NPWP PJBU (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_npwp_pjbu" id="" >
            <input type="hidden" name="old_file_npwp_pjbu" value="{{ $dataDokumenPendukung->file_npwp_pjbu }}">
            {!! $errors->first('file_npwp_pjbu', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Pas Foto PJBU (jpeg, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_foto_pjbu" id="" >
            <input type="hidden" name="old_file_foto_pjbu" value="{{ $dataDokumenPendukung->file_foto_pjbu }}">
            {!! $errors->first('file_foto_pjbu', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">NPWP Badan Usaha (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_npwp_bu" id="" >
            <input type="hidden" name="old_file_npwp_bu" value="{{ $dataDokumenPendukung->file_npwp_bu }}">
            {!! $errors->first('file_npwp_bu', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Akte Pendirian & Perubahan Badan Usaha (pdf,
            8Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_akte_pendirian_perubahan_bu" id="" >
            <input type="hidden" name="old_file_akte_pendirian_perubahan_bu" value="{{ $dataDokumenPendukung->file_akte_pendirian_perubahan_bu }}">
            {!! $errors->first('file_akte_pendirian_perubahan_bu', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">SK Pendirian & Perubahan (pdf, 8Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_sk_pendirian_perubahan_bu" id="" >
            <input type="hidden" name="old_file_sk_pendirian_perubahan_bu" value="{{ $dataDokumenPendukung->file_sk_pendirian_perubahan_bu }}">
            {!! $errors->first('file_sk_pendirian_perubahan_bu', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name"> SKDP (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_skdp_bu" id="" >
            <input type="hidden" name="old_file_skdp_bu" value="{{ $dataDokumenPendukung->file_skdp_bu }}">
            {!! $errors->first('file_skdp_bu', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">SIUP (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_siup" id="" >
            <input type="hidden" name="old_file_siup" value="{{ $dataDokumenPendukung->file_siup }}">
            {!! $errors->first('file_siup', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">TDP (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_tdp" id="" >
            <input type="hidden" name="old_file_tdp" value="{{ $dataDokumenPendukung->file_tdp }}">
            {!! $errors->first('file_tdp', '<p class="" style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
          </div>
        </div>
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">NIB (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_nib">
            <input type="hidden" name="old_file_nib" value="{{ $dataDokumenPendukung->file_nib }}">
            {!! $errors->first('file_nib', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">SIUJK (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_siujk" id="">
            <input type="hidden" name="old_file_siujk" value="{{ $dataDokumenPendukung->file_siujk }}">
            {!! $errors->first('file_siujk', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">KTA Sebelumnya (pdf, 2Mb)<span
            class="required">*</span></label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_kta" required>
            {!! $errors->first('file_kta', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Surat Permohonan Perpanjangan KTA (pdf, 2Mb)<span
            class="required">*</span></label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="surat_permohonan_perpanjang" required>
            {!! $errors->first('surat_permohonan_perpanjang', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name"></label>
          <div class="col-sm-9">
            <div class="checkbox">
              <label class="">
                <div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox"
                    class="flat" style="position: absolute; opacity: 1;" required><ins class="iCheck-helper"
                    style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                </div>&nbsp;Dengan ini saya menyetujui <a href="#" data-toggle="modal" data-target="#tacModal">Term & Condition</a> yang di atur oleh INKINDO
              </label>
            </div>
          </div>
        </div>
        
    </div>
    <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
          <input type="hidden" name="id_form_dokumen_bu" value="{{ $dataDokumenPendukung->id }}">
          <input type="hidden" name="id_kta" value="{{ Request::segment(6) }}">
          <input type="hidden" name="id_detail_kta" value="{{ $dataDokumenPendukung->id_detail_kta }}">
        <button  type="submit" class="btn btn-success">Simpan Perubahan Dokumen Pendukung</button>
      </div>
    </div>
    </form>
  </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="tacModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Term & Condition</h4>
      </div>
      <div class="modal-body">
          <embed src="{{ asset('backend/term-and-condition/TERM CONDITION.pdf') }}#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="500">    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div> 
@endsection