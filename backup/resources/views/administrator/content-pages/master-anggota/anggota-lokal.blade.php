@extends('administrator/base.home-page')
@section('title', 'Master Anggota Lokal')
@section('content-pages')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Master Anggota Lokal
                    <div class="page-title-subheading">Ini merupakan halaman administrator master anggota dengan jenis badan usaha <strong>pemilik modal dalam negeri</strong> & <strong>pemilik modal asing</strong> seluruh provinsi dan pusat.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">Semua Anggota Inkindo
                    
                </div>
                <div class="table-responsive">
                    <table id="master-anggota-lokal" class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Nama BU</th>
                                <th class="text-center">No KTA</th>
                                <th class="text-center">Status Pengajuan</th>
                                <th class="text-center">Status Anggota</th>
                                <th class="text-center">Jenis BU</th>
                                <th class="text-center">Waktu Terbit</th>
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
            $('#master-anggota-lokal').DataTable({
                order: [[ 5, "desc" ]],
                processing: true,
                serverSide: true,
                ajax: '{!! route('administrator.masater-anggota.get-agt-lokal') !!}',

                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6] },
                ],
            
                columns: [
                    { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
                    { data: 'no_kta', name: 't_kta.no_kta' },
                    { data: 'status_pengajuan', name: 't_app_kta.status_pengajuan' },
                    { data: 'status_kta', name: 't_kta.status_kta' },
                    { data: 'jenis_bu', name: 't_kta.jenis_bu' },
                    { data: 'tgl_terbit', name: 't_detail_kta.tgl_terbit' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

<script>
$('#master-anggota-lokal').on('click','#delete-anggota', function (event) {
     event.preventDefault()
     const id_kta = $(this).attr('data-id-kta');
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
        if (result.isConfirmed) {
            console.log('delete');
            $.ajax({
				type: 'POST',
				url: '{!! route('administrator.master-anggota.delete-anggota') !!}',
				data: { _token: csrf_token, id_kta: id_kta},
                beforeSend: function(){
                   
                    allowOutsideClick: () => !Swal.isLoading()
                },
				success: function(response) {
					if(response) {
                        Swal.fire({
                        type: 'success',
                        title: 'Berhasil',
                        text: 'Anggota berhasil di hapus dari database.',
                        
                        })

                        $("#master-anggota-lokal").DataTable().ajax.reload(null, false );

                    } else {
                        Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: 'Anggota gagal di hapus dari database.',
                        
                        })
                    }
                },
                
                errors:function(data){
                 
                        Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: 'Anggota gagal di hapus dari database.',
                        
                        })
                    
                }
			});
        }
        
     })
 });
</script>
@endpush