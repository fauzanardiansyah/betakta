@extends('backend/anggota/base.main-page')
@section('title','Invoice')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Invoice Terbit</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="show-invoice-agt-datatable" class="" aria-describedby="datatable_info">
                            <thead>
                                    <th class="text-center">Nama Badan Usaha</th>
                                    <th class="text-center">No Invoice</th>
                                    <th class="text-center">Jenis Pengajuan</th>
                                    <th class="text-center">Jumlah Tagihan</th>
                                    <th class="text-center">Status Pembayaran</th>
                                    <th class="text-center">Tgl Cetak</th>
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
// Get anggota wich invoice is published
$(function() {
    $('#show-invoice-agt-datatable').DataTable({
        order: [[ 5, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('anggota.invoice.get-data') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6 ] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'no_invoice', name: 't_invoice_kta.no_invoice' },
            { data: 'jenis_pengajuan', name: 't_invoice_kta.jenis_pengajuan' },
            { data: 'jml_tagihan', name: 't_invoice_kta.jml_tagihan' },
            { data: 'status_pembayaran', name: 't_invoice_kta.status_pembayaran' },
            { data: 'tgl_cetak', name: 't_invoice_kta.tgl_cetak' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush