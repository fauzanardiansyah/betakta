@extends('backend/dpn/base.main-page')
@section('title','Payment Anggota Afiliasi')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Payment Anggota Afiliasi</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="payment-afiliasi-datatable" class="table"
                            aria-describedby="datatable_info">
                            <thead>
                                <th class="text-center">Nama Badan Usaha</th>
                                <th class="text-center">No Invoice</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">Status Pembayaran</th>
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


{{-- <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Penerbitan Kartu Tanda Anggota Afiliasi</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="afiliasi-final-datatable" class="table"
                            aria-describedby="datatable_info">
                            <thead>
                                <th class="text-center">Nama Badan Usaha</th>                  
                                <th class="text-center">No KTA</th>
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
</div> --}}

<!-- Modal Detail Pembayaran -->
<div class="modal fade" id="detail-payment-afiliasi" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Pembayaran Anggota Afiliasi</h4>
            </div>
            <div class="modal-body">
                <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left input_mask" id="accept-payment-afiliasi">

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
                                <button type="submit" class="btn btn-success">Accept payment</button>
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



<!-- Modal Form Input KTA number -->
{{-- <div class="modal fade" id="form-input-no-kta" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Masukan Nomor Kartu Tanda Anggota Baru</h4>
            </div>
            <div class="modal-body">
                <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left input_mask" id="publish-kta-afiliasi">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No KTA</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="no_kta_baru" name="no_kta_baru" value="" class="form-control"
                                    placeholder="Input Nomor Kta Baru">
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                <input type="hidden" name="id_detail_kta" id="idDetailKta2">
                                <button type="submit" class="btn btn-success">Publish Kartu Tanda Anggota</button>
                                <img src='{{ asset('assets/images/ajax-spinner.gif') }}' id="loader2" style="display:none;margin-top:2px;"  width='30px' height='30px'>
                            </div>
                        </div>

                        <ul id="message-error"></ul>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div> --}}

@endsection
@push('scripts')
<script>
    $(function() {
    $('#payment-afiliasi-datatable').DataTable({
        order: [[ 4, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpn.payment.get-anggota-afiliasi') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'no_invoice', name: 't_payment_confirmation.no_invoice' },
            { data: 'nominal', name: 't_payment_confirmation.nominal' },
            { data: 'status_pembayaran', name: 't_invoice_kta.status_pembayaran'},
            { data: 'created_at', name: 't_payment_confirmation.created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
<script>
    // Get detail payment anggota
    $(document).ready(function(){
    $('#payment-afiliasi-datatable').on('click', '#show-detail-payment', function(){
        
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id_payment = $(this).attr('data-id-payment');
        var id_detail_kta = $(this).attr('data-id-detail-kta');

      

        $.ajax({
				type: 'POST',
				url: '{!! route('dpn.payment.getdetail-data-payment') !!}',
				data: { _token: csrf_token, idPayment: id_payment, id_detail_kta:id_detail_kta},
				success: function(response) {
                    $('#no_invoice').val(response.no_invoice);
                    $('#atas_nama').val(response.atas_nama);
                    $('#nominal').val(response.nominal);
                    $('#nama_bank').val(response.nama_bank_anda);
                    $('#idPayment').val(response.id);
                    $('#idDetailKta').val(id_detail_kta);
                    $('#bukti-transfer').attr('src',  location.protocol+'//'+location.hostname+'/storage/bukti-transfer/'+response.upload_bukti_trf);
                    $('#detail-payment-afiliasi').modal('show'); 
                },
                
			});
    });
});
</script>
<script>
 // Accept payment anggota process
 $(document).ready(function(){
    $('#accept-payment-afiliasi').submit(function(event){
        event.preventDefault();
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var id_payment = $('#idPayment').attr('value');
        var idDetailKta = $('#idDetailKta').attr('value');
        $.ajax({
				type: 'POST',
				url: '{!! route('dpp.payment.accept-afiliasi') !!}',
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
                      
                        $('#detail-payment-afiliasi').modal('toggle'); 
                        $("#payment-afiliasi-datatable").DataTable().ajax.reload(null, false );
                        $("#payment-agt-datatable").DataTable().ajax.reload(null, false );


                  
                },
                
                
			});
    });
});
</script>

<script>
    // $(function() {
    //     $('#afiliasi-final-datatable').DataTable({
    //         order: [[ 4, "desc" ]],
    //         processing: true,
    //         serverSide: true,
    //         ajax: '{!! route('dpn.kta.get-afiliasi-kta') !!}',
    
    //         columnDefs: [
    //             { className: 'text-center', targets: [0, 1, 2, 3, 4, 5] },
    //         ],
           
    //         columns: [
    //             { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
    //             { data: 'no_kta', name: 't_kta.no_kta' },
    //             { data: 'status_pembayaran', name: 't_invoice_kta.status_pembayaran'},
    //             { data: 'status_pengajuan', name: 't_app_kta.status_pengajuan'},
    //             { data: 'created_at', name: 't_payment_confirmation.created_at' },
    //             { data: 'action', name: 'action', orderable: false, searchable: false}
    //         ]
    //     });
    // });
</script>

<script>
    // Show form input KTA number
    // $(document).ready(function(){
    //     $('#afiliasi-final-datatable').on('click', '#publish-kta-afiliasi', function(){

    //         const id_detail_kta = $(this).attr('data-id-detail-kta');
    //         $('#idDetailKta2').attr('value', id_detail_kta);
    //         $('#form-input-no-kta').modal('show'); 


    //     });
    // });
</script>
<script>
//Publish KTA Afliasi
// $(document).ready(function(){
//     $('#publish-kta-afiliasi').submit(function(event){
//         event.preventDefault(event);
//         const csrf_token = $('meta[name="csrf-token"]').attr('content');
//         const id_detail_kta = $('#idDetailKta2').attr('value');
//         const no_kta = $('#no_kta_baru').val();;
        
//         $.ajax({
// 				type: 'POST',
// 				url: '{!! route('dpn.kta.afiliasi-publish') !!}',
// 				data: { _token: csrf_token, id_detail_kta:id_detail_kta, no_kta:no_kta},
// 				beforeSend: function(){
//                     // Show image container
//                     $("#loader2").show();
//                 },

//                 success: function(response) {
//                     //console.log(Object.values(response))
//                     Swal.fire({
//                         type: 'success',
//                         title: 'Berhasil',
//                         text: Object.values(response),
//                         }).then(function() {
//                             window.location = "/panel/dpn/pembayaran/pembayaran-anggota-afiliasi";
//                         });
//                         $('#publish-kta-afiliasi').trigger("reset");
//                 },

//                error: function (jqXhr) {
//                 var errors = jqXhr.responseJSON;
//                 var errorsHtml = '';
//                 $.each(errors['errors'], function (index, value) {
//                     errorsHtml += "<li><small style='color:red'>" + value + "</small></li>";
//                     $('#message-error').html(errorsHtml);
//                 });
//            },

  
//                 complete:function(data){
//                 // Hide image container
//                 $("#loader2").hide();
               
//             }
				
                
// 			});
//     });
// });
</script>
@endpush