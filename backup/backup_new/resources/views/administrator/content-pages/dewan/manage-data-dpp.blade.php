@extends('administrator/base.home-page')
@section('title', 'Form Data Pengurus Nasional Inkindo')
@section('content-pages')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Administrator Dewan Pengurus Nasional Inkindo
                    <div class="page-title-subheading">Ini merupakan halaman administrator Dewan Pengurus Nasional
                        Inkindo untuk memanage data mulai dari Akses akun dan data DPN.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="card mb-3 widget-content bg-arielle-smile">
                    <a href="http://"></a>
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <a href="{{ route('administrator.dewan.manage-data-dpp') }}" style="text-decoration: none; color:#fff">
                                <div class="widget-heading">Manage Data DPP</div>
                                <div class="widget-subheading">Mengatur data DPP</div>
                            </a>
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-white"><span><i
                                        class="fa fa-database icon-gradient bg-ripe-malin"> </i></span></div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-6 col-xl-6">
                <div class="card mb-3 widget-content bg-midnight-bloom">
                    <div class="widget-content-wrapper text-white">
                        <div class="widget-content-left">
                            <a href="{{ route('administrator.dewan.manage-akun-dpp') }}"
                                style="text-decoration: none; color:#fff">
                                <div class="widget-heading">Manage Akun DPP</div>
                                <div class="widget-subheading">Mengatur akun akses DPP</div>
                            </a>
    
                        </div>
                        <div class="widget-content-right">
                            <div class="widget-numbers text-white"><span><i class="fa fa-cog icon-gradient bg-mean-fruit">
                                    </i></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Semua Dewan Pengurus Provinsi Inkindo</h5>
                    <a href="{{ route('administrator.dewan.form-add-data-dpp') }}" class="mb-2 mr-2 btn btn-alternate">Tambah Data Pengurus Provinsi</a>
                    <table id="dewan-pengurus-provinsi" class="mb-0 table">
                        <thead>
                        <tr>
                            <th>Dewan Provinsi</th>
                            <th>Email Pengurus</th>
                            <th>Action</th>
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
        $('#dewan-pengurus-provinsi').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('administrator.dewan.get-council-dpp') !!}',

            columnDefs: [
                { className: 'text-center', targets: [0, 1, 2] },
            ],
        
            columns: [
                { data: 'name', name: 'provinsi.name' },
                { data: 'email_dewan_pengurus', name: 't_dp.email_dewan_pengurus' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>


<script>
        $('#dewan-pengurus-provinsi').on('click','#remove-dpp', function (event) {
            event.preventDefault()
            const url = $(this).attr('data-id-dpp');
    

            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus data pengurus ini ?',
                text: "Tekan tombol ya jika, yakin",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Saya ingin menghapus data pengurus ini!',
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