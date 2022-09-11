@extends('administrator/base.home-page')
@section('title', 'Form add news')
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
                    <h5 class="card-title">Form Tambah Pemberitahuan</h5>
                    <form action="{{ route('warning.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Title</label>
                            <input name="title" id="exampleEmail" placeholder="Title"  type="text" class="form-control" required>
                            {!! $errors->first('title', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Description</label>
                            <input name="description" id="exampleEmail" placeholder="Description"  type="text" class="form-control" required>
                            {!! $errors->first('title', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Status</label>
                            
                             <select name="status" class="form-control" id="" required>
                                 <option>--Pilih Status--</option>
                                 <option value="aktif">Aktif</option>
                                 <option value="tidak_aktif">Tidak Aktif</option>
                             </select>
                            {!! $errors->first('title', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Foto</label>
                            <input name="image" id="exampleEmail" placeholder="warning" type="file" class="form-control">
                            {!! $errors->first('image', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <button type="submit" class="mt-1 btn btn-primary">Submit</button>
                        <a href="{{ route('warning.index') }}" class="mt-1 btn btn-warning">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
 var editor = CKEDITOR.replace( 'answer' );
 CKFinder.setupCKEditor( editor );
</script>
@endpush