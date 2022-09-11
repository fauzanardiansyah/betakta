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
                <h5 class="card-title">Data Dewan Pengurus Provinsi {{ $data_dpp->provinsi->name }}</h5>
                <form action="{{ route('administrator.dewan.manage-data-dpp-process', ['id_dp' => $data_dpp->id ]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                            <select name="id_provinsi" class="form-control" id="">
                                @foreach ($provinsi as $provinsi_item)
                                <option value="{{ $provinsi_item->id }}"  {{ ($provinsi_item->id == $data_dpp->provinsi->id) ? "selected" : "" }}>{{ $provinsi_item->name }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('npwp_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">No Rekening DPP</label>
                        <div class="col-sm-10"><input name="no_rek" id="exampleEmail" placeholder="No Rekening DPN"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->no_rek : '' }}" required>
                            {!! $errors->first('no_rek', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Rekening DPP</label>
                        <div class="col-sm-10"><input name="nm_rek" id="examplePassword" placeholder="Nama Rekening DPN"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->nm_rek : '' }}" required>
                            {!! $errors->first('nm_rek', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Kode Bank</label>
                        <div class="col-sm-10"><input name="kode_bank" id="examplePassword" placeholder="Kode Bank"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->kode_bank : '' }}" required>
                            {!! $errors->first('kode_bank', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Bank</label>
                        <div class="col-sm-10"><input name="nm_bank" id="examplePassword" placeholder="Nama Bank"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->nm_bank : '' }}" required>
                            {!! $errors->first('nm_bank', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Iuran Anggota Besar 1 Tahun</label>
                        <div class="col-sm-10"><input name="iuran_1_thn_besar" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->iuran_1_thn_besar : '' }}" required>
                            {!! $errors->first('iuran_1_thn_besar', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Iuran Anggota Menengah 1 Tahun</label>
                        <div class="col-sm-10"><input name="iuran_1_thn_menengah" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->iuran_1_thn_menengah : '' }}" required>
                            {!! $errors->first('iuran_1_thn_menengah', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Iuran Anggota Kecil 1 Tahun</label>
                        <div class="col-sm-10"><input name="iuran_1_thn_kecil" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->iuran_1_thn_kecil : '' }}" required>
                            {!! $errors->first('iuran_1_thn_kecil', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>



                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Uang Pangkal</label>
                        <div class="col-sm-10"><input name="uang_pangkal" id="examplePassword"
                                placeholder="Uang Pangkal" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->uang_pangkal : '' }}" required>
                            {!! $errors->first('uang_pangkal', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Sharing Iuran Kecil</label>
                        <div class="col-sm-10"><input name="role_share_iuran_kecil" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->role_share_iuran_kecil : '' }}" required>
                            {!! $errors->first('role_share_iuran_kecil', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Sharing Iuran Menengah</label>
                        <div class="col-sm-10"><input name="role_share_iuran_menengah" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->role_share_iuran_menengah : '' }}"
                                required>
                            {!! $errors->first('role_share_iuran_menengah', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Sharing Iuran Besar</label>
                        <div class="col-sm-10"><input name="role_share_iuran_besar" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->role_share_iuran_besar : '' }}" required>
                            {!! $errors->first('role_share_iuran_besar', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Role Share Uang Pangkal</label>
                        <div class="col-sm-10"><input name="role_share_uang_pangkal" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->role_share_uang_pangkal : '' }}" required>
                            {!! $errors->first('role_share_uang_pangkal', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Ketua Provinsi</label>
                        <div class="col-sm-10"><input name="nm_ketua_provinsi" id="examplePassword"
                                placeholder="Nama Ketua Umum" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->nm_ketua_provinsi : '' }}" required>
                            {!! $errors->first('nm_ketua_provinsi', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Sekretaris Provinsi</label>
                        <div class="col-sm-10"><input name="nm_sekretaris_provinsi" id="examplePassword"
                                placeholder="Nama Sekretaris jendral" type="text" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->nm_sekretaris_provinsi : '' }}" required>
                            {!! $errors->first('nm_sekretaris_provinsi', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Foto Profile DPP</label>
                        <div class="col-sm-10"><input name="foto_profile_dpp" p id="examplePassword"
                                placeholder="Foto Profile DPN" type="file" class="form-control">
                            {!! $errors->first('foto_profile_dpp', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleCity" class="">Ttd
                                    Ketua Provinsi</label>
                                <input name="ttd_ketua_provinsi" id="exampleCity" type="file" class="form-control">
                                {!! $errors->first('ttd_ketua_provinsi', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleState" class="">Ttd
                                    Sekretaris Provinsi</label>
                                <input name="ttd_sekretaris_provinsi" id="exampleState" type="file"
                                    class="form-control">
                                {!! $errors->first('ttd_sekretaris_provinsi', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>

                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea name="alamat" placeholder="Alamat" class="form-control" id="" cols="30" rows="10"
                                required>{{ (! is_null($data_dpp)) ? $data_dpp->alamat : '' }}</textarea>
                            {!! $errors->first('alamat', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Email DPP</label>
                        <div class="col-sm-10"><input name="email_dewan_pengurus" id="examplePassword"
                                placeholder="Email DPN" type="email" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->email_dewan_pengurus : '' }}" required>
                            {!! $errors->first('email_dewan_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">No Telp DPP</label>
                        <div class="col-sm-10"><input name="no_telp_dewan_pengurus" id="examplePassword"
                                placeholder="No Telp DPN" type="tex" class="form-control"
                                value="{{ (! is_null($data_dpp)) ? $data_dpp->no_telp_dewan_pengurus : '' }}" required>
                            {!! $errors->first('no_telp_dewan_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10"> <button class="btn btn-success">Simpan Data Dewan Pengurus
                                Nasional</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection