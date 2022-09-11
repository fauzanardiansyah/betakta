@extends('administrator/base.home-page')
@section('title', 'Master Anggota Lokal')
@section('content-pages')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Master Anggota Lokal
                    <div class="page-title-subheading">Ini merupakan halaman administrator master anggota form edit
                        anggota.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                <span>Administrasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                <span>Penanggung Jawab</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                <span>Legalitas</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-3" data-toggle="tab" href="#tab-content-3">
                <span>Dokumen Pendukung</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-4" data-toggle="tab" href="#tab-content-4">
                <span>Akun</span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Administrasi Badan Usaha</h5>
                    <form action="{{ route('administrator.master-anggota.update-administrasi-bu-lokal') }}"
                        method="POST" class="">
                        @csrf @method('POST')
                        @if (Session::has('successUpdateAnggota'))
                        <div class="alert alert-success fade show" role="alert">Data Administrasi Badan Usaha Berhasil
                            Di Perbaharui.</div>
                        @endif

                        <div class="item form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda
                                bintang(<span style="color:red">*</span>) wajib di isi</label>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Alamat Perusahaan <span
                                    class="required" style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <textarea name="alamat_bu" id="" class="form-control" cols="30" rows="10"
                                    placeholder="Alamat Perusahaan"
                                    required>{{ $dataAdministrasiBu->alamat }}</textarea>
                                {!! $errors->first('alamat_bu', '<p class=""
                                    style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Kode Pos <span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" name="kd_pos" class="form-control" id=""
                                    value="{{ $dataAdministrasiBu->kd_pos }}" placeholder="Kode Pos" required>
                                {!! $errors->first('kd_pos', '<p class=""
                                    style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Kecamatan <span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="kecamatan" class="form-control" id=""
                                    value="{{ $dataAdministrasiBu->kecamatan }}" placeholder="Kecamatan" required>
                                {!! $errors->first('kecamatan', '<p class=""
                                    style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Kota <span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="kota" class="form-control" id=""
                                    value="{{ $dataAdministrasiBu->kota }}" placeholder="Kota" required>
                                {!! $errors->first('kota', '<p class=""
                                    style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">No Telp <span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" name="no_telp" class="form-control" id=""
                                    value="{{ $dataAdministrasiBu->no_telp }}" placeholder="No Telp" required>
                                {!! $errors->first('no_telp', '<p class=""
                                    style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">No Fax </label>
                            <div class="col-sm-9">
                                <input type="number" name="no_fax" class="form-control" id=""
                                    value="{{ $dataAdministrasiBu->no_fax }}" placeholder="No Fax">
                                {!! $errors->first('no_fax', '<p class=""
                                    style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Website</label>
                            <div class="col-sm-9">
                                <input type="text" name="website" class="form-control" id=""
                                    value="{{ $dataAdministrasiBu->website }}" placeholder="Website">
                                {!! $errors->first('website', '<p class=""
                                    style="padding:5px;background:#CE5454; color:cornsilk">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="hidden" name="id_form_administrasi_bu"
                                    value="{{ $dataAdministrasiBu->id }}">
                                <input type="hidden" name="id_detail_kta"
                                    value="{{ $dataAdministrasiBu->id_detail_kta }}">
                                <button id="send" type="submit"
                                    class="mb-2 mr-2 btn-transition btn btn-outline-info">Simpan Perubahan Data Badan
                                    Usaha</button>
                            </div>
                        </div>

                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                        @endforeach
                        @endif

                    </form>
                </div>
            </div>

        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Penanggung Jawab Badan Usaha</h5>
                    <form action="{{ route('administrator.master-anggota.update-penanggung-jawab-bu-lokal') }}"
                        method="POST" class="form-horizontal form-label-left forms-with-spinner">
                        @csrf
                        @if (Session::has('successUpdatePjbu'))
                        <div class="alert alert-success fade show" role="alert">Data Penanggung Jawab Badan Usaha
                            Berhasil
                            Di Perbaharui.</div>
                        @endif


                        <div class="item form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda
                                bintang(<span style="color:red">*</span>) wajib di isi</label>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Nama Penanggung Jawab<span
                                    class="required" style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nm_pjbu" id="w4-username"
                                    value="{{ $dataPjbu->nm_pjbu }}" placeholder="Nama Penanggung Jawab" required>
                                {!! $errors->first('nm_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Kewarganegaraan<span
                                    class="required" style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="wni"
                                        <?php echo $result = ($dataPjbu->kewarganegaraan === 'wni') ? "selected" : ""  ?>>
                                        WNI</option>
                                    <option value="wna"
                                        <?php echo $result = ($dataPjbu->kewarganegaraan === 'wna') ? "selected" : ""  ?>>
                                        WNA</option>
                                </select>
                                {!! $errors->first('kewarganegaraan', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">NIK<span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input name="nik" id="nik" class="form-control" placeholder="NIK"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    type="number" maxlength="17" value="{{ $dataPjbu->nik }}"
                                    <?php  echo $result = (empty($dataPjbu->nik)) ? "disabled" : "" ?> required />
                                {!! $errors->first('nik', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Passport<span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="passport" id="passport" class="form-control"
                                    value="{{ $dataPjbu->no_passport }}"
                                    <?php  echo $result = (empty($dataPjbu->no_passport)) ? "disabled" : "" ?>
                                    placeholder="Passport" required />
                                {!! $errors->first('passport', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Jabatan<span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <select name="jabatan_pjbu" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="0"
                                        <?php echo $result = ($dataPjbu->jabatan === '0') ? "selected" : ""  ?>>Manajer
                                    </option>
                                    <option value="1"
                                        <?php echo $result = ($dataPjbu->jabatan === '1') ? "selected" : ""  ?>>Direktur
                                    </option>
                                    <option value="2"
                                        <?php echo $result = ($dataPjbu->jabatan === '2') ? "selected" : ""  ?>>Direktur
                                        Utama</option>
                                    <option value="3"
                                        <?php echo $result = ($dataPjbu->jabatan === '3') ? "selected" : ""  ?>>
                                        Komisaris</option>
                                </select>
                                {!! $errors->first('jabatan_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Pendidikan Formal Tertinggi<span
                                    class="required" style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <select name="pendidikan_formal_pjbu" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="0"
                                        <?php echo $result = ($dataPjbu->pendidikan === '0') ? "selected" : ""  ?>>S1
                                    </option>
                                    <option value="1"
                                        <?php echo $result = ($dataPjbu->pendidikan === '1') ? "selected" : ""  ?>>S2
                                    </option>
                                    <option value="2"
                                        <?php echo $result = ($dataPjbu->pendidikan === '2') ? "selected" : ""  ?>>S3
                                    </option>
                                    <option value="3"
                                        <?php echo $result = ($dataPjbu->pendidikan === '3') ? "selected" : ""  ?>>> S3
                                    </option>
                                </select>
                                {!! $errors->first('pendidikan_formal_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Tempat, Tanggal Lahir<span
                                    class="required" style="color:red">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="tempat" value="{{ $dataPjbu->tempat }}"
                                    placeholder="Tempat" required>
                                {!! $errors->first('tempat', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_lahir"
                                    value="{{ $dataPjbu->tgl_lahir }}" placeholder="Tanggal Lahir" required>
                                {!! $errors->first('tgl_lahir', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Alamat<span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="alamat_pjbu" placeholder="Alamat"
                                    required>{{ $dataPjbu->alamat }}</textarea>
                                {!! $errors->first('alamat_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Nomor Handphone<span
                                    class="required" style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" data-mask="0000-000-000-000" class="form-control" name="no_hp_pjbu"
                                    value="{{ $dataPjbu->no_hp_pjbu }}" placeholder="Nomor Handphone" required>
                                {!! $errors->first('no_hp_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">Email PJBU<span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email_pjbu"
                                    value="{{ $dataPjbu->email_pjbu }}" placeholder="Email PJBU" required>
                                {!! $errors->first('email_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-username">NPWP PJBU<span class="required"
                                    style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" data-mask="00.000.000.0-000.000" max="16" class="form-control npwp"
                                    name="no_npwp_pjbu" value="{{ $dataPjbu->npwp_pjbu }}" placeholder="NPWP PJBU"
                                    required>
                                {!! $errors->first('no_npwp_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="hidden" name="id_form_pjbu" value="{{ $dataPjbu->id }}">
                                <input type="hidden" name="id_detail_kta"
                                    value="{{ $dataAdministrasiBu->id_detail_kta }}">
                                <button id="send" type="submit"
                                    class="mb-2 mr-2 btn-transition btn btn-outline-info">Simpan Perubahan Data
                                    PJBU</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Legalitas Badan Usaha</h5>
                    <form action="{{ route('administrator.master-anggota.update-legaliats-bu-lokal') }}" method="POST"
                        class="form-horizontal form-label-left forms-with-spinner">
                        @csrf
                        @if (Session::has('successUpdateLegalitasBu'))
                        <div class="alert alert-success fade show" role="alert">Data Legalitas Badan Usaha Berhasil
                            Di Perbaharui.</div>
                        @elseif(Session::has('failUpdateLegalitasBu'))
                        <div class="alert alert-danger fade show" role="alert">Data Penanggung Legalitas Badan Usaha
                            Gagal
                            Di Perbaharui.</div>
                        @endif
                        <div class="item form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12 text-right">Field dengan tanda
                                bintang(<span style="color:red">*</span>) wajib di isi</label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <h4>Akte Pendirian Badan Usaha</h4>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc">Nomor Akte Pendirian<span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="no_akte"
                                    value="{{ $dataLegalitasBu[0]->no_akte }}" placeholder="Nomor Akte Pendirian"
                                    required="">
                                {!! $errors->first('no_akte', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc">Nama Notaris<span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="nm_notaris"
                                    value="{{ $dataLegalitasBu[0]->nm_notaris }}" placeholder="Nama Notaris"
                                    required="">
                                {!! $errors->first('nm_notaris', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc">Tanggal Di Keluarkan<span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_keluar_akte"
                                    value="{{ $dataLegalitasBu[0]->tgl_keluar_akte }}" id="w4-cc" required="">
                                {!! $errors->first('tgl_keluar_akte', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <h4>Akte Perubahan Badan Usaha (Jika Ada Perubahan)</h4>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <div class="input_fields_wrap_akte">
                                    <button class="add_field_button_akte btn btn-primary">Add Akte Perubahan</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <h4>SK Pendirian Badan Usaha</h4>
                            </div>
                        </div>


                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Nomor SK Pendirian<span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="no_sk_pendirian"
                                    value="{{ $dataLegalitasBu[0]->no_sk_pendirian }}" placeholder="Nomor SK Pendirian"
                                    required>
                                {!! $errors->first('no_sk_pendirian', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="penerbit_sk_pendirian"
                                    value="{{ $dataLegalitasBu[0]->penerbit_sk_pendirian }}"
                                    placeholder="Di Keluarkan Oleh" required>
                                {!! $errors->first('penerbit_sk_pendirian', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan <span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_sk_pendirian_keluar"
                                    value="{{ $dataLegalitasBu[0]->tgl_sk_pendirian_keluar }}"
                                    placeholder="Masa Berlaku" required>
                                {!! $errors->first('tgl_sk_pendirian_keluar', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <h4>SK Perubahan Badan Usaha (Jika Ada Perubahan)</h4>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <div class="input_fields_wrap_sk">
                                    <button class="add_field_button_sk btn btn-primary">Add SK Perubahan</button>
                                </div>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name"></label>
                            <div class="col-sm-9">
                                <h4>Surat Keterangan Domisili Perusahaan (SKDP)</h4>
                            </div>
                        </div>


                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Nomor SKDP <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="no_skdp"
                                    value="{{ $dataLegalitasBu[0]->no_skdp }}" placeholder="Nomor SKDP" required>
                                {!! $errors->first('no_skdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="penerbit_skdp"
                                    value="{{ $dataLegalitasBu[0]->penerbit_skdp }}" placeholder="Di Keluarkan Oleh"
                                    required>
                                {!! $errors->first('penerbit_skdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan <span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_keluar_skdp"
                                    value="{{ $dataLegalitasBu[0]->tgl_keluar_skdp }}" placeholder="Masa Berlaku"
                                    required>
                                {!! $errors->first('tgl_keluar_skdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Masa Berlaku<span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="masa_berlaku_skdp"
                                    value="{{ $dataLegalitasBu[0]->masa_berlaku_skdp }}" id=""
                                    placeholder="Masa Berlaku" required>
                                {!! $errors->first('masa_berlaku_skdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name"></label>
                            <div class="col-sm-9">
                                <h4>Surat Ijin Usaha Perdagangan (SIUP)</h4>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Nomor SIUP<span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="no_siup" id=""
                                    value="{{ $dataLegalitasBu[0]->no_siup }}" placeholder="Nomor SIUP" required>
                                {!! $errors->first('no_siup', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="penerbit_siup" id=""
                                    value="{{ $dataLegalitasBu[0]->penerbit_siup }}" placeholder="Di Keluarkan Oleh"
                                    required>
                                {!! $errors->first('penerbit_siup', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan <span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_keluar_siup" id=""
                                    value="{{ $dataLegalitasBu[0]->tgl_keluar_siup }}"
                                    placeholder="Tanggal Di Keluarkan" required>
                                {!! $errors->first('tgl_keluar_siup', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Masa Berlaku<span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="masa_berlaku_siup" id=""
                                    value="{{ $dataLegalitasBu[0]->masa_berlaku_siup }}" placeholder="Masa Berlaku"
                                    required>
                                {!! $errors->first('masa_berlaku_siup', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <h4>Tanda Daftar Perusahaan (TDP)</h4>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Nomor TDP <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="no_tdp" id=""
                                    value="{{ $dataLegalitasBu[0]->no_tdp }}" placeholder="Nomor TDP" required>
                                {!! $errors->first('no_tdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh <span
                                    class="required">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="penerbit_tdp" id=""
                                    value="{{ $dataLegalitasBu[0]->penerbit_tdp }}" placeholder="Di Keluarkan Oleh"
                                    required>
                                {!! $errors->first('penerbit_tdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan <span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_keluar_tdp" id=""
                                    value="{{ $dataLegalitasBu[0]->tgl_keluar_tdp }}" placeholder="Masa Berlaku"
                                    required>
                                {!! $errors->first('tgl_keluar_tdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Masa Berlaku<span
                                    class="required">*</span></label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="masa_berlaku_tdp" id=""
                                    value="{{ $dataLegalitasBu[0]->masa_berlaku_tdp }}" placeholder="Masa Berlaku"
                                    required>
                                {!! $errors->first('masa_berlaku_tdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="w4-cc"></label>
                            <div class="col-sm-9">
                                <h4>Nomor Induk Berusaha (NIB)</h4>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Nomor NIB </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="no_nib" id=""
                                    value="{{ $dataLegalitasBu[0]->no_nib }}" placeholder="Nomor NIB">
                                {!! $errors->first('no_nib', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Di Keluarkan Oleh </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="penerbit_nib" id=""
                                    value="{{ $dataLegalitasBu[0]->penerbit_nib }}" placeholder="Di Keluarkan Oleh">
                                {!! $errors->first('penerbit_nib', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Tanggal Di Keluarkan </label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tgl_keluar_nib" id=""
                                    value="{{ $dataLegalitasBu[0]->tgl_keluar_nib }}" placeholder="Masa Berlaku">
                                {!! $errors->first('tgl_keluar_nib', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-3 control-label" for="w4-first-name">Masa Berlaku</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="masa_berlaku_nib" id=""
                                    value="{{ $dataLegalitasBu[0]->masa_berlaku_nib }}" placeholder="Masa Berlaku">
                                {!! $errors->first('masa_berlaku_nib', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="hidden" name="id_form_legalitas_bu" value="{{ $dataLegalitasBu[0]->id }}">
                                <input type="hidden" name="id_detail_kta"
                                    value="{{ $dataAdministrasiBu->id_detail_kta }}">
                                <button id="send" type="submit"
                                    class="mb-2 mr-2 btn-transition btn btn-outline-info">Simpan Perbubahan Legalitas
                                    Badan Usaha</button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Dokumen Pendukung Badan Usaha</h5>
                    <form action="{{ route('administrator.master-anggota.update-dokumen-bu-lokal') }}" method="POST"
                        class="form-horizontal form-label-left forms-with-spinner" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        @if (Session::has('successUpdateDokumenBu'))
                        <div class="alert alert-success fade show" role="alert">Data Dokumen Badan Usaha Berhasil Di
                            Perbaharui.</div>
                        @elseif(Session::has('failUpdateDokumenBu'))
                        <div class="alert alert-danger fade show" role="alert">Data Dokumen Badan Usaha Gagal Di
                            Perbaharui.</div>
                        @endif

                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">KTP PJBU (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_ktp_pjbu" id="">
                                {!! $errors->first('file_ktp_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">NPWP PJBU (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_npwp_pjbu" id="">
                                {!! $errors->first('file_npwp_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">Pas Foto PJBU (jpeg, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_foto_pjbu" id="">
                                {!! $errors->first('file_foto_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">NPWP Badan Usaha (pdf,
                                2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_npwp_bu" id="">
                                {!! $errors->first('file_npwp_bu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">Izajah PJBU (pdf,
                                2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_ijazah_pjbu" id="">
                                {!! $errors->first('file_ijazah_pjbu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">Akte Pendirian & Perubahan Badan
                                Usaha (pdf,
                                8Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_akte_pendirian_perubahan_bu" id="">
                                {!! $errors->first('file_akte_pendirian_perubahan_bu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">SK Pendirian & Perubahan (pdf,
                                8Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_sk_pendirian_perubahan_bu" id="">
                                {!! $errors->first('file_sk_pendirian_perubahan_bu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name"> SKDP (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_skdp_bu" id="">
                                {!! $errors->first('file_skdp_bu', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">SIUP (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_siup" id="">
                                {!! $errors->first('file_siup', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">TDP (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_tdp" id="">
                                {!! $errors->first('file_tdp', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">NIB (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_nib">
                                <input type="hidden" name="old_nib" value="{{ $dataDokumen->file_nib }}">
                                {!! $errors->first('file_nib', '<p class=""
                                    style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>')
                                !!}
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">KTA Sebelumnya (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_kta">
                                {!! $errors->first('file_kta', '<p class=""
                                    style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>')
                                !!}
                            </div>
                        </div>
                        @if ($dataDokumen->surat_permohonan_baru)
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">Surat Permohonan Buat Baru (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="surat_permohonan_baru">
                                {!! $errors->first('surat_permohonan_baru', '<p class=""
                                    style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>')
                                !!}
                            </div>
                        </div>
                        @endif
                        
                        @if ($dataDokumen->surat_permohonan_daftar_ulang)
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">Surat Permohonan Daftar Ulang (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="surat_permohonan_daftar_ulang">
                                {!! $errors->first('surat_permohonan_daftar_ulang', '<p class=""
                                    style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>')
                                !!}
                            </div>
                        </div> 
                        @endif
                        
                        @if ($dataDokumen->surat_permohonan_perpanjang)
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">Surat Permohonan Perpanjang (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="surat_permohonan_perpanjang">
                                {!! $errors->first('surat_permohonan_perpanjang', '<p class=""
                                    style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>')
                                !!}
                            </div>
                        </div>
                        @endif
                        @if ($dataDokumen->dokumen_pemberhentian)
                        <div class="item form-group">
                            <label class="col-sm-9 control-label" for="w4-first-name">Surat Pemberhentian (pdf, 2Mb)</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="dokumen_pemberhentian">
                                {!! $errors->first('dokumen_pemberhentian', '<p class=""
                                    style="margin-top:3px;background:#CE5454; color:cornsilk;padding:5px">:message</p>')
                                !!}
                            </div>
                        </div>
                        @endif
                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="hidden" name="id_form_dokumen_bu" value="{{ $dataDokumen->id }}">
                                <input type="hidden" name="id_detail_kta" value="{{ $dataDokumen->id_detail_kta }}">
                                <button type="submit" class="mb-2 mr-2 btn-transition btn btn-outline-info">Simpan
                                    Perubahan Dokumen
                                    Pendukung</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-4" role="tabpanel">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Akun Badan Usaha</h5>
                    <form action="{{ route("administrator.master-anggota.update-akun-bu-lokal") }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input name="npwp_bu" class="form-control input" placeholder="NPWP Badan Usaha"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                type="text" maxlength="17" value="{{ $akun->npwp_bu }}" data-mask="00.000.000.0-000.000"
                                required>

                        </div>
                        <div class="form-group">
                            <input type="email" name="email_bu" value="{{ $akun->email_bu }}"
                                placeholder="Email Badan Usaha" class="form-control input" required>

                        </div>
                        <div class="form-group">
                            <input type="text" name="nm_bu" value="{{ $akun->nm_bu }}" placeholder="Nama Badan Usaha"
                                class="form-control" required>

                        </div>
                        <div class="form-group">
                            <select name="bentuk_bu" id="" class="form-control" required>
                                <option value="">--Bentuk Badan Usaha--</option>
                                <option value="pt" {{ $result = ($akun->bentuk_bu == 'pt') ? "selected" : "" }}>PT
                                </option>
                                <option value="cv" {{ $result = ($akun->bentuk_bu == 'cv') ? "selected" : "" }}>CV
                                </option>
                                <option value="kjpp" {{ $result = ($akun->bentuk_bu == 'kjpp') ? "selected" : "" }}>KJJP
                                </option>
                                <option value="firma" {{ $result = ($akun->bentuk_bu == 'firma') ? "selected" : "" }}>
                                    Firma</option>
                                <option value="representative Office"
                                    {{ $result = ($akun->bentuk_bu == 'representative Office') ? "selected" : "" }}>
                                    Representative Office</option>
                                <option value="koprasi"
                                    {{ $result = ($akun->bentuk_bu == 'koprasi') ? "selected" : "" }}>Koprasi</option>
                                <option value="lainya" {{ $result = ($akun->bentuk_bu == 'lainya') ? "selected" : "" }}>
                                    Lainya</option>
                            </select>


                        </div>

                        <div class="form-group">
                            <select name="status_bu" id="" class="form-control" required>
                                <option value="">--Status Badan Usaha--</option>
                                <option value="pusat" {{ $result = ($akun->status_bu == 'pusat') ? "selected" : "" }}>
                                    pusat</option>
                                <option value="cabang" {{ $result = ($akun->status_bu == 'cabang') ? "selected" : "" }}>
                                    cabang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="t_registrasi_users_id" value="{{ $akun->id }}" id="">
                            <button id="send" type="submit" class="mb-2 mr-2 btn-transition btn btn-outline-info">Simpan Perubahan Data Akun</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
  $('#kewarganegaraan').on('change', function () {
    const kewarganegaraan = $(this).find(":selected").val();

    if (kewarganegaraan == "wni") {
      $('#passport').attr('disabled', 'disabled')
      $('#passport')
      $('#nik').removeAttr('disabled');
    } else {
      $('#nik').attr('disabled', 'disabled');
      $('#passport').removeAttr('disabled');
    }
  });
});
</script>

<script>
    $(document).ready(function () {
  var max_fields = 10; //maximum input boxes allowed
  var wrapper = $(".input_fields_wrap_akte"); //Fields wrapper
  var add_button = $(".add_field_button_akte"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function (e) { //on add input button click
    e.preventDefault();
    if (x < max_fields) { //max input box allowed
      x++; //text box increment
      $(wrapper).append(`
          <br>
          <div class="form-group">
                <label class="col-sm-9 control-label" for="w4-cc">Nomor Akte Perubahan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="no_akte_perubahan[]" id="w4-cc" placeholder="Nomor Akte Perubahan" >
                </div>
            </div>

            <div class="form-group">
                    <label class="col-sm-9 control-label" for="w4-cc">Nama Notaris Perubahan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nm_notaris_perubahan[]" id="w4-cc" placeholder="Nama Notaris" >
                    </div>
            </div>


            <div class="form-group">
                    <label class="col-sm-9 control-label" for="w4-cc">Tanggal Akte Perubahan Di Keluarkan</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="tgl_akte_perubahan_keluar[]" id="w4-cc" >
                    </div>
            </div>
           
          `); //add input box
    }
  });

});




$(document).ready(function () {
  var max_fields = 10; //maximum input boxes allowed
  var wrapper = $(".input_fields_wrap_sk"); //Fields wrapper
  var add_button = $(".add_field_button_sk"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function (e) { //on add input button click
    e.preventDefault();
    if (x < max_fields) { //max input box allowed
      x++; //text box increment
      $(wrapper).append(`
              <br>
              <div class="item form-group">
              <label class="col-sm-9 control-label" for="w4-first-name">Nomor Perubahan Pengesahan</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="no_sk_perubahan[]" id="" placeholder="Nomor Perubahan Pengesahan" >
              </div>
            </div>

            <div class="item form-group">
                    <label class="col-sm-9 control-label" for="w4-first-name">Perubahan Di Keluarkan Oleh </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="penerbit_sk_perubahan[]" id="" placeholder="Perubahan Di Keluarkan Oleh" >
                    </div>
            </div>

            <div class="item form-group">
                    <label class="col-sm-9 control-label" for="w4-first-name">Tanggal Perubahan Di Keluarkan </label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="tgl_sk_perubahan_keluar[]" id="" placeholder="Masa Berlaku" >
                    </div>
            </div>
           
               
              `); //add input box
    }
  });

});
</script>
@endpush