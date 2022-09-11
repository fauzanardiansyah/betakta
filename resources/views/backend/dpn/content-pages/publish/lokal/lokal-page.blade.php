@extends('backend/dpn/base.main-page')
@section('title','Penerbitan Ulang KTA Anggota')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Penerbitan KTA Anggota Lokal</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="anggota-lokal-final" class="table" aria-describedby="datatable_info">
                            <thead>
                                <th class="text-center">Nama Badan Usaha</th>
                                <th class="text-center">Nama PJBU</th>
                                <th class="text-center">Jenis Pengajuan</th>
                                <th class="text-center">Nomor KTA</th>
                                <th class="text-center">Status Pengajuan</th>
                                <th class="text-center">Kualifikasi</th>
                                <th class="text-center">Jenis BU</th>
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

<!-- Modal Form Input KTA number -->
<div class="modal fade" id="form-input-no-kta" role="dialog">
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
                    <form class="form-horizontal form-label-left input_mask" id="publish-kta-lokal">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No KTA</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" id="no_kta_baru" name="no_kta_baru" value="" class="form-control"
                                    placeholder="Input Nomor Kta">
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
</div>
@endsection
@push('scripts')
<script>
$(function() {
    $('#anggota-lokal-final').DataTable({
        order: [[ 7, "desc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpn.kta.get-lokal-kta') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6, 7 ] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'nm_pjbu', name: 't_pj_kta.nm_pjbu' },
            { data: 'jenis_pengajuan', name: 't_detail_kta.jenis_pengajuan' },
            { data: 'no_kta', name: 't_kta.no_kta' },
            { data: 'status_pengajuan', name: 't_app_kta.status_pengajuan'},
            { data: 'kualifikasi', name: 't_kta.kualifikasi' },
            { data: 'jenis_bu', name: 't_kta.jenis_bu' },
            { data: 'waktu_pengajuan', name: 't_detail_kta.waktu_pengajuan' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
<script>
    // Show form input KTA number
    $(document).ready(function(){
        $('#anggota-lokal-final').on('click', '#show-form-kta-lokal', function(){

            const id_detail_kta = $(this).attr('data-id-detail-kta');
            $('#idDetailKta2').attr('value', id_detail_kta);
            $('#form-input-no-kta').modal('show'); 


        });
    });
</script>
<script>
    //Publish KTA Afliasi
    $(document).ready(function(){
        $('#publish-kta-lokal').submit(function(event){
            event.preventDefault(event);
            const csrf_token = $('meta[name="csrf-token"]').attr('content');
            const id_detail_kta = $('#idDetailKta2').attr('value');
            const no_kta = $('#no_kta_baru').val();;
            
            $.ajax({
                    type: 'POST',
                    url: '{!! route('dpn.kta.lokal-publish') !!}',
                    data: { _token: csrf_token, id_detail_kta:id_detail_kta, no_kta:no_kta},
                    beforeSend: function(){
                        // Show image container
                        $("#loader2").show();
                    },
    
                    success: function(response) {
                        //console.log(Object.values(response))
                        Swal.fire({
                            type: 'success',
                            title: 'Berhasil',
                            text: Object.values(response),
                            }).then(function() {
                                window.location = "/panel/dpn/publish-kta/lokal/penerbitan-lokal-kta";
                            });
                            $(this).trigger("reset");
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
                    $("#loader2").hide();
                   
                }
                    
                    
                });
        });
    });
    </script>
    
@endpush