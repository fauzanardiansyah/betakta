@extends('backend/dpp/base.main-page')
@section('title','Download KTA Anggota')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Download Kartu Tanda Anggota</h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped  dataTable no-footer" role="grid"
                            aria-describedby="datatable_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_desc text-center" tabindex="0" aria-controls="datatable"
                                        rowspan="1" colspan="1" aria-sort="descending" style="width: 157px;">No
                                        Registrasi
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" style="width: 259px;">
                                        Nomor KTA</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" aria-label="Age: activate to sort column ascending"
                                        style="width: 60px;">Waktu Pengajuan
                                    </th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" style="width: 115px;">Pengurusan</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" style="width: 115px;">Jenis Pengajuan</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" style="width: 115px;">Masa Berlaku</th>
                                    <th class="sorting text-center" tabindex="0" aria-controls="datatable" rowspan="1"
                                        colspan="1" style="width: 90px;">
                                        Download</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($memberData) > 0)
                                @if(!$memberData[0]->status_kta == 2)
                                @foreach ($memberData as $rowDataDownload)
                                <tr role="row" class="odd text-center">
                                    <td style="padding-top:35px">
                                        <p>{{ $rowDataDownload->nm_bu }}</p>
                                    </td>
                                    <td style="padding-top:35px">
                                        <center><a
                                                class="btn btn-info">{{ $result = ($rowDataDownload->no_kta === null) ? 'pending' : $rowDataDownload->no_kta }}</a>
                                        </center>
                                    </td>
                                    <td style="padding-top:35px">{{ $rowDataDownload->waktu_pengajuan  }}</td>
                                    <td style="padding-top:35px">{{ $rowDataDownload->lokasi_pengurusan  }}</td>
                                    <td style="padding-top:35px">
                                        @if ($rowDataDownload->jenis_pengajuan == 0)
                                        Buat Baru
                                        @elseif($rowDataDownload->jenis_pengajuan == 1)
                                        Daftar Ulang
                                        @elseif($rowDataDownload->jenis_pengajuan == 2)
                                        Perubahan
                                        @elseif($rowDataDownload->jenis_pengajuan == 3)
                                        Perpanjangan
                                        @elseif($rowDataDownload->jenis_pengajuan == 4)
                                        Pemberhentian
                                        @endif
                                    </td>
                                    <td style="padding-top:35px">
                                        @if (Carbon\Carbon::now() >= $rowDataDownload->masa_berlaku)
                                        <a class="btn btn-danger">Expierd</a>
                                        @else
                                        {{  $rowDataDownload->masa_berlaku }}
                                        @endif
                                    </td>
                                    <td style="padding-top:25px">
                                        @if ($rowDataDownload->jenis_pengajuan == 0 && $rowDataDownload->status_penataran == 0 &&  $rowDataDownload->jenis_bu == 'pmdn')
                                        <center>
                                        <h4 title="Hubungi administrator untuk info lebih lanjut">Tidak Dapat Mendownload KTA</h4>
                                        </center>
                                        @elseif(Carbon\Carbon::now() >= $rowDataDownload->masa_berlaku)
                                        <h4 title="KTA anda sudah lewat dari masa berlaku">Tidak Dapat Mendownload KTA</h4>
                                        @else 
                                        <center>
                                            <a href="{{ route('dpp.process-download-kta', ['idKta' => $rowDataDownload->id_kta]) }}"
                                                id="download-kta" class="btn btn-sm btn-danger"
                                                title="Download KTA Certificate"><i class="fa fa-file-pdf-o"></i> Cetak
                                                KTA
                                            </a>
                                            <a href="{{ route('dpp.process-download-idcard', ['idKta' => $rowDataDownload->id_kta]) }}"
                                                id="download-idcard" class="btn btn-sm btn-warning"
                                                title="Download ID Card"><i class="fa fa-credit-card"></i> Cetak ID Card
                                            </a>
                                        </center>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @endif
                            </tbody>
                        </table>
                        {{ $memberData->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection