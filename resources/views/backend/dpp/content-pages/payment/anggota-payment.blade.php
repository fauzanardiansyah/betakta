@extends('backend/dpp/base.main-page')
@section('title','Payment Anggota')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Payment Anggota</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="payment-agt-datatable" class="table"
                            aria-describedby="datatable_info">
                            <thead>
                                <th class="text-center">Nama Badan Usaha</th>
                                <th class="text-center">No Invoice</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">Status Pembayaran</th>
                                <th class="text-center">Status Pengajuan</th>
                                <th class="text-center">Tanggal Pembayaran</th>
                                <th class="text-center">Action</th>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detail-payment-anggota" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Pembayaran Anggota</h4>
            </div>
            <div class="modal-body">
                <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left input_mask" id="accept-payment-anggota">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Invoice</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="no_invoice" class="form-control" readonly="readonly"
                                    placeholder="Disabled Input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Transfer Atas Nama</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="atas_nama" class="form-control" readonly="readonly"
                                    placeholder="Read-Only Input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nominal Transfer<span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input class=" form-control col-md-7 col-xs-12" id="nominal" required="required" type="text"
                                    readonly="readonly">
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Via Bank</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control" id="nama_bank" readonly="readonly"
                                    placeholder="Read-Only Input">
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Bukti Transfer</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <img src="" class="img-responsive" id="bukti-transfer" alt="" srcset="">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <input type="hidden" id="idDetailKta" value="">
                                <input type="hidden" id="idPayment" value="">
                                <button type="submit" id="button_payment" class="btn btn-success">Accept payment</button>
                                <img src='{{ asset('assets/images/ajax-spinner.gif') }}' id="loader" style="display:none;margin-top:2px;"  width='30px' height='30px'>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function() {
    $('#payment-agt-datatable').DataTable({
        order: [[ 5, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpp.payment.getdatapayment') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'no_invoice', name: 't_payment_confirmation.no_invoice' },
            { data: 'nominal', name: 't_payment_confirmation.nominal' },
            { data: 'status_pembayaran', name: 't_invoice_kta.status_pembayaran'},
            { data: 'status_pengajuan', name: 't_app_kta.status_pengajuan'},
            { data: 'created_at', name: 't_payment_confirmation.created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

<script>
    // Get detail payment anggota
    $(document).ready(function(){
    $('#payment-agt-datatable').on('click', '#show-detail-payment', function(){
        
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id_payment = $(this).attr('data-id-payment');
        var id_detail_kta = $(this).attr('data-id-detail-kta');

        console.log(id_detail_kta)

        $.ajax({
				type: 'POST',
				url: '{!! route('dpp.payment.getdetaildatapayment') !!}',
				data: { _token: csrf_token, idPayment: id_payment, id_detail_kta:id_detail_kta},
				success: function(response) {
                    $('#no_invoice').val(response.no_invoice);
                    $('#atas_nama').val(response.atas_nama);
                    $('#nominal').val(response.nominal);
                    $('#nama_bank').val(response.nama_bank_anda);
                    $('#idPayment').val(response.id);
                    $('#idDetailKta').val(id_detail_kta);
                    $('#bukti-transfer').attr('src',  location.protocol+'//'+location.hostname+'/storage/bukti-transfer/'+response.upload_bukti_trf);
                    $('#detail-payment-anggota').modal('show'); 
                    if(response.invoice.status_pembayaran == 1)  
                    {
                        $("#button_payment").hide();
                    }
                    else
                    {
                        $("#button_payment").show();   
                    }
                },
                
			});
    });
});
</script>

<script>
 // Accept payment anggota process
 $(document).ready(function(){
    $('#accept-payment-anggota').submit(function(event){
        event.preventDefault();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id_payment = $('#idPayment').attr('value');
        var idDetailKta = $('#idDetailKta').attr('value');
        $.ajax({
				type: 'POST',
				url: '{!! route('dpp.payment.accept') !!}',
				data: { _token: csrf_token, idPayment: id_payment, idDetailKta:idDetailKta},
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                },
				success: function(response) {
                 
                    Swal.fire({
                        type: 'success',
                        title: 'Berhasil',
                        text: 'Pembayaran telah di terima',
                        
                        });
                      
                        $('#detail-payment-anggota').modal('toggle'); 
                        $("#payment-agt-datatable").DataTable().ajax.reload(null, false );
                  
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