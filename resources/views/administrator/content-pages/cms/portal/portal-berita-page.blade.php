@extends('administrator/base.home-page')
@section('title', 'CMS Frontend Management System')
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
                    <div class="page-title-subheading">Ini merupakan halaman administrator <strong>Content Management System</strong> KTA ONLINE.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('administrator.cms.form-tambah') }}" class="mb-2 mr-2 btn btn-info">Tambah Berita <i class="metismenu-icon pe-7s-plus"></i></a>
        <div class="main-card mb-3 card">
            
            
            <div class="card-header">Manajemen Berita KTA Online Inkindo
 
            </div>
            <div class="table-responsive">
            
                <table id="portal-berita" class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Title</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Images</th>
                            <th class="text-center">Date Post</th> 
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
        </div>
    </div>
    </div>
    
</div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#portal-berita').DataTable({
                order: [[ 4, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: '{!! route('administrator.cms.portal-get-data') !!}',

                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4] },
                ],
            
                columns: [
                    { data: 'title', name: 'name' },
                    { data: 'nama_category', name: 'category.nama_category' },
                    { data: 'cover', name: 'cover' },
                    { data: 'date', name: 'date' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

<script>

$('#portal-berita').on('click','#delete-news', function (event) {
     event.preventDefault()
     const url = $(this).attr('data-id-news');
     const csrf_token = $('meta[name="csrf-token"]').attr('content');


     Swal.fire({
         title: 'Apakah anda yakin ingin menghapus berita ini ?',
         text: "Tekan tombol ya jika, yakin",
         type: 'question',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya, Saya ingin menghapus berita ini!',
         showLoaderOnConfirm: true,
     }).then((result) => {
        if (result.value) {
            window.location.href = url;
            Swal.fire(
            'Deleted!',
            'Your data has been deleted.',
            'success'
            )
        }
       
     })
 });
</script>
@endpush