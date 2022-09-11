@extends('backend/dpp/base.main-page')
@section('title','Administrator')
@section('content-pages')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Administrator Dewan Pengurus Provinsi {{ Session::get('nm_dpp') }}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 1%">#</th>
                            <th class="text-center" style="width: 20%">Nama DPP</th>
                            <th class="text-center">Digital Signature</th>
                            <th class="text-center">Nama Ketua Provinsi</th>
                            <th class="text-center">Sekretaris Provinsi</th>
                            <th class="text-center" style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#</td>
                            <td>
                                <a>Dewan pengurus provinsi {{ $dataCouncil->provinsi->name }}</a>
                                <br>
                                <small>DPP {{ $dataCouncil->provinsi->name }}</small>
                            </td>
                            <td>
                                <center>
                                    <ul class="list-inline">
                                        <li>
                                            @if (empty($dataCouncil->ttd_ketua_provinsi))
                                            <small style="color:crimson">No image</small>
                                            @else
                                            <img src="{{ asset('storage/signature/'.$dataCouncil->ttd_ketua_provinsi) }}"
                                                class="avatar img-responsive" alt="Avatar">
                                            <br><br><small>Ttd Ketua Provinsi</small>
                                            @endif
                                        </li>
                                        <li>
                                            @if (empty($dataCouncil->ttd_sekretaris_provinsi))
                                            <small style="color:crimson">No image</small>
                                            @else
                                            <img src="{{ asset('storage/signature/'.$dataCouncil->ttd_sekretaris_provinsi) }}"
                                                class="avatar img-responsive" alt="Avatar">
                                            <br><br><small>Ttd Sekretaris Provinsi</small>
                                            @endif
                                        </li>
                                    </ul>
                                </center>
                            </td>
                            <td class="project_progress">
                                <a>{{ $dataCouncil->nm_ketua_provinsi }}</a>
                            </td>
                            <td>
                                <a>{{ $dataCouncil->nm_sekretaris_provinsi }}</a>
                            </td>
                            <td>
                                <center>
                                    <a href="#" class="btn btn-danger btn-xs" data-toggle="modal"
                                        data-target="#formResetPasswordDpp"><i class="fa fa-edit"></i> Reset pssword
                                    </a>
                                </center>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Administrator Dewan Pengurus Provinsi {{ Session::get('nm_dpp') }}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form class="form-horizontal form-label-left " action="{{ route('dpp.administrator.update') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="wizard_verticle" class="form_wizard wizard_verticle">
                        <ul class="list-unstyled wizard_steps">
                            <li>
                                <a href="#step-11">
                                    <span class="step_no">1</span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-22">
                                    <span class="step_no">2</span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-33">
                                    <span class="step_no">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="#step-44">
                                    <span class="step_no">4</span>
                                </a>
                            </li>
                        </ul>

                        <div id="step-11">

                            <h2 class="StepTitle">Informasi DPP</h2>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Provinsi <span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <select name="provinsi" id="" class="form-control col-md-7 col-xs-12" disabled>
                                        @foreach ($province as $province)
                                        <option value="{{ $province->id }}"
                                            {{ ($province->id === $dataCouncil->id_provinsi) ? "selected='selected'" : "" }}>
                                            {{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Level Kepengaurusan<span
                                        class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <select name="level" id="" class="form-control col-md-7 col-xs-12" disabled>
                                        <option value="">
                                            @if ($dataCouncil->level === 0)
                                            <a>DPP</a>
                                            @elseif($dataCouncil->level === 1)
                                            <a>DPN</a>
                                            @endif
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Nomor Rekening DPP<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="no_rek" class="form-control col-md-7 col-xs-12"
                                        placeholder="Nomor Rekening DPP" value="{{ $dataCouncil->no_rek }}" required>
                                    {!! $errors->first('no_rek', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Kode Bank DPP<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="kode_bank" class="form-control col-md-7 col-xs-12"
                                        placeholder="Kode Bank DPP" value="{{ $dataCouncil->kode_bank }}" required>
                                    {!! $errors->first('kode_bank', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Atas Nama Rekening DPP<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="nm_rek" class="form-control col-md-7 col-xs-12"
                                        placeholder="Nama Bank DPP" value="{{ $dataCouncil->nm_rek }}" required>
                                    {!! $errors->first('nm_rek', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Nama Bank DPP<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="nm_bank" class="form-control col-md-7 col-xs-12"
                                        placeholder="Nama Bank DPP" value="{{ $dataCouncil->nm_bank }}" required>
                                    {!! $errors->first('nm_rek', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Alamat DPP<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="alamat" class="form-control col-md-7 col-xs-12"
                                        placeholder="Alamat DPP" value="{{ $dataCouncil->alamat }}" required>
                                    {!! $errors->first('alamat', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Email DPP<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="email" name="email_dewan_pengurus"
                                        class="form-control col-md-7 col-xs-12" placeholder="Email DPP"
                                        value="{{ $dataCouncil->email_dewan_pengurus }}" required>
                                    {!! $errors->first('email_dewan_pengurus', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">No Telp DPP<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="no_telp_dewan_pengurus"
                                        class="form-control col-md-7 col-xs-12" placeholder="No Telp DPP"
                                        value="{{ $dataCouncil->no_telp_dewan_pengurus }}" required>
                                    {!! $errors->first('file_fno_telp_dewan_pengurusoto_pjbu', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                        </div>
                        <div id="step-22">

                            <h2 class="StepTitle">Penentuan Iuran Keanggotaan</h2>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Iuran Anggota Kelas Kecil
                                    <span class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="iuran_1_thn_kecil" id=""
                                        placeholder="Iuran Anggota  Kecil 1 tahun"
                                        value="{{ $dataCouncil->iuran_1_thn_kecil }}" required>
                                    {!! $errors->first('iuran_1_thn_kecil', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Iuran Anggota Kelas Menengah
                                    <span class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="iuran_1_thn_menengah" id=""
                                        placeholder="Iuran Anggota  Menengah 1 tahun"
                                        value="{{ $dataCouncil->iuran_1_thn_menengah	 }}" required>
                                    {!! $errors->first('iuran_1_thn_menengah', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Iuran Anggota Kelas Besar
                                    <span class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="iuran_1_thn_besar" id=""
                                        placeholder="Iuran Anggota Besar 1 tahun"
                                        value="{{ $dataCouncil->iuran_1_thn_besar }}" required>
                                    {!! $errors->first('iuran_1_thn_besar', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Uang Pangkal
                                    <span class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="uang_pangkal" id=""
                                        placeholder="Uang Pangkal" value="{{ $dataCouncil->uang_pangkal }}" required>
                                    {!! $errors->first('uang_pangkal', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Sumbangan Uang Gedung
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="uang_gedung" id=""
                                        placeholder="Sumbangan Uang Gedung" value="{{ $dataCouncil->uang_gedung }}" required>
                                    {!! $errors->first('uang_gedung', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                            <h2 class="StepTitle">Role Sharing Ke DPN</h2>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Role Sharing Iuran Kelas Kecil
                                    <span class="required" style="color:crimson">*&nbsp;<small>(%)</small></span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="role_share_iuran_kecil" id=""
                                        placeholder="%" value="{{ $dataCouncil->role_share_iuran_kecil }}" required>
                                    {!! $errors->first('role_share_iuran_kecil', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Role Sharing Iuran Kelas
                                    Menengah
                                    <span class="required" style="color:crimson">*&nbsp;<small>(%)</small></span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="role_share_iuran_menengah" id=""
                                        placeholder="%" value="{{ $dataCouncil->role_share_iuran_menengah }}" required>
                                    {!! $errors->first('role_share_iuran_menengah', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Role Sharing Iuran Kelas Besar
                                    <span class="required" style="color:crimson">*&nbsp;<small>(%)</small></span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="role_share_iuran_besar" id=""
                                        placeholder="%" value="{{ $dataCouncil->role_share_iuran_besar }}" required>
                                    {!! $errors->first('role_share_iuran_besar', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Role Sharing Uang Pangkal
                                    <span class="required" style="color:crimson">*&nbsp;<small>(%)</small></span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="number" class="form-control" name="role_share_uang_pangkal" id=""
                                        placeholder="%" value="{{ $dataCouncil->role_share_uang_pangkal }}" required>
                                    {!! $errors->first('role_share_uang_pangkal', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                        </div>
                        <div id="step-33">
                            <h2 class="StepTitle">Pengurus Provinsi</h2>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Nama Ketua Provinsi<span
                                        class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="nm_ketua_provinsi" class="form-control col-md-7 col-xs-12"
                                        placeholder="Nama Ketua Provinsi" value="{{ $dataCouncil->nm_ketua_provinsi }}"
                                        required>
                                    {!! $errors->first('nm_ketua_provinsi', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Nama Sekretaris
                                    Provinsi<span class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="text" name="nm_sekretaris_provinsi"
                                        class="form-control col-md-7 col-xs-12"
                                        value="{{ $dataCouncil->nm_sekretaris_provinsi }}" placeholder="Nama Sekretaris"
                                        required>
                                    {!! $errors->first('nm_sekretaris_provinsi', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3" for="first-name">Foto Profile DPP <br> <small>(jpg 2Mb)</small><span class="required" style="color:crimson">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" name="foto_profile_dpp"
                                            class="form-control col-md-7 col-xs-12"
                                            value="{{ $dataCouncil->foto_profile_dpp }}" placeholder="Foto Profile DPP"
                                            required>
                                        {!! $errors->first('foto_profile_dpp', '<p class=""
                                            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                        </p>') !!}
                                    </div>
                                </div>
                        </div>
                        <div id="step-44">
                            <h2 class="StepTitle">Digital Signature Pengurus Provinsi</h2>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Ttd Ketua provinsi
                                    <br><small>(2Mb .PNG)</small><span class="required" style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" value="" name="ttd_ketua_provinsi"
                                        class="form-control col-md-7 col-xs-12" required>
                                    {!! $errors->first('ttd_ketua_provinsi', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3" for="first-name">Ttd Sekretaris
                                    Provinsi <br><small>(2Mb .PNG)</small><span class="required"
                                        style="color:crimson">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="file" value="" name="ttd_sekretaris_provinsi"
                                        class="form-control col-md-7 col-xs-12" required>
                                    {!! $errors->first('ttd_sekretaris_provinsi', '<p class=""
                                        style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message
                                    </p>') !!}
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
        </div>
        </form>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="formResetPasswordDpp" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <div class="modal-body">
                <form action="" id="reset-password-dpp">
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">New Password:</label>
                        <input type="password" name="password" class="form-control" id="recipient-name">

                    </div>
                    <div class="form-group">
                        <label for="message-text" class="form-control-label">Confirm Password:</label>
                        <input type="password" class="form-control" name="password_confirmation">

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-danger">Reset password</button>
                        <img id="loader" src='{{ asset('assets/images/ajax-spinner.gif') }}' style="display:none; width: 30px;
                    position: relative;
                    top: 5px;">

                    
                    </div>

                    <div class="form-group">
                            <p class="alert alert-success" style="display:none" id="alert"></p>
                    </div>

                    <ul id="message-error"></ul>
                </form>
            </div>
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
    // Save payment confirmation
$(document).ready(function(){
    $("#reset-password-dpp" ).submit(function( event ){
            event.preventDefault();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var data_input = $(this).serialize();
            
			$.ajax({
				type: 'POST',
				url: '{!! route('dpp.administrator.reset-password') !!}',
				data: { _token: csrf_token,
                     password: $("input[name='password']").val(),
                     password_confirmation: $("input[name='password_confirmation']").val(),
                     },
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                   
                },
				success: function(response) {
                        $('#reset-password-dpp').trigger('reset');
                        $('#alert').show(function(event){
                            $(this).delay(1000).hide(1000)
                        });
                        $('#alert').text(response.success);
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
@endpush