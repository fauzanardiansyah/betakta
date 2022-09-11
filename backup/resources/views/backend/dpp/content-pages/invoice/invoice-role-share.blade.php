@extends('backend/dpp/base.main-page')
@section('title','Invoice')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Invoice Role Sharing</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="show-invoice-roleshare-datatable" class="" aria-describedby="datatable_info">
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
            <div class="row no-print">
                <div class="col-xs-12">
                    <a href="#" class="btn btn-success pull-left" id="accumulate_inv" ><i class="fa fa-money"></i> Process Payment</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmPaymentRoleSharingForm" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Form Konfirmasi Pembayaran Role Sharing DPN</h4>
            </div>
            <div class="modal-body">
                <form action="" id="save-roleshare-confirmation" enctype="multipart/form-data" method="POST">
                    No Invoice:
                    <ol id="invoice"></ol>
                    Nominal Tagihan:
                    <input type="hidden" id="nominal" class="form-control" name="nominal" placeholder="nominal"
                        value="">
                    <input type="text" id="nominal_disable" class="form-control" value="" disabled>
                    <lable style="display:block" id="nominal-error"></lable>
                    Atas Nama:
                    <input type="text" name="atas_nama" class="form-control" placeholder="atas nama" value="">
                    <lable style="display:block" id="atas-nama-error"></lable>
                    Nama Bank Anda:
                    <input type="text" name="nama_bank_anda" class="form-control" placeholder="nama bank anda" value="">
                    Upload Bukti Transfer:
                    <input type="file" name="upload_bukti_trf" class="form-control" placeholder="nama bank anda"
                        value="">
                    <lable style="display:block" id="nama-bank-anda-error"></lable><br>
                    <div id="id_invoice_kta_div"></div>
                    <input type="submit" value="Confirm My Payment"> <img id="loader"
                        src='{{ asset('assets/images/ajax-spinner.gif') }}' style="display:none;width: 30px;
                        position: relative;
                        top: 10px;">

                    <ul id="message-error"></ul>
                </form>
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
   const table =  $('#show-invoice-roleshare-datatable').DataTable({
        order: [[ 5, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpp.invoice.get-roleshare') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6 ] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'no_invoice', name: 't_invoice_kta.no_invoice' },
            { data: 'jenis_pengajuan', name: 't_invoice_role_share.jenis_pengajuan' },
            { data: 'total_role_share', name: 't_invoice_role_share.total_role_share' },
            { data: 'status_pembayaran', name: 't_invoice_role_share.status_pembayaran' },
            { data: 'tgl_cetak', name: 't_invoice_role_share.tgl_cetak' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#show-invoice-roleshare-datatable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

    $("#accumulate_inv").on("click",function(){
        if ( table.rows( '.selected' ).any() ) {
            $('#confirmPaymentRoleSharingForm').modal('show');
            const oAll = [];
            $('#show-invoice-roleshare-datatable tbody tr.selected').each(function(){
                var pos = table.row(this).index();
                var row = table.row(pos).data();
                oAll.push(row);
            });
            clearIdInvoice();
            clearInvoice();
            displayInvoice(oAll);
            displayIdInvoice(oAll);
            displayNominal(oAll);
        } else {
            Swal.fire({
            type: 'error',
            icon: 'error',
            title: 'Maaf...',
            text: 'Silahkan pilih invoice yang akan di bayarkan',
            })
        }

        
        
            
            
    });

    
});

function displayIdInvoice(oAll) {
    oAll.forEach(invoice => displayIdInvoices(invoice));
}

function displayIdInvoices(invoice) {
    const id_invoice_kta = document.createElement("input");
    id_invoice_kta.type = "hidden";
    id_invoice_kta.name = "id_role_share_accumulation[]";
    id_invoice_kta.setAttribute("value", invoice.id);
    const id_invoice_kta_div = document.getElementById("id_invoice_kta_div");
    id_invoice_kta_div.appendChild(id_invoice_kta);
}

function clearIdInvoice() {
    const invoiceUl = document.getElementById("id_invoice_kta_div");
    invoiceUl.textContent = "";
}

function displayInvoice(oAll) {
    oAll.forEach(invoice => displayInvoices(invoice));
}


function displayInvoices(invoice) {
     const invoiceLi = document.createElement("li");
     invoiceLi.textContent = invoice.no_invoice;

     const invoiceUl = document.getElementById("invoice");
     invoiceUl.appendChild(invoiceLi); 
}   

function clearInvoice() {
    const invoiceUl = document.getElementById("invoice");
    invoiceUl.textContent = "";
}


function displayNominal(oAll) {
const nominalArray = [];
const nominal = oAll.forEach(invoice => nominalArray.push(parseInt(invoice.total_role_share)));
const finalNominal = nominalArray.reduce(function(a,b){
    return a + b
  }, 0);
document.getElementById('nominal').value = finalNominal;
const nominalFormat = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'IDR' }).format(finalNominal)
document.getElementById('nominal_disable').value = nominalFormat;  
}

</script>



<script>
    // Save payment confirmation
    $(document).ready(function(){
        $("#save-roleshare-confirmation").submit(function( event ){
                event.preventDefault();
                const csrf_token = $('meta[name="csrf-token"]').attr('content');
                const formData = new FormData($(this)[0]);
                
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            });
    
                $.ajax({
                    type: 'POST',
                    url: '{!! route('dpp.invoice.roleshare-save') !!}',
                    enctype: 'multipart/form-data',
                    traditional: true,
                    processData: false,
                    contentType: false,
                    data: formData,
                    beforeSend: function(){
                        // Show image container
                        $("#loader").show();
                       
                    },
                    success: function(response) {
                        //console.log(Object.values(response))
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: Object.values(response),
                            }).then(function() {
                                window.location = "/panel/dpp/invoice/invoice-role-share";
                            });
                            $('#save-roleshare-confirmation').trigger("reset");
                    },
    
                   error: function (jqXhr) {
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = '';
                    $.each(errors['errors'], function (index, value) {
                        errorsHtml += "<li><small style='color:red'>" + value + "</small></li>";
                        $('#message-error').html(errorsHtml);
                    });
               },
    
      
                    complete:function(data){
                    // Hide image container
                    $("#loader").hide();
                   
                }
                });
            });
        });
</script>

<script>
    $(document).ready(function(){
      $('#nominal').mask('000.000.000.000.000', {reverse: true});
    });
    
</script>

<script>
    function accumulate_inv() {
            alert( table.rows('.selected').data().length +' row(s) selected' );
        }
</script>
@endpush