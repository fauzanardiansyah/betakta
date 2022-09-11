@extends('backend/dpn/base.main-page')
@section('title','Master Anggota Pindah DPP')
@section('content-pages')
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Turun Kualifikasi</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="agt-pindah-datatable" class="table" aria-describedby="datatable_info">
                            <thead>
                                <th class="text-center">Nama Badan Usaha</th>
                                <th class="text-center">Nama PJBU</th>
                                <th class="text-center">Jenis Pengajuan</th>
                                <th class="text-center">Status Pengajuan</th>
                                <th class="text-center">Kualifikasi</th>
                                <th class="text-center">Waktu Pengajuan</th>
                                <th class="text-center">Action</th>
                            </thead>
                        </table>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pindah-dokumen-modal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Form Tolak Pindah Anggota</h4>
            </div>
            <div class="modal-body">
              <h4>Masukan alasan kenapa di tolak</h4>
              <form action="{{ route('dpn.pindah.reject') }}" method="POST" id="form-reject-document" class="form-horizontal" role="form">
                  @csrf
                    <div class="form-group">
                      <div class="col-sm-12">
                          <textarea name="keterangan" class="form-control" id="" cols="30" rows="10" required></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                            <div class="col-sm-12">
                                <button type="submit" id="reject-document">Tolak Pengajuan</button>
                            </div>
                    </div>

                    <input type="hidden" id="id_detail_kta" name="id_detail_kta" value="">
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
$(function() {
    $('#agt-pindah-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('dpn.get_data_turun_kualifikasi') !!}',

        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6 ] },
        ],
       
        columns: [
            { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
            { data: 'nm_pjbu', name: 't_pj_kta.nm_pjbu' },
            { data: 'jenis_pengajuan', name: 't_detail_kta.jenis_pengajuan' },
            { data: 'status_pengajuan', name: 'status_pengajuan', orderable: false, searchable: false },
            { data: 'kualifikasi', name: 't_kta.kualifikasi' },
            { data: 'waktu_pengajuan', name: 't_detail_kta.waktu_pengajuan' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush