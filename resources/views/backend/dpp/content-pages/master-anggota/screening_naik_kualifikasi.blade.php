@extends('backend/dpp/base.main-page')
@section('title','Master Anggota Baru | Screening Document')
@section('content-pages')

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Screening Documents</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <p>
                           
                            <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#admin-bu"
                                aria-expanded="false" aria-controls="collapseExample">
                                Administrasi Badan Usaha
                            </button>
                            <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#pjbu"
                                aria-expanded="false" aria-controls="collapseExample">
                                PJ Badan Usaha
                            </button>
                            <button class="btn btn-warning" type="button" data-toggle="collapse"
                                data-target="#legalitas-bu" aria-expanded="false" aria-controls="collapseExample">
                                Legalitas Badan Usaha
                            </button>

                            <button class="btn btn-warning" type="button" data-toggle="collapse"
                                data-target="#dokumen-bu" aria-expanded="false" aria-controls="collapseExample">
                                Dokumen Pendukung Badan Usaha
                            </button>
                            
                          
                            
                            
                        </p>
                        
                        <div class="collapse" id="admin-bu">
                            <div class="card card-body">
                                <!--Table-->
                                <table id="tablePreview" class="table">
                                    <!--Table head-->
                                    <thead>
                                        <tr>
                                            
                                            <th>Alamat Badan Usaha</th>
                                            <th>Kode Pos</th>
                                            <th>Kecamatan </th>
                                            <th>Kota</th>
                                            <th>No Telp </th>
                                            <th>No Fax</th>
                                            <th>Website</th>
                                        </tr>
                                    </thead>
                                    <!--Table head-->
                                    <!--Table body-->
                                    <tbody>
                                        <tr>
                                            <td>{!! $dataAdministrasiBu->alamat !!}</td>
                                            <td>{!! $dataAdministrasiBu->kd_pos !!}</td>
                                            <td>{!! $dataAdministrasiBu->kecamatan !!}</td>
                                            <td>{!! $dataAdministrasiBu->kota !!}</td>
                                            <td>{!! $dataAdministrasiBu->no_telp !!}</td>
                                            <td>{!! $dataAdministrasiBu->no_fax !!}</td>
                                            <td>{!! $dataAdministrasiBu->website !!}</td>
                                        </tr>
                                    </tbody>
                                    <!--Table body-->
                                </table>
                                <!--Table-->
                            </div>
                        </div>
                        <div class="collapse" id="pjbu">
                            <div class="card card-body">
                                <!--Table-->
                                <table id="tablePreview" class="table">
                                    <!--Table head-->
                                    <thead>
                                        <tr>
                                            
                                            <th>Nama Penanggung Jawab*</th>
                                            <th>Kewarganegaraan</th>
                                            <th>NIK</th>
                                            <th>Passport</th>
                                            <th>Jabatan</th>
                                            <th>Pendidikan Formal Tertinggi*</th>
                                            <th>Tempat, Tanggal Lahir*</th>
                                            <th>Alamat</th>
                                            <th>Email PJBU</th>
                                            <th>Nomor Handphone*</th>
                                            <th>NPWP PJBU*</th>

                                        </tr>
                                    </thead>
                                    <!--Table head-->
                                    <!--Table body-->
                                    <tbody>
                                        <tr>     
                                            <td>{!! $dataPjbu->nm_pjbu !!}</td>
                                            <td>{!! $dataPjbu->kewarganegaraan !!}</td>
                                            <td>{!! $dataPjbu->nik !!}</td>
                                            <td>{!! $dataPjbu->no_passport !!}</td>
                                            <td>
                                                <?php
                                                if($dataPjbu->jabatan == 1) :
                                                    echo 'Direktur';
                                                elseif($dataPjbu->jabatan == 2):
                                                    echo "Direktur Utama";
                                                elseif($dataPjbu->jabatan == 3):
                                                    echo "Presiden Direktur";
                                                endif;

                                                ?>
                                             </td>
                                            <td>
                                                    <?php
                                                    if($dataPjbu->pendidikan == 0) :
                                                        echo 'S1';
                                                    elseif($dataPjbu->pendidikan == 1):
                                                        echo "S2";
                                                    elseif($dataPjbu->pendidikan == 2):
                                                        echo "S3";
                                                    elseif($dataPjbu->pendidikan == 3):
                                                        echo "> S3";
                                                    endif;
    
                                                    ?>
                                            </td>
                                            <td>{!! $dataPjbu->tempat !!}, {!! $dataPjbu->tgl_lahir !!}</td>
                                            <td>{!! $dataPjbu->alamat !!}</td>
                                            <td>{!! $dataPjbu->email_pjbu !!}</td>
                                            <td>{!! $dataPjbu->no_hp_pjbu !!}</td>
                                            <td>{!! $dataPjbu->npwp_pjbu !!}</td>
                                            
                                        </tr>
                                    </tbody>
                                    <!--Table body-->
                                </table>
                                <!--Table-->
                            </div>
                        </div>
                        <div class="collapse" id="legalitas-bu">
                            <div class="card card-body">
                                <!--Table-->
                                <table id="tablePreview" class="table">
                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Akte Pendirian Badan Usaha</strong></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Akte Pendirian</th>
                                        <th>Nama Akte Notaris</th>
                                        <th>Tanggal Akte Di Keluarkan*</th>
                                        <th>Maksud Dan Tujuan Akte</th>
                                    </tr>

                                    <tr>
                                        <td>{!! $dataLegalitasBu[0]->no_akte !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->nm_notaris !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->tgl_keluar_akte !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->maksud_tujuan_akte !!}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Akte Perubahan Badan Usaha</strong></h4>
                                        </td>
                                    </tr>
                            
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Akte Perubahan</th>
                                        <th>Nama Notaris Perubahan</th>
                                        <th>Tanggal Akte Perubahan Di Keluarkan</th>
                                        <th>Maksud Dan Tujuan Akte Perubahan</th>
                                    </tr>
                                    <?php $no = 1; ?>
                                    @foreach ($dataLegalitasBu[0]->details as $row_detail_legalitas)
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td>{!! $row_detail_legalitas->no_akte_perubahan !!}</td>
                                        <td>{!! $row_detail_legalitas->nm_notaris_perubahan !!}</td>
                                        <td>{!! $row_detail_legalitas->tgl_akte_perubahan_keluar !!}</td>
                                        <td>{!! $row_detail_legalitas->maksud_tujuan_akte_perubahan !!}</td>
                                    </tr>
                                    <?php $no++; ?>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Lembar Pengesahan kemenkumham</strong></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No Lembar Pengesahan kemenkumham</th>
                                        <th>Tanggal Lembar Pengesahan Di Keluarkan</th>
                                    </tr>

                                    <tr>
                                        <td>{!! $dataLegalitasBu[0]->no_sk_pendirian !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->tgl_sk_pendirian_keluar !!}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Lembar Perubahan Pengesahan kemenkumham</strong></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No</th>
                                        <th>No Lembar Pengesahan kemenkumham</th>
                                        <th>Tanggal Lembar Pengesahan Di Keluarkan</th>
                                    </tr>
                                    <?php $no = 1; ?>
                                    @foreach ($dataLegalitasBu[0]->details as $row_detail_legalitas)
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td>{!! $row_detail_legalitas->no_sk_perubahan !!}</td>
                                        <td>{!! $row_detail_legalitas->tgl_sk_perubahan_keluar !!}</td>
                                    </tr>
                                    <?php $no++; ?>
                                    @endforeach

                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Surat Keterangan Domisili Perusahaan (SKDP)</strong></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nomor SKDP</th>
                                        <th>SKDP Di Keluarkan Oleh </th>
                                        <th>Tanggal SKDP Di Keluarkan</th>
                                        <th>Masa Berlaku</th>
                                    </tr>

                                    <tr>
                                        <td>{!! $dataLegalitasBu[0]->no_skdp !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->penerbit_skdp!!}</td>
                                        <td>{!! $dataLegalitasBu[0]->tgl_keluar_skdp !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->masa_berlaku_skdp !!}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Surat Ijin Usaha Perdagangan (SIUP)</strong></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nomor SIUP</th>
                                        <th>SIUP Di Keluarkan Oleh </th>
                                        <th>Tanggal SIUP Di Keluarkan</th>
                                        <th>Masa Berlaku</th>
                                    </tr>

                                    <td>{!! $dataLegalitasBu[0]->no_siup !!}</td>
                                    <td>{!! $dataLegalitasBu[0]->penerbit_siup!!}</td>
                                    <td>{!! $dataLegalitasBu[0]->tgl_keluar_siup !!}</td>
                                    <td>{!! $dataLegalitasBu[0]->masa_berlaku_siup !!}</td>

                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Tanda Daftar Perusahaan (TDP)</strong></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nomor TDP</th>
                                        <th>TDP Di Keluarkan Oleh </th>
                                        <th>Tanggal TDP Di Keluarkan</th>
                                        <th>Masa Berlaku</th>
                                    </tr>

                                    <td>{!! $dataLegalitasBu[0]->no_tdp !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->penerbit_tdp !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->tgl_keluar_tdp !!}</td>
                                        <td>{!! $dataLegalitasBu[0]->masa_berlaku_tdp !!}</td>


                                    <tr>
                                        <td colspan="3">
                                            <h4 style="color:darkblue"><strong>Nomor Induk Berusaha (NIB)</strong></h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nomor NIB</th>
                                        <th>Tanggal NIB Di Keluarkan</th>
                                        
                                    </tr>

                                    <td>{!! $dataLegalitasBu[0]->no_nib !!}</td>
                                    <td>{!! $dataLegalitasBu[0]->tgl_keluar_nib !!}</td>

                                </table>
                                <!--Table-->
                            </div>
                        </div>
                        <div class="collapse" id="dokumen-bu">
                            <div class="card card-body">                       
                                <p>Berangkas Dokumen Yang Di Upload Oleh Anggota</p>
                                @if (!empty($dataDokumen))
                                <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" class="show-file-detail" file-name="{{ $dataDokumen->file_ktp_pjbu }}" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_ktp_pjbu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File KTP Penanggung Jawab Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                        <a href="#" class="show-file-foto-pjbu" file-name="{{ $dataDokumen->file_foto_pjbu }}"  data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_foto_pjbu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File Foto Penanggung Jawab Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_npwp_pjbu }}"  class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_npwp_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File NPWP Penanggung Jawab Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_ijazah_pjbu }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>       
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_ijazah_pjbu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File Ijazah PJBU</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_npwp_bu }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_npwp_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File NPWP Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                        <a href="#" file-name="{{ $dataDokumen->file_akte_pendirian_perubahan_bu }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_akte_pendirian_perubahan_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File Akte Pendirian / Perubahan Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_sk_pendirian_perubahan_bu }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_sk_pendirian_perubahan_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File Lembar Pengesahan / Perubahan Kemenkumham</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_skdp_bu }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_skdp_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File SKDP Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_siup }}" class="show-file-detail" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_siup]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File SIUP Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_tdp }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>       
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_tdp]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File TDP Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                
                                    @if (!empty($dataDokumen->surat_permohonan_baru))
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->surat_permohonan_baru }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>       
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->surat_permohonan_baru]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File Surat Permohonan Pembuatan KTA Baru</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                
                                    @if (!empty($dataDokumen->surat_permohonan_perpanjang))
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->surat_permohonan_perpanjang }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>       
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->surat_permohonan_perpanjang]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File Surat Permohonan Perpanjang KTA</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                
                                    @if (!empty($dataDokumen->surat_permohonan_daftar_ulang))
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->surat_permohonan_daftar_ulang }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>       
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->surat_permohonan_daftar_ulang]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File Surat Permohonan Daftar Ulang KTA Baru</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                    
                                    @if (!empty($dataDokumen->file_nib))
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_nib }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="Download File"><i class="fa fa-eye"></i></a>       
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_nib]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File NIB Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if (!empty($dataDokumen->file_siujk))
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                            <a href="#" file-name="{{ $dataDokumen->file_siujk }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="Download File"><i class="fa fa-eye"></i></a>       
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_nib]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File SIUJK Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                    
                                    @if (!empty($dataDokumen->file_kta))
                                    <div class="col-md-55">
                                        <div class="thumbnail">
                                            <div class="image view view-first">
                                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                                <div class="mask">
                                                    <p>{{ $dataDokumen->no_kta }}</p>
                                                    <div class="tools tools-bottom">
                                                        <a href="#" file-name="{{ $dataDokumen->file_kta }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="Download File"><i class="fa fa-eye"></i></a>                      
                                                        <a href="{{ route('dpp.master-anggota.download', ['file_name' => $dataDokumen->file_kta]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="caption">
                                                <p>File KTA Terakhir Badan Usaha</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <h4 class="text-center">Belum Ada Berkas Yang Di Unggah</h4>
                                @endif
                            </div>
                        </div>
                       
                    </div>
                </div>

            </div>
        </div>
        <div class="x_title">

            @if($dataDokumen->status_pengajuan >= 2 ) 
            <a href="{{ url('/panel/dpp/naik_kualifikasi') }}" class="btn btn-sm btn-primary pull-right"  title="Kembali" >Back</a>
            @else
            <a href=" {{ route('dpp.naik_kualifikasi.approve', ['id_detail_kta' => $id_detail_kta]) }}" id="approve-dokumen-anggota" class="btn btn-sm btn-success pull-right"  title="Approve Documents" ><i class="glyphicon glyphicon glyphicon-saved"></i> Approve Dokumen</a>
            @endif
        </div>
    </div>
</div>

<!-- Modal File Detail -->
<div style="height:650px;" id="file-detail" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Show uploded file</h4>
            </div>
            <div class="modal-body" id="show-file-detail">
                
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
    $(document).ready(function(){
        $('#approve-dokumen-anggota').click(function(event){
            event.preventDefault();

            const url = $(this).attr('href');

            Swal.fire({
            title: 'Apakah anda sudah memeriksa dokumen dengan benar ?',
            text: "Tolong pastikan telah memeriksa dokumen pengajuan anggota dengan baik dan benar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Sudah Benar!'
            }).then((result) => {
            if (result.value) {
                document.location.href = url;
            }
            })
        });
    });
</script>
@endpush