@extends('backend/anggota/base.main-page')
@section('title','Form Pemberhentian Kartu Anggota ')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Form Pemberhentian Ke Anggotaan Inkindo</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i
                            class="fa fa-wrench"></i></a>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <form class="form-horizontal form-label-left forms-with-spinner" action="{{ route('anggota.stop.membership') }}" method="POST" enctype="multipart/form-data" >
                @csrf @method('POST')
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Dokumen Pernyataan Berhenti (pdf, 2Mb)<span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  class="form-control col-md-7 col-xs-12"  name="dokumen_pemberhentian" placeholder="both name(s) e.g Jon Doe"
                             type="file" required>
                            {!! $errors->first('dokumen_pemberhentian', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
                    </div>
                </div>
              
                <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Keterangan Berhenti <span
                            class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea  name="keterangan"
                            class="form-control col-md-7 col-xs-12" required></textarea>
                            {!! $errors->first('keterangan', '<p class="" style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <input type="hidden" name="id_detail_kta" value="{{ Request::segment(4) }}">
                        <input type="hidden" name="id_kta" value="{{ $getIdKta->id_kta }}">
                        <button  type="submit" class="btn btn-danger"><i class="fa fa-close"></i> Berhenti Menjadi Anggota Inkindo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection