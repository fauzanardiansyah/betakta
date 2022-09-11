@extends('backend/dpp/base.main-page')
@section('title','Report Anggota DPP Inkindo '.Session::get('nm_dpp'))
@section('content-pages')
<!-- Start Reports  DPP -->
<form id="generate_reports" class="form-horizontal form-label-left">

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Reports Dewan Pengurus Provinsi {{ Session::get('nm_dpp') }}</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="">
                    <ul class="to_do">
                       
                        <li>
                            <p>
                                <input type="radio" name="jenis_report" id="agt_aktif_provinsi" value="1" class="flat"
                                    required> Anggota Aktif</p>
                        </li>
                        <li>
                            <p>
                                <input type="radio" name="jenis_report" id="agt_tidak_aktif" value="2" class="flat"
                                    required> Anggota Tidak Aktif  
                            </p>
                        </li>
                        <li>
                            <p>
                                <input type="radio" name="jenis_report" id="agt_passif" value="3" class="flat" required>
                                Anggota Pasif  </p>
                        </li>
                        <li>
                            <p>
                                <input type="radio" name="jenis_report" id="pembayaran_agt" value="4" class="flat"
                                    required> Pembayaran Anggota</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Reports  DPP -->

    <!-- Start form filter -->
    <div class="col-md-16 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Filter by</h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipe Report
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="time_report" class="form-control" required>
                            <option value="0">Harian</option>
                            <option value="1">Mingguan</option>
                            <option value="2">Bulanan</option>
                            <option value="3">Tahunan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mulai
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date" name="start" required="required" value=""
                            class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sampai
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="date" id="last-name" name="to" value="" required="required"
                            class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12" id="datatable-report-anggota">
        <div class="x_panel">
            <div class="x_title">
                <h2>Master Reports Anggota</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="report-table-dpp" class="table" aria-describedby="datatable_info">
                                <thead>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Badan Usaha</th>
                                    <th class="text-center">Alamat BU</th>
                                    <th class="text-center">Nama PJBU</th>
                                    <th class="text-center">No HP PJBU</th>
                                    <th class="text-center">Kualifikasi</th>
                                    <th class="text-center">Nomor KTA</th>
                                    <th class="text-center">Status BU</th>
                                    <th class="text-center">Status KTA</th>
                                    <th class="text-center">Tgl Terbit</th>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12 " id="datatable-report-payments">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Master Reports Pembayaran</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="report-payments-table-dpp" class="table" aria-describedby="datatable_info">
                                        <thead>
                                                <th class="text-center">No</th>
                                                <th class="text-center">No Invoice</th>
                                                <th class="text-center">Nama Badan Usaha</th>
                                                <th class="text-center">Nominal</th>
                                                <th class="text-center">Tanggal Pembayaran</th>
                                                <th class="text-center">Status Pembayaran</th>
                                            </thead>
                                </table>
                            </div>
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
</form>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        function newexportaction(e, dt, button, config) {
                    var self = this;
                    var oldStart = dt.settings()[0]._iDisplayStart;
                    dt.one('preXhr', function (e, s, data) {
                        // Just this once, load all data from the server...
                        data.start = 0;
                        data.length = 2147483647;
                        dt.one('preDraw', function (e, settings) {
                            // Call the original action function
                            if (button[0].className.indexOf('buttons-copy') >= 0) {
                                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                            }
                            dt.one('preXhr', function (e, s, data) {
                                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                                // Set the property to what it was before exporting.
                                settings._iDisplayStart = oldStart;
                                data.start = oldStart;
                            });
                            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                            setTimeout(dt.ajax.reload, 0);
                            // Prevent rendering of the full data to the DOM
                            return false;
                        });
                    });
                    // Requery the server with the new one-time export settings
                    dt.ajax.reload();
        };
        $('#generate_reports').submit(function(event){
            event.preventDefault();
            const csrf_token   =  $('meta[name="csrf-token"]').attr('content');
            const id_dp        =  $('meta[name="id-dp"]').attr('content');
            const jenis_report =  $("input[name='jenis_report']:checked").val();
            const time_report  =  $('select[name="time_report"] option:selected').val();
            const start        =  new Date($('input[name="start"]').val());
            const day_start    =  start.getDate();
            const month_start  =  start.getMonth() + 1;
            const year_start   =  start.getFullYear();
            const start_date   =  [year_start, month_start, day_start].join('-');
            const to           =  new Date($('input[name="to"]').val());
            const day_to       =  to.getDate();
            const month_to     =  to.getMonth() + 1;
            const year_to      =  to.getFullYear();
            const to_date      =  [year_to, month_to, day_to].join('-');
            const one_day      =  1000 * 60 * 60 * 24
            const difference_ms = Math.abs(start - to)
            const final_difference = Math.round(difference_ms/one_day);


            if(time_report == 0) {
                if(final_difference >= 6) {
                    
                    Swal.fire({
                        type: 'warning',
                        title: 'Maaf',
                        text: 'UNTUK TIPE REPORT HARIAN TIDAK BISA LEBIH DARI 6 HARI',
                        });
                        throw new Error('This is not an error. This is just to abort javascript');
                } 
            }

            if(time_report == 1) {
                if((final_difference > 31) || (final_difference < 7)) {
                    
                    Swal.fire({
                        type: 'warning',
                        title: 'Maaf',
                        text: 'UNTUK TIPE REPORT MINGGUAN HANYA BISA PER 4 MINGGU / MINIMAL 8 HARI',
                        });
                        throw new Error('This is not an error. This is just to abort javascript');
                } 
            }


            if(time_report == 2) {
                if((final_difference > 91) || (final_difference < 28)) {
                    
                    Swal.fire({
                        type: 'warning',
                        title: 'Maaf',
                        text: 'UNTUK TIPE REPORT BULANAN HANYA BISA PER 3 BULAN / MINIMAL 28 HARI',
                        });
                        throw new Error('This is not an error. This is just to abort javascript');
                } 
            }

            if(time_report == 3) {
                if(final_difference != 365) {
                    
                    Swal.fire({
                        type: 'warning',
                        title: 'Maaf',
                        text: 'UNTUK TIPE REPORT TAHUNAN HANYA BISA PER 1 TAHUN/ 365 HARI',
                        });
                        throw new Error('This is not an error. This is just to abort javascript');
                } 
            }

            

            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

            if(jenis_report == 4) {
             $('#report-payments-table-dpp').DataTable({
                
                destroy: true,
                order: [[ 5, "desc" ]],
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    action: newexportaction,
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page:'all'
                        }
                    }
                
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    action: newexportaction,
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page:'all'
                        }
                    }
                
                }
             ],
                
                ajax: {
                    url: '{!! route('dpp.report.generate') !!}',
                            data: { 
                            id_dp: id_dp, 
                            jenis_report:jenis_report,
                            time_report:time_report,
                            start_date:start_date,
                            to_date:to_date,
                        },
                        
                    type: "POST"
                },
                
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4, 5] },
                ],
            
                columns: [
                    { data: null,sortable: false, searchable: false, 
                    render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                                }  
                    },
                    { data: 'no_invoice', name: 't_payment_confirmation.no_invoice' },
                    { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
                    { data: 'nominal', name: 't_payment_confirmation.nominal' },
                    { data: 'created_at', name: 't_payment_confirmation.created_at' },
                    { data: 'status_pembayaran', name: 't_invoice_kta.status_pembayaran' },
                ]
            });
                
            
            } else {

            $('#report-table-dpp').DataTable({
                
                destroy: true,
                order: [[ 5, "desc" ]],
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    action: newexportaction,
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page:'all'
                        }
                    }
                
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    action: newexportaction,
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page:'all'
                        }
                    }
                
                }
             ],
                
                ajax: {
                    url: '{!! route('dpp.report.generate') !!}',
                            data: { 
                            id_dp: id_dp, 
                            jenis_report:jenis_report,
                            time_report:time_report,
                            start_date:start_date,
                            to_date:to_date,
                        },
                        
                    type: "POST"
                },
                
                columnDefs: [
                    { className: 'text-center', targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
                ],
            
                columns: [
                    { data: null,sortable: false, searchable: false, 
                    render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                                }  
                    },
                    { data: 'nm_bu', name: 't_registrasi_users.nm_bu' },
                    { data: 'alamat', name: 't_administrasi_kta.alamat' },
                    { data: 'nm_pjbu', name: 't_pj_kta.nm_pjbu' },
                    { data: 'no_hp_pjbu', name: 't_pj_kta.no_hp_pjbu' },
                    { data: 'kualifikasi', name: 't_kta.kualifikasi' },
                    { data: 'no_kta', name: 't_kta.no_kta' },
                    { data: 'status_bu', name: 't_registrasi_users.status_bu'},
                    { data: 'status_kta', name: 't_kta.status_kta'},
                    { data: 'tgl_terbit', name: 't_detail_kta.tgl_terbit'},
                ]
            });                 
            }
        });
    });
</script>
@endpush