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
                    <h5 class="card-title">Form Edit Berita</h5>
                     <form action="{{ route('warning.update',$warning->id_warning) }}" method="POST"  enctype="multipart/form-data">
                        @csrf 
                        {{ method_field('PUT') }}
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Title</label>
                            <input name="title" id="exampleEmail" placeholder="Title"  type="text" class="form-control" value="{{$warning->title}}" required>
                            {!! $errors->first('title', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Description</label>
                            <input name="description" id="exampleEmail" placeholder="Description" value="{{$warning->description}}"  type="text" class="form-control" required>
                            {!! $errors->first('title', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Status</label>
                            
                             <select name="status" class="form-control" id="" required>
                                 <option>--Pilih Status--</option>
                                 <option value="aktif" {{ ($warning->status=="aktif") ? "selected" :"" }} >Aktif</option>
                                 <option value="tidak_aktif" {{ ($warning->status=="tidak_aktif") ? "selected" :"" }}>Tidak Aktif</option>
                             </select>
                            {!! $errors->first('title', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Foto</label>
                            <img src="{{ asset('storage/warning/'.$warning->image) }}" style="width:150px" alt="" srcset="">
                            <input name="image_update" id="exampleEmail" placeholder="File" type="file" class="form-control">
                            {!! $errors->first('warning', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <button type="submit" class="mt-1 btn btn-primary">Submit</button>
                        <a href="{{ route('warning.index') }}" class="mt-1 btn btn-warning">Cancel</a>

                    </form>

                   {{--  <form action="{{ route('administrator.cms.update-berita-process', ['id' => $news->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Title</label>
                            <input name="title" id="exampleEmail" placeholder="Title"  type="text" value="{{ $news->title }}" class="form-control" required>
                            {!! $errors->first('title', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Cover</label><br>
                            <img src="{{ asset('storage/news-cover/'.$news->cover) }}" style="width:150px" alt="" srcset="">
                            <input name="cover" id="exampleEmail" placeholder="Cover"  type="file" class="form-control">
                            {!! $errors->first('cover', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>

                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Category</label>
                             <select name="id_category" class="form-control" id="" required>
                                 <option>--Pilih Kategori--</option>
                                 @foreach ($category as $category_item)
                                 <option value="{{ $category_item->id }}"  {{ $result = ($news->id_category == $category_item->id) ? "selected" : "" }}>{{ $category_item->nama_category }}</option>
                                 @endforeach
                                 
                             </select>
                            {!! $errors->first('id_category', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <div class="position-relative form-group"><label for="examplePassword"
                                class="">News</label>
                                <textarea name="news" class="form-control" id="answer" cols="30" placeholder="News" rows="10" required>{{ $news->news }}</textarea>
                                {!! $errors->first('news', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <button type="submit" class="mt-1 btn btn-primary">Submit</button>
                    </form> --}}
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