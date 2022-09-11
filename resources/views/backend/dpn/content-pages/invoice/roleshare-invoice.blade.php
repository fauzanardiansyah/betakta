@extends('backend/dpn/base.main-page')
@section('title','Penerbitan Invoice Role Share Lokal ')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Penerbitan Invoice Role Share Lokal</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="invoice-agt-lokal" class="table" aria-describedby="datatable_info">
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
            <h2>Invoice Role Share Terbit</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="show-invoice-agt-local-published" class="table" aria-describedby="datatable_info">
                            <thead>
                                    <th class="text-center">Nama Badan Usaha</th>
                                    <th class="text-center">No Invoice</th>
                                    <th class="text-center">Jenis Pengajuan</th>
                                    <th class="text-center">Total Role Sharing</th>
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
    $('#invoice-agt-lokal').DataTable({
        order: [[ 5, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpn.invoice.get-anggota') !!}',

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
    $('#show-invoice-agt-local-published').DataTable({
        order: [[ 5, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpn.invoice.get-publish-role-share') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6 ] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'no_invoice', name: 't_invoice_role_share.no_invoice' },
            { data: 'jenis_pengajuan', name: 't_invoice_role_share.jenis_pengajuan' },
            { data: 'total_role_share', name: 't_invoice_role_share.total_role_share' },
            { data: 'status_pembayaran', name: 't_invoice_role_share.status_pembayaran' },
            { data: 'tgl_cetak', name: 't_invoice_role_share.tgl_cetak' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});

    // Publish invoice role share   
	$(document).ready(function(){
		$("#invoice-agt-lokal").on('click', '#publish-roleshare-invoice',function(event){
            event.preventDefault();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var id_detail_kta = $(this).attr('data-id-detail-kta');
            var id_dp = $(this).attr('data-id-dp');

            
			$.ajax({
				type: 'POST',
				url: '{!! route('dpn.invoice.publish-roleshare-invoice') !!}',
				data: { _token: csrf_token, id_detail_kta: id_detail_kta, id_dp: id_dp},
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

                        console.log(response);

                        $("#show-invoice-agt-local-published").DataTable().ajax.reload(null, false );

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
            }
			});
		});
	});
</script>
@endpush