@extends('administrator/base.home-page')
@section('title', 'Dashboard')
@section('content-pages')
<style type="text/css">
    .preloader {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
     
    }
    .preloader .loading {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%,-50%);
      font: 14px arial;
    }
    </style>
<div class="preloader">
    <div class="loading">
      <img src="{{ asset('administrator/assets/images/preloader.gif') }}" width="80">
      <p>Harap Tunggu</p>
    </div>
</div>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-home icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Halaman Dashboard
                    <div class="page-title-subheading">Ini merupakan halaman dashboard administrator inkindo pusat.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 div-col-lg-12 col-sm-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Filter berdasarkan provinsi</h5>
                    <div class="collapse" id="collapseExample123" style="">
                        <form action="" id="filter-by-province">
                            <div class="form-group">
                                <select type="select" id="provinsi" name="provinsi_id"
                                    class="custom-select">
                                    <option value="">Select</option>
                                    @foreach ($provinsi as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" data-toggle="collapse" href="#collapseExample123"
                        class="btn btn-primary collapsed" aria-expanded="false">Filter Form</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Aktif</div>
                        <div class="widget-subheading">Total anggota aktif seluruh provinsi & asing</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="anggota_aktif"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Berhenti</div>
                        <div class="widget-subheading">Total anggota berhenti seluruh provinsi & asing</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="anggota_berhenti"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Di Tolak Oleh DPP</div>
                        <div class="widget-subheading">Total pengajuan anggota yang di tolak oleh DPP</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="tolak_by_dpp"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Di Tolak Oleh DPN</div>
                        <div class="widget-subheading">Total pengajuan anggota yang di tolak oleh DPN</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="tolak_by_dpn"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Di DPP</div>
                        <div class="widget-subheading">Total pengajuan anggota yang masih di DPP</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="on_dpp"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Di DPN</div>
                        <div class="widget-subheading">Total pengajuan anggota yang masih di DPN</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="on_dpn"></span></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="national-users-chart" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
            
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-md-12 div-col-lg-12 col-sm-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="form-group">
                        <a href="{{ route('administrator.dashboard.export-excel') }}" class="btn btn-success" id="dashboard-export-to-excel">Export to excel</a>
                        <a href="{{ route('administrator.dashboard.export-pdf') }}" class="btn btn-warning ml-1" id="dashboard-export-to-pdf">Export to pdf</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {    
    const csrf_token = $('meta[name="csrf-token"]').attr('content');  
        $.ajax({
            url: '{!! route('administrator.dashboard.post-ajax') !!}', 
            type: "POST",
            data: ({_token: csrf_token}),
            beforeSend: function() {
                $('.preloader').show();
            },
            success: function(data) {
                $('.preloader').hide();
                var data = data
                setDataCounter(data);
                setChart(data);
                console.log(data);
            },

            errors:function(e) {
                Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: e,
                        
                        })
            }
        });  
});

// Filter by province
$(document).ready(function() {    
    const csrf_token = $('meta[name="csrf-token"]').attr('content');
    $("#filter-by-province").on('change', '#provinsi', function(){ 
        const provinsi_id = $(this).val();   
        $.ajax({
            url: '{!! route('administrator.dashboard.post-ajax-filter') !!}', 
            type: "POST",
            data: ({_token:csrf_token,'provinsi_id':provinsi_id}),
            beforeSend: function() {
                $('.preloader').show();
            },
            success: function(data) {
                $('.preloader').hide();
                var data = data
                setDataCounter(data);
                setChart(data);
                console.log(data);
            },

            errors:function(e) {
                Swal.fire({
                        type: 'error',
                        title: 'Gagal',
                        text: e,
                        
                        })
            }
        });  
    });
});


function setDataCounter(data) {
    document.getElementById("anggota_aktif").innerText = data.anggota_aktif[0].total_aktif;
    document.getElementById("anggota_berhenti").innerText = data.anggota_berhenti[0].total_berhenti;
    document.getElementById("tolak_by_dpp").innerText = data.tolak_by_dpp[0].tolak_by_dpp;
    document.getElementById("tolak_by_dpn").innerText = data.tolak_by_dpn[0].tolak_by_dpn;
    document.getElementById("on_dpp").innerText = data.on_dpp[0].on_dpp;
    document.getElementById("on_dpn").innerText = data.on_dpn[0].on_dpn;
}

function setChart(data) {
    Highcharts.chart('national-users-chart', {
          chart: {
              type: 'column'
          },
          title: {
              text: 'Jumlah Anggota Inkindo 34 Provinsi'
          },
          subtitle: {
              text: 'Dewan Pengurus Provinsi'
          },
          xAxis: {
              type: 'category',
              labels: {
                  rotation: -45,
                  style: {
                      fontSize: '13px',
                      fontFamily: 'Verdana, sans-serif'
                  }
              }
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Jumlah Member'
              }
          },
          legend: {
              enabled: false
          },
          tooltip: {
              pointFormat: 'Member: <b>{point.y:.1f}</b>'
          },
          series: [{
              name: 'DPP Members',
              data: data.jmlAnggotaDpp,
             
              dataLabels: {
                  enabled: true,
                  rotation: -90,
                  color: '#FFFFFF',
                  align: 'right',
                  format: '{point.y:.1f}', // one decimal
                  y: 10, // 10 pixels down from the top
                  style: {
                      fontSize: '13px',
                      fontFamily: 'Verdana, sans-serif'
                  }
              }
          }]
      });
}
</script>
@endpush