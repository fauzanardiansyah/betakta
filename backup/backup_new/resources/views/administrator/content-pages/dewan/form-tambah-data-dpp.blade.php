@extends('administrator/base.home-page')
@section('title', 'Form Data Pengurus Nasional Inkindo')
@section('content-pages')
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Administrator Dewan Pengurus Nasional Inkindo
                    <div class="page-title-subheading">Ini merupakan halaman administrator Dewan Pengurus Nasional
                        Inkindo untuk memanage data mulai dari Akses akun dan data DPN.
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Data Dewan Pengurus Provinsi</h5>
                <form action="{{ route('administrator.dewan.save-data-dpp') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                            <select name="id_provinsi" class="form-control" id="">
                                @foreach ($provinsi as $provinsi_item)
                                <option value="{{ $provinsi_item->id }}">{{ $provinsi_item->name }}</option>
                                @endforeach

                            </select>
                            {!! $errors->first('id_provinsi', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">No Rekening DPP</label>
                        <div class="col-sm-10"><input name="no_rek" id="exampleEmail" placeholder="No Rekening DPP"
                                type="text" class="form-control" value="{{ old('no_rek') }}" required>
                            {!! $errors->first('no_rek', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Rekening DPP</label>
                        <div class="col-sm-10"><input name="nm_rek" id="examplePassword" value="{{ old('nm_rek') }}" type="text" class="form-control"  placeholder="Nama Rekening DPP" type="text" class="form-control"  required>
                            {!! $errors->first('nm_rek', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Kode Bank</label>
                        <div class="col-sm-10"><input name="kode_bank" id="examplePassword" placeholder="Kode Bank"
                                type="text" class="form-control" value="{{ old('kode_bank') }}" required>
                            {!! $errors->first('kode_bank', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Bank</label>
                        <div class="col-sm-10"><input name="nm_bank" id="examplePassword" placeholder="Nama Bank"
                                type="text" class="form-control" value="{{ old('nm_bank') }}" required>
                            {!! $errors->first('nm_bank', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Iuran Anggota Besar 1 Tahun</label>
                        <div class="col-sm-10"><input name="iuran_1_thn_besar" id="examplePassword"
                                placeholder="Iuran Anggota Besar 1 Tahun" type="text" class="form-control" value="{{ old('iuran_1_thn_besar') }}" required>
                            {!! $errors->first('iuran_1_thn_besar', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Iuran Anggota Menengah 1 Tahun</label>
                        <div class="col-sm-10"><input name="iuran_1_thn_menengah" id="examplePassword"
                                placeholder="Iuran Anggota Menengah 1 Tahun" type="text" value="{{ old('iuran_1_thn_menengah') }}" class="form-control" required>
                            {!! $errors->first('iuran_1_thn_menengah', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Iuran Anggota Kecil 1 Tahun</label>
                        <div class="col-sm-10"><input name="iuran_1_thn_kecil" id="examplePassword"
                                placeholder="Iuran Anggota Kecil 1 Tahun" type="text" value="{{ old('iuran_1_thn_kecil') }}" class="form-control" required>
                            {!! $errors->first('iuran_1_thn_kecil', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>



                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Uang Pangkal</label>
                        <div class="col-sm-10"><input name="uang_pangkal" value="{{ old('uang_pangkal') }}" id="examplePassword"
                                placeholder="Uang Pangkal" type="text" class="form-control" required>
                            {!! $errors->first('uang_pangkal', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Sharing Iuran Kecil</label>
                        <div class="col-sm-10"><input name="role_share_iuran_kecil" id="examplePassword"
                                placeholder="Role Sharing Iuran Kecil" value="{{ old('role_share_iuran_kecil') }}" type="text" class="form-control" required>
                            {!! $errors->first('role_share_iuran_kecil', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Sharing Iuran Menengah</label>
                        <div class="col-sm-10"><input name="role_share_iuran_menengah" id="examplePassword"
                                placeholder="Role Sharing Iuran Menengah" value="{{ old('role_share_iuran_menengah') }}" type="text" class="form-control" required>
                            {!! $errors->first('role_share_iuran_menengah', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Sharing Iuran Besar</label>
                        <div class="col-sm-10"><input name="role_share_iuran_besar" id="examplePassword"
                                placeholder="Role Sharing Iuran Besar" value="{{ old('role_share_iuran_besar') }}" type="text" class="form-control" required>
                            {!! $errors->first('role_share_iuran_besar', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Share Uang Pangkal</label>
                        <div class="col-sm-10"><input name="role_share_uang_pangkal" id="examplePassword"
                                placeholder="Role Share Uang Pangkal" value="{{ old('role_share_uang_pangkal') }}" type="text" class="form-control" required>
                            {!! $errors->first('role_share_uang_pangkal', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Ketua Provinsi</label>
                        <div class="col-sm-10"><input name="nm_ketua_provinsi" id="examplePassword"
                                placeholder="Nama Ketua Provinsi" value="{{ old('nm_ketua_provinsi') }}" type="text" class="form-control" required>
                            {!! $errors->first('nm_ketua_provinsi', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Sekretaris Provinsi</label>
                        <div class="col-sm-10"><input name="nm_sekretaris_provinsi" id="examplePassword"
                                placeholder="Nama Sekretaris Provinsi" value="{{ old('nm_sekretaris_provinsi') }}" type="text" class="form-control" required>
                            {!! $errors->first('nm_sekretaris_provinsi', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Foto Profile DPP</label>
                        <div class="col-sm-10"><input name="foto_profile_dpp" p id="examplePassword"
                                placeholder="Foto Profile DPP" type="file" class="form-control" required>
                            {!! $errors->first('foto_profile_dpp', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleCity" class="">Ttd
                                    Ketua Provinsi</label>
                                <input name="ttd_ketua_provinsi" id="exampleCity" value="{{ old('ttd_ketua_provinsi') }}" type="file" class="form-control" required>
                                {!! $errors->first('ttd_ketua_provinsi', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleState" class="">Ttd
                                    Sekretaris Provinsi</label>
                                <input name="ttd_sekretaris_provinsi" value="{{ old('ttd_sekretaris_provinsi') }}" id="exampleState" type="file"
                                    class="form-control" required>
                                {!! $errors->first('ttd_sekretaris_provinsi', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10"><textarea name="alamat" placeholder="Alamat" class="form-control" id=""
                                cols="30" rows="10" required>{{ old('username') }}</textarea>
                            {!! $errors->first('alamat', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Email DPP</label>
                        <div class="col-sm-10"><input name="email_dewan_pengurus" id="examplePassword"
                                placeholder="Email DPP" value="{{ old('email_dewan_pengurus') }}" type="email" class="form-control" required>
                            {!! $errors->first('email_dewan_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">No Telp DPP</label>
                        <div class="col-sm-10"><input value="{{ old('no_telp_dewan_pengurus') }}" name="no_telp_dewan_pengurus" id="examplePassword"
                                placeholder="No Telp DPP" type="tex" class="form-control" required>
                            {!! $errors->first('no_telp_dewan_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"> <button class="btn btn-success">Simpan Data Dewan Pengurus
                                Provinsi</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection