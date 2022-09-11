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
    <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <a href="{{ route('administrator.dewan.manage-data-dpn') }}"
                            style="text-decoration: none; color:#fff">
                            <div class="widget-heading">Manage Data DPN</div>
                            <div class="widget-subheading">Mengatur data DPN</div>
                        </a>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><i
                                    class="fa fa-database icon-gradient bg-ripe-malin"> </i></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-6">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <a href="{{ route('administrator.dewan.manage-account-dpn') }}"
                            style="text-decoration: none; color:#fff">
                            <div class="widget-heading">Manage Akun DPN</div>
                            <div class="widget-subheading">Mengatur akun akses DPN</div>
                        </a>

                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><i class="fa fa-cog icon-gradient bg-mean-fruit">
                                </i></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Data Dewan Pengurus Pusat Inkindo</h5>
                <form action="{{ route('administrator.dewan.save-data-dpn') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="position-relative row form-group"><label for="exampleEmail"
                        class="col-sm-2 col-form-label">Provinsi</label>
                    <div class="col-sm-10">
                        <select name="id_provinsi" class="form-control" id="">
                            @foreach ($provinsi as $provinsi_item)
                            <option value="{{ $provinsi_item->id }}" {{ ($provinsi_item->id == $data_dpn->provinsi->id) ? "selected" : "" }}>{{ $provinsi_item->name }}</option>
                            @endforeach

                        </select>
                        {!! $errors->first('id_provinsi', '<p class=""
                            style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                        !!}
                    </div>
                </div>
                    <div class="position-relative row form-group"><label for="exampleEmail"
                            class="col-sm-2 col-form-label">No Rekening DPN</label>
                        <div class="col-sm-10"><input name="no_rek" id="exampleEmail" placeholder="No Rekening DPN"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->no_rek : '' }}" required>
                            {!! $errors->first('no_rek', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>
                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Rekening DPN</label>
                        <div class="col-sm-10"><input name="nm_rek" id="examplePassword" placeholder="Nama Rekening DPN"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->nm_rek : '' }}" required>
                            {!! $errors->first('nm_rek', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Kode Bank</label>
                        <div class="col-sm-10"><input name="kode_bank" id="examplePassword" placeholder="Kode Bank"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->kode_bank : '' }}" required>
                            {!! $errors->first('kode_bank', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Bank</label>
                        <div class="col-sm-10"><input name="nm_bank" id="examplePassword" placeholder="Nama Bank"
                                type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->nm_bank : '' }}" required>
                            {!! $errors->first('nm_bank', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Iuran Afiliasi 1 Tahun</label>
                        <div class="col-sm-10"><input name="iuran_1_thn_besar" id="examplePassword"
                                placeholder="Iuran Afiliasi 1 Tahun" type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->iuran_1_thn_besar : '' }}" required>
                            {!! $errors->first('iuran_1_thn_besar', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Uang Pangkal</label>
                        <div class="col-sm-10"><input name="uang_pangkal" id="examplePassword"
                                placeholder="Uang Pangkal" type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->uang_pangkal : '' }}" required>
                            {!! $errors->first('uang_pangkal', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Ketua Umum</label>
                        <div class="col-sm-10"><input name="nm_ketum" id="examplePassword"
                                placeholder="Nama Ketua Umum" type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->nm_ketum : '' }}" required>
                            {!! $errors->first('nm_ketum', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Sekretaris jendral</label>
                        <div class="col-sm-10"><input name="nm_sekjen" id="examplePassword"
                                placeholder="Nama Sekretaris jendral" type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->nm_sekjen : '' }}" required>
                            {!! $errors->first('nm_sekjen', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Foto Profile DPN</label>
                        <div class="col-sm-10"><input name="foto_profile_dpn" id="examplePassword"
                                placeholder="Foto Profile DPN" type="file" class="form-control">
                            {!! $errors->first('foto_profile_dpn', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Ketua BKKA</label>
                        <div class="col-sm-10"><input name="ketua_bkka" id="examplePassword"
                                placeholder="Nama Ketua BKKA" type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->ketua_bkka : '' }}" required>
                            {!! $errors->first('ketua_bkka', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Nama Sekretaris BKKA</label>
                        <div class="col-sm-10"><input name="sekretaris_bkka" id="examplePassword"
                                placeholder="Nama Sekretaris BKKA" type="text" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->sekretaris_bkka : '' }}" required>
                            {!! $errors->first('sekretaris_bkka', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleCity" class="">Ttd
                                    Ketum</label>
                                <input name="ttd_ketum" id="exampleCity" type="file" class="form-control">
                                {!! $errors->first('ttd_ketum', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleState" class="">Ttd
                                    Sekjen</label>
                                <input name="ttd_sekjen" id="exampleState" type="file" class="form-control">
                                {!! $errors->first('ttd_sekjen', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleZip" class="">Ttd Ketua
                                    BKKA</label>
                                <input name="ttd_ketua_bkka" id="exampleZip" type="file" class="form-control">
                                {!! $errors->first('ttd_ketua_bkka', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="exampleZip" class="">Ttd Sekretaris
                                    BKKA</label>
                                <input name="ttd_sekretaris_bkka" id="exampleZip" type="file" class="form-control"
                                    >
                                {!! $errors->first('ttd_sekretaris_bkka', '<p class=""
                                    style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                                !!}
                            </div>
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10"><textarea name="alamat" placeholder="Alamat" class="form-control" id=""
                                cols="30" rows="10"
                                required>{{ (! is_null($data_dpn)) ? $data_dpn->alamat : '' }}"</textarea>
                            {!! $errors->first('alamat', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">Email DPN</label>
                        <div class="col-sm-10"><input name="email_dewan_pengurus" id="examplePassword" placeholder="Email DPN"
                                type="email" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->email_dewan_pengurus : '' }}" required>
                            {!! $errors->first('email_dewan_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>

                    <div class="position-relative row form-group"><label for="examplePassword"
                            class="col-sm-2 col-form-label">No Telp DPN</label>
                        <div class="col-sm-10"><input name="no_telp_dewan_pengurus" id="examplePassword" placeholder="No Telp DPN"
                                type="tex" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->no_telp_dewan_pengurus : '' }}" required>
                            {!! $errors->first('no_telp_dewan_pengurus', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>


                    <div class="position-relative row form-group"><label for="examplePassword"
                        class="col-sm-2 col-form-label">No Rekening BKKA</label>
                        <div class="col-sm-10"><input name="no_rek_bkka" id="examplePassword" placeholder="No Rekening BKKA"
                                type="tex" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->no_rek_bkka : '' }}" required>
                            {!! $errors->first('no_rek_bkka', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>



                    <div class="position-relative row form-group"><label for="examplePassword"
                        class="col-sm-2 col-form-label">Nama Bank BKKA</label>
                        <div class="col-sm-10"><input name="nm_bank_bkka" id="examplePassword" placeholder="Nama Bank BKKA"
                                type="tex" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->nm_bank_bkka : '' }}" required>
                            {!! $errors->first('nm_bank_bkka', '<p class=""
                                style="margin-top:3px;padding:5px;background:#CE5454; color:cornsilk">:message</p>')
                            !!}
                        </div>
                    </div>


                    <div class="position-relative row form-group"><label for="examplePassword"
                        class="col-sm-2 col-form-label">Nama Rekening BKKA</label>
                        <div class="col-sm-10"><input name="nm_rek_bkka" id="examplePassword" placeholder="Nama Rekening BKKA"
                                type="tex" class="form-control"
                                value="{{ (! is_null($data_dpn)) ? $data_dpn->nm_rek_bkka : '' }}" required>
                            {!! $errors->first('nm_rek_bkka', '<p class=""
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