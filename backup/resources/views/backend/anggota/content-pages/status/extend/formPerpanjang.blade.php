@extends('backend/anggota/base.main-page')
@section('title','Form Perpanjangan Kartu Anggota ')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Formulir Perpanjangan Kartu Tanda Anggota</h2>
      <div class="clearfix"></div>
    </div>
    
    <div class="x_content">
        <span class="section">Upload Kartu Tanda Anggota Lama Anda</span>
      <div class="item form-group">
        <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda bintang(<span
            style="color:red">*</span>) wajib di isi</label>
      </div>


      <form action="{{ route('anggota.extend.period') }}" method="POST" class="form-horizontal form-label-left forms-with-spinner"
        enctype="multipart/form-data">
        @csrf
        @method('post')

      
        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">KTA (pdf, 2Mb)</label>
          <div class="col-sm-9">
            <input type="file" class="form-control" name="file_kta" required>
            {!! $errors->first('file_kta', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
          </div>
        </div>

        <div class="item form-group">
          <label class="col-sm-3 control-label" for="w4-first-name">Surat Permohonan Perpanjangan KTA (pdf, 2Mb)</label>
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
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <input type="hidden" name="id_detail_kta" value="{{ Request::segment(4) }}">
              <button id="send" type="submit" class="btn btn-success">Ajukan Perpanjangan</button>
            </div>
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
          <object width="100%" height="500" data="{{ asset('backend/term-and-condition/TERM CONDITION.pdf') }}"></object>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div> 
@endsection