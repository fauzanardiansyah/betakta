@extends('administrator/base.home-page')
@section('title', 'Form add testimonials')
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
                    <h5 class="card-title">Form tambah FAQ</h5>
                    <form action="{{ route('administrator.cms.frontend-add-faq-process') }}" method="POST"
                        class="">
                        @csrf @method('post')
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Pertanyaan</label>
                            <input name="question" id="exampleEmail" placeholder="Pertanyaan" type="text" class="form-control">
                            {!! $errors->first('question', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                        </div>
                        <div class="position-relative form-group"><label for="examplePassword"
                                class="">Jawaban</label>
                                <textarea name="answer" class="form-control" id="answer" cols="30" placeholder="Jawaban" rows="10"></textarea>
                                {!! $errors->first('answer', '<p class=""
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
<script>
 CKEDITOR.replace( 'answer' );
</script>
@endpush