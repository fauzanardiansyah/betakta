@extends('backend/anggota/base.main-page')
@section('title','Berangkas Anggota')
@section('content-pages')
<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Berangkas Anggota</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_ktp_pjbu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_foto_pjbu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                            <a href="#" file-name="{{ $dataDokumen->file_npwp_bu }}"  class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_npwp_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_ijazah_pjbu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_npwp_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_akte_pendirian_perubahan_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_sk_pendirian_perubahan_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_skdp_bu]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_siup]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_tdp]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                        <div class="thumbnail" style="height:250px">
                            <div class="image view view-first">
                                <img style="width: 100%; display: block;" src="{{ asset('backend/images/file-logo2.png') }}" alt="image">
                                <div class="mask">
                                    <p>{{ $dataDokumen->no_kta }}</p>
                                    <div class="tools tools-bottom">
                                            <a href="#" file-name="{{ $dataDokumen->surat_permohonan_baru }}" class="show-file-detail" data-toggle="modal" data-target="#file-detail" title="File Detail"><i class="fa fa-eye"></i></a>       
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->surat_permohonan_baru]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                    </div>
                                </div>
                            </div>
                            <div class="caption">
                                <p>File Surat Permohonan Pembuatan KTA Baru dan Surat Pernyataan Kesediaan Mengikuti Kode Etik</p>
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->surat_permohonan_perpanjang]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                    </div>
                                </div>
                            </div>
                            <div class="caption">
                                <p>File Surat Permohonan Perpanjangan KTA</p>
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->surat_permohonan_daftar_ulang]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
                                    </div>
                                </div>
                            </div>
                            <div class="caption">
                                <p>File Surat Permohonan Pendaftaran Ulang</p>
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_nib]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_siujk]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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
                                        <a href="{{ route('anggota.berangkas.download', ['file_name' => $dataDokumen->file_kta]) }}" title="Download File"><i class="fa fa-download"></i></a>                         
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


<!-- Modal File Detail -->
<div id="file-detail" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Your Uploaded File</h4>
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