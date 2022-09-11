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
                <a href="{{ route('administrator.cms.frontend-add-testimonials') }}" class="mb-2 mr-2 btn btn-info">Tambah Testimonials <i class="metismenu-icon pe-7s-plus"></i></a>
            <div class="main-card mb-3 card">
                
                
                <div class="card-header">Testimonials
     
                </div>
                <div class="table-responsive">
                
                    <table id="testimonials" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Foto</th>
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
            $('#testimonials').DataTable({
                order: [[ 1, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: '{!! route('administrator.cms.frontend-get-testimonials') !!}',

                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3] },
                ],
            
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'position', name: 'position' },
                    { data: 'profile_picture', name: 'profile_picture' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

<script>

$('#testimonials').on('click','#delete-testimonials', function (event) {
     event.preventDefault()
     const url = $(this).attr('data-id-testi');
     const csrf_token = $('meta[name="csrf-token"]').attr('content');


     Swal.fire({
         title: 'Apakah anda yakin ingin menghapus anggota ini ?',
         text: "Tekan tombol ya jika, yakin",
         type: 'question',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya, Saya ingin menghapus anggota ini!',
         showLoaderOnConfirm: true,
     }).then((result) => {
        if (result.value) {
            window.location.href = url;
            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        }
       
     })
 });
</script>
@endpush