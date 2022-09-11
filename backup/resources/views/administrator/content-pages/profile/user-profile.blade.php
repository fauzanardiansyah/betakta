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
            <a href="{{ route('administrator.profile.form-add-superadmin') }}" class="mb-2 mr-2 btn btn-info">Tambah Super Admin <i class="metismenu-icon pe-7s-plus"></i></a>
        <div class="main-card mb-3 card">
            
            
            <div class="card-header">Profile Super Admin
 
            </div>
            <div class="table-responsive">
            
                <table id="superadmin" class="align-middle mb-0 table table-borderless table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Foto</th>
                            <th class="text-center">Jabatan</th> 
                            <th class="text-center">Created At</th>
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
            $('#superadmin').DataTable({
                order: [[ 4, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: '{!! route('administrator.profile.get-data-superadmin') !!}',

                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4] },
                ],
            
                columns: [
                    { data: 'nama_admin', name: 'nama_admin' },
                    { data: 'email', name: 'email' },
                    { data: 'foto_profile', name: 'foto_profile' },
                    { data: 'jabatan', name: 'jabatan' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

<script>

$('#superadmin').on('click','#delete-admin', function (event) {
     event.preventDefault()
     const url = $(this).attr('data-id-admin');
   
     Swal.fire({
         title: 'Apakah anda yakin ingin menghapus admin ini ?',
         text: "Tekan tombol ya jika, yakin",
         type: 'question',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Ya, Saya ingin menghapus admin ini!',
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