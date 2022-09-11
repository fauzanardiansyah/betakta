@extends('backend/anggota/base.main-page')
@section('title','Status Anggota')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Status Ke Anggotaan</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table  class="table" role="grid"
                            aria-describedby="datatable_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_desc text-center" tabindex="0" aria-controls="datatable"
                                        rowspan="1" colspan="1" aria-sort="descending"
                                      style="width: 157px;">No
                                        Registrasi
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" 
                                        style="width: 259px;">
                                        Nomor KTA</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" aria-label="Age: activate to sort column ascending"
                                        style="width: 60px;">Waktu Pengajuan
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls
                                    ="datatable" rowspan="1"
                                        colspan="1" 
                                        style="width: 115px;">Pengurusan</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1"
                                        style="width: 115px;">Jenis Pengajuan</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" 
                                        style="width: 115px;">Masa Berlaku</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" 
                                        style="width: 115px;">Kualifikasi</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1"
                                        style="width: 90px;">
                                        Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(!empty($statusData))
                                <tr role="row" class="odd text-center">
                                    <td style="padding-top:35px">

                                        <p>{{ $statusData->id_detail_kta }}</p>
                                    </td>
                                    <td style="padding-top:35px">
                                        <center><a
                                                class="btn btn-info">{{ $rslt = ($statusData->no_kta === null) ? 'pending' : $statusData->no_kta }}</a>
                                        </center>
                                    </td>
                                    <td style="padding-top:35px">{{ $statusData->waktu_pengajuan  }}</td>
                                    <td style="padding-top:35px">{{ $statusData->lokasi_pengurusan  }}</td>
                                    <td style="padding-top:35px">
                                        @php
                                            $statusData->jenis_pengajuan;
                                        @endphp
                                        @if ($statusData->jenis_pengajuan == 0)
                                        Buat Baru
                                        @elseif($statusData->jenis_pengajuan == 1)
                                        Daftar Ulang
                                        @elseif($statusData->jenis_pengajuan == 2)
                                        Perubahan
                                        @elseif($statusData->jenis_pengajuan == 3)
                                        Perpanjangan
                                        @elseif($statusData->jenis_pengajuan == 4)
                                        Pemberhentian                                   
                                        @elseif($statusData->jenis_pengajuan == 5)
                                        Pindah DPP


                                        @elseif($statusData->jenis_pengajuan == 6)
                                        Naik Kualifikasi

                                        @elseif($statusData->jenis_pengajuan == 7)
                                        Turun Kualifikasi
                                        
                                        @elseif($statusData->jenis_pengajuan == 8)
                                        Perubahan Data
                                        @endif
                                    </td>
                                    <td style="padding-top:35px">
                                        @if (Carbon\Carbon::now() >= $statusData->masa_berlaku)
                                            <a class="btn btn-danger">Expired</a>
                                        @else
                                            {{  $statusData->masa_berlaku }}
                                        @endif
                                    </td> 
                                    <td style="padding-top:35px">
                                       {{  $statusData->kualifikasi }}
                                    </td>
                                    <td style="padding-top:25px">
                                        <center>
                                            <a href="http://" id="status" style="width:100%"
                                                data-status="{{ $statusData->id_detail_kta }}" data-toggle="modal"
                                                data-target="#status-pengajuan-kta" class="btn btn-success " title="Status of submission of documents"><i class="fa fa-eye"></i> Status</a>
                                            @if ( ($statusData->status_pengajuan === 7 && $statusData->status_kta !== 2)  or  $statusData->status_pengajuan === 1)
                                            <a href="{{ route('anggota.extend', ['id_detail_kta' => $statusData->id_detail_kta]) }}"
                                                class="btn btn-default btn-extend-kta" data-link="{{ route('anggota.update.formAdministrasiBadanUsaha', ['idKta' => $statusData->id_kta]) }}" style="width:100%" title="Extend membership"><i class="fa fa-plug"></i> Perpanjangan</a>
                                            <a href="{{ url('panel/anggota/edit_data/1') }}" class="btn btn-warning"
                                                style="width:100%"  title="Stop membership"><i class="fa fa-edit"></i> Perubahan </a>    
                                            <a href="{{ route('anggota.stop', ['id' => $statusData->id_detail_kta]) }}" class="btn btn-danger btn-stop-kta"
                                                style="width:100%"  title="Stop membership"><i class="fa fa-ban"></i> Pemberhentian</a>       
                                            @endif  

                                        </center>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="status-pengajuan-kta" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Status Pengajuan KTA Online</h4>
            </div>
            <div class="modal-body">
                <div id="wizard" class="form_wizard wizard_horizontal">
                    <ul class="wizard_steps anchor">
                        <li>
                            <a href="#" id="step-1" class="disabled" isdone="0" rel="1">
                                <span class="step_no">1</span>
                                <span class="step_descr">
                                    Registrasi Dokumen<br>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="step-2" class="disabled" isdone="0" rel="2">
                                <span class="step_no">2</span>
                                <span class="step_descr">
                                    Proses Oleh DPP<br>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="step-3" class="disabled" isdone="0" rel="3">
                                <span class="step_no">3</span>
                                <span class="step_descr">
                                    Proses Oleh DPN<br>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" id="step-4" class="disabled" isdone="0" rel="4">
                                <span class="step_no">4</span>
                                <span class="step_descr">
                                    Selesai<br>
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="stepContainer" style="height: 211px;">
                        <div id="message-kta" class="content">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        @endsection