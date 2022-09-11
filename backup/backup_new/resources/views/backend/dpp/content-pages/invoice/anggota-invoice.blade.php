@extends('backend/dpp/base.main-page')
@section('title','Master Anggota Baru')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Penerbitan Invoice Anggota</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="invoice-agt-datatable" class="table" aria-describedby="datatable_info">
                            <thead>
                                <th class="text-center">Nama Badan Usaha</th>
                                <th class="text-center">Nama PJBU</th>
                                <th class="text-center">Jenis Pengajuan</th>
                                <th class="text-center">Status Pengajuan</th>
                                <th class="text-center">Kualifikasi</th>
                                <th class="text-center">Waktu Pengajuan</th>
                                <th class="text-center">Action</th>
                            </thead>
                        </table>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

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
                        <table id="show-invoice-agt-datatable" class="table" aria-describedby="datatable_info">
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

<!-- Image loader -->
<div id='loader' style='display: none;' >
    <img src='{{ asset('assets/images/ajax-spinner.gif') }}' style="position:absolute; top:50%; left:50%" width='60px' height='60px'>
</div>
<!-- Image loader -->
@endsection
@push('scripts')
<script>
// Get all anggota for publish invoice
$(function() {
    $('#invoice-agt-datatable').DataTable({
        order: [[ 5, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpp.invoice.get-anggota') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6 ] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'nm_pjbu', name: 't_pj_kta.nm_pjbu' },
            { data: 'jenis_pengajuan', name: 't_invoice_kta.jenis_pengajuan', searchable: false },
            { data: 'status', name: 't_app_kta.status_pengajuan'},
            { data: 'kualifikasi', name: 't_kta.kualifikasi' },
            { data: 'waktu_pengajuan', name: 't_detail_kta.waktu_pengajuan' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
// Get anggota wich invoice is published
$(function() {
    $('#show-invoice-agt-datatable').DataTable({
        order: [[ 5, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpp.invoice.get-publish-anggota') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6 ] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'no_invoice', name: 't_invoice_kta.no_invoice' },
            { data: 'jenis_pengajuan', name: 't_invoice_kta.jenis_pengajuan', searchable: false },
            { data: 'jml_tagihan', name: 't_invoice_kta.jml_tagihan' },
            { data: 'status_pembayaran', name: 't_invoice_kta.status_pembayaran' },
            { data: 'tgl_cetak', name: 't_invoice_kta.tgl_cetak' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});

// Post ajax for invoice anggota
	$(document).ready(function(){
		$("#invoice-agt-datatable").on('click', '#publish-member-invoice',function(event){
            event.preventDefault();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var id_detail_kta = $(this).attr('data-id-detail-kta');
            
			$.ajax({
				type: 'POST',
				url: '{!! route('dpp.invoice.publish-anggota') !!}',
				data: { _token: csrf_token, id_detail_kta: id_detail_kta},
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                },
				success: function(response) {
					if(response) {
                        Swal.fire({
                        type: 'success',
                        title: 'Berhasil',
                        text: 'Invoice berhasil di terbitkan untuk anggota ini',
                        
                        })

//console.log(response);

                        $("#show-invoice-agt-datatable").DataTable().ajax.reload(null, false );
                        // location.reload(true)

                    } else {
                        Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: 'Invoice gagal di terbitkan untuk anggota ini',
                        
                        })
                    }
                },
                
                complete:function(data){
                // Hide image container
                $("#loader").hide();
                // location.reload(true)
            }
			});
		});
	});
</script>
@endpush