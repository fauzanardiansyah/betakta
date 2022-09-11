@extends('backend/dpn/base.main-page')
@section('title','Download KTA Anggota')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Download Kartu Tanda Anggota</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="copy-of-kta" class="table" aria-describedby="datatable_info">
                            <thead>
                                    <th class="text-center">Nama Badan Usaha</th>
                                    <th class="text-center">Provinsi</th>
                                    <th class="text-center">No KTA</th>
                                    <th class="text-center">Tanggal Pengajuan</th>
                                    <th class="text-center">Kepengurusan</th>
                                    <th class="text-center">Jenis Pengajuan</th>
                                    <th class="text-center">Masa Berlaku</th>
                                    <th class="text-center">Action</th>
                            </thead>
                        </table>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Get all anggota for publish invoice
    $(function() {
        $('#copy-of-kta').DataTable({
          
            processing: true,
            serverSide: true,
            ajax: '{!! route('dpn.download-kta.get') !!}',
    
            columnDefs: [
                { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6 , 7] },
            ],
           
            columns: [
                { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
                { data: 'provinsi', name: 'provinsi.name' },
                { data: 'no_kta', name: 't_kta.no_kta', searchable: false },
                { data: 'waktu_pengajuan', name: 't_detail_kta.waktu_pengajuan'},
                { data: 'lokasi_pengurusan', name: 't_kta.lokasi_pengurusan' },
                { data: 'jenis_pengajuan', name: 't_detail_kta.jenis_pengajuan' },
                { data: 'masa_berlaku', name: 't_detail_kta.masa_berlaku' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>   
@endpush