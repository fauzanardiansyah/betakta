@extends('administrator/base.home-page')
@section('title', 'Form edit sponsorship')
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
                    <h5 class="card-title">Form edit sponsorship</h5>
                    <form action="{{ route('administrator.cms.frontend-update-sponsorship', ['id' => $sponsorship->id]) }}" method="POST"
                        class="" enctype="multipart/form-data">
                        @csrf @method('post')
                        
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Foto</label><br>
                            <img src="{{ asset('storage/sponsorship/'.$sponsorship->logo_bu) }}" alt="" srcset="">
                            <input name="sponsorship" id="exampleEmail" placeholder="sponsorship" type="file" class="form-control">
                            {!! $errors->first('sponsorship', '<p class=""
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