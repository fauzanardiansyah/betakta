@extends('administrator/base.home-page')
@section('title', 'Form edit testimonials')
@section('content-pages')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Content Management System
                    <div class="page-title-subheading">Ini merupakan halaman administrator <strong>Content Management
                            System</strong> KTA ONLINE.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Form ubah testimonials</h5>
                    <form action="{{ route('administrator.cms.frontend-update-testimonials', ['id' => $testimonials->id]) }}" method="POST"
                        class="" enctype="multipart/form-data">
                        @csrf @method('post')
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Nama</label>
                            <input name="nama" id="exampleEmail" placeholder="Nama" type="text" value="{{ $testimonials->name }}" class="form-control">
                            {!! $errors->first('nama', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Foto</label><br>
                            <img src="{{ asset('storage/foto-testimonial/'.$testimonials->profile_picture) }}" style="width:100px" alt="" srcset="">
                            <input name="foto_profile" id="exampleEmail" placeholder="Nama"  type="file" class="form-control">
                            {!! $errors->first('foto_profile', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <div class="position-relative form-group"><label for="examplePassword"
                                class="">Jabatan</label><input name="jabatan" value="{{ $testimonials->position }}" id="examplePassword" placeholder="Jabatan"
                                type="text" class="form-control">
                                {!! $errors->first('jabatan', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <div class="position-relative form-group"><label for="exampleSelect"
                                class="">Testimonials</label>
                            <textarea name="testimonials" id="exampleText" placeholder="Testimonials"
                                class="form-control">{{ $testimonials->message }}"</textarea>
                                {!! $errors->first('testimonials', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <button type="submit" class="mt-1 btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')

@endpush