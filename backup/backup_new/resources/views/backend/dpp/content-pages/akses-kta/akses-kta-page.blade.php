@extends('backend/dpp/base.main-page')
@section('title','Buka akses KTA anggota')
@section('content-pages')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Akses KTA Anggota</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form id="cari-anggota" data-parsley-validate="" class="form-horizontal form-label-left">
                    <div class="form-group">

                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <input type="text" name="no_kta" id="first-name" required="required"
                                class="form-control col-md-7 col-xs-12"
                                placeholder="Masukan nomor KTA yang tertera pada bukti registrasi">&nbsp;
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-sm btn-danger">Cari Anggota</button>
                            <img src='{{ asset('assets/images/ajax-spinner.gif') }}' id="loader"
                                style="display:none;margin-top:2px;" width='30px' height='30px'>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Anggota</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <form class="form-horizontal form-label-left">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Badan Usahan </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="nm_bu" class="form-control" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nomor KTA </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="no_kta" class="form-control" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi Pengurusan </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="lokasi_pengurusan" class="form-control" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Kualifikasi </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="kualifikasi" class="form-control" disabled="disabled">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Akses </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                           <select class="form-control" name="status_penataran" id="status_penataran">
                               <option value="1">Buka</option>
                               <option value="0">Tutup</option>
                           </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <button type="submit" class="btn btn-primary" id="buka-akses-kta">Proses Akses Kartu Tanda Anggota</button>
                            <img src='{{ asset('assets/images/ajax-spinner.gif') }}' id="loader2"
                            style="display:none;margin-top:2px;" width='30px' height='30px'>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Cari anggota 
        $(document).ready(function(){
           $('#cari-anggota').submit(function(event){
               event.preventDefault();
               const csrf_token = $('meta[name="csrf-token"]').attr('content');
               const no_kta = $('input[name="no_kta"]').val();
           
               $.ajax({
                       type: 'POST',
                       url: '{!! route('dpp.akses.get-data-anggota') !!}',
                       data: { _token: csrf_token, no_kta:no_kta},
                       beforeSend: function(){
                           // Show image container
                           $("#loader").show();
                       },
                       success: function(response) {                    
                                const data = response;                   
                                $('#nm_bu').attr('value', data.registrasi_users.nm_bu)
                                $('#no_kta').attr('value', data.no_kta)
                                $('#lokasi_pengurusan').attr('value', data.lokasi_pengurusan)
                                $('#kualifikasi').attr('value', data.kualifikasi)
                                $('#buka-akses-kta').attr('data-no-kta', data.no_kta)
                       },
                       error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire({
                                type: 'error',
                                title: 'Gagal',
                                text: 'Data Tidak Di Temukan',
                        });
                    },
                                        
                       
                       complete:function(response){
                       // Hide image container
                       $("#loader").hide();
                   }
                   });
           });
       });
</script>

<script>
        // Cari anggota 
            $(document).ready(function(){
               $('#buka-akses-kta').click(function(event){
                   event.preventDefault();
                   const csrf_token = $('meta[name="csrf-token"]').attr('content');
                   const no_kta = $(this).attr('data-no-kta');
                   const status_penataran = $('#status_penataran').val();

                   console.log(status_penataran)
               
                   $.ajax({
                           type: 'POST',
                           url: '{!! route('dpp.akses.enable') !!}',
                           data: { _token: csrf_token, no_kta:no_kta, status_penataran:status_penataran},
                           beforeSend: function(){
                               // Show image container
                               $("#loader2").show();
                           },
                           success: function(response) {                    
                            Swal.fire({
                                    type: 'success',
                                    title: 'Berhasil',
                                    text: 'Akses telah di buka untuk anggota ini.',
                            });
                           },
                           error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire({
                                    type: 'error',
                                    title: 'Gagal',
                                    text: 'Data Tidak Di Temukan',
                            });
                        },
                                            
                           
                           complete:function(response){
                           // Hide image container
                           $("#loader2").hide();
                       }
                       });
               });
           });
    </script>
@endpush