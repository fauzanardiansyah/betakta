@extends('backend/dpn/base.main-page')
@section('title','Payment Anggota Afiliasi')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Pembayaran Role Sharing Dewan Pengurus Provinsi</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="payment-role-share-datatable" class="table" aria-describedby="datatable_info">
                            <thead>
                                <th class="text-center">Dewan Pengurus Provinsi</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">Nama Bank</th>
                                <th class="text-center">Tanggal Pembayaran</th>
                                <th class="text-center">Bukti Pembayaran</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Pembayaran -->
<div class="modal fade" id="detail-payment-role-share" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Pembayaran Role Sharing Provinsi</h4>
                <small>Untuk invoice anggota :</small>
            </div>
            <div class="modal-body">
                <div class="x_content">
                    <table class="table" id="detail-roleshare-datatable">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID Inv</th>
                                <th scope="col">Nama Badan Usaha</th>
                                <th scope="col">No Invoice</th>
                                <th scope="col">Tagihan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <img src='{{ asset('assets/images/ajax-spinner.gif') }}' id="loader" style="visibility: hidden;"
                    width='30px' height='30px'>
                <button type="button" id="accept-payment-role-share" class="btn btn-primary"
                    title="Verifikasi Pembayaran">Verifikasi Pembayaran</button>
            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script>
    // Show role sharing payment
    $(function() {
    $('#payment-role-share-datatable').DataTable({
        order: [[ 3, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpn.payment.get-role-share-payment') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4] },
        ],
       
        columns: [
            { data: 'atas_nama', name: 'atas_nama' },
            { data: 'nominal', name: 'nominal'},
            { data: 'nama_bank_anda', name: 'nama_bank_anda'},     
            { data: 'created_at', name: 'created_at' },
            { data: 'upload_bukti_trf', name: 'upload_bukti_trf'},
            { data: 'status', name: 'status'},  
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
<script>
    // Show detail role sharing payment
    $(document).ready(function(){
    $('#payment-role-share-datatable').on('click', '#show-detail-payment', function(){
        $('#detail-payment-role-share').modal('show');
        const csrf_token = $('meta[name="csrf-token"]').attr('content');
        const data_id_role_share = $(this).attr('data-id-role-share');
        $('#accept-payment-role-share').attr('data-id-role-share', data_id_role_share)
        
        
        $('#detail-roleshare-datatable').DataTable({
            destroy: true,
            order: [[ 3, "desc" ]],
            processing: true,
            serverSide: true,
            ajax: {
                url  : '{!! route('dpn.payment.getdetail-role-share-payment') !!}',
                type : "POST",
                data : {_token: csrf_token,'idRoleShareAccumulation' : data_id_role_share}
            },

            columnDefs: [
                { className: 'text-center', targets: [0, 1, 2, 3] },
            ],
        
            columns: [
                { data: 'id', name: 't_invoice_role_share.id' },
                { data: 'nm_bu', name: 't_registrasi_users.nm_bu'},
                { data: 'no_invoice', name: 't_invoice_role_share.no_invoice'},
                { data: 'total_role_share', name: 't_invoice_role_share.total_role_share'},     
            ]
        });
      
        
    });
});
</script>
<script>
    // Accept payment role sharing process
 $(document).ready(function(){
    $('#accept-payment-role-share').click(function(event){
        event.preventDefault();
        const csrf_token  = $('meta[name="csrf-token"]').attr('content');
        const data_id_role_share = $('#accept-payment-role-share').attr('data-id-role-share');
        const table = $('#detail-roleshare-datatable').DataTable();
        const dataTable = table.rows().data()
        const dataArray = [];
        $.each( dataTable, function( key, value ) {
            dataArray.push(value.no_invoice)   
        });
        $.ajax({
				type: 'POST',
				url: '{!! route('dpn.payment.accept-role-share') !!}',
				data: { _token: csrf_token, dataArray: dataArray, idRoleShareAccumulation : data_id_role_share},
                beforeSend: function(){
                    // Show image container
                    $("#loader").css('visibility', 'visible');
                },
				success: function(response) {
                    $("#loader").css('visibility', 'hidden');
                    Swal.fire({
                        type: 'success',
                        title: 'Berhasil',
                        text: 'Pembayaran telah di terima',
                        }).then((result) => {
                            if (result.value) {
                                $('#detail-payment-role-share').modal('toggle'); 
                                $("#payment-role-share-datatable").DataTable().ajax.reload(null, false );
                            }
                            });
                },                
			});
    });
});
</script>
@endpush