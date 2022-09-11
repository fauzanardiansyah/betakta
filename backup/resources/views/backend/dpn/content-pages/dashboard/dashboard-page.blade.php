@extends('backend/dpn/base.main-page')
@section('title','Dashboard Dewan Pengurus Pusat')
@section('content-pages')
<div class="row tile_count">
    
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count"></div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Anggota Aktif</span>
        <div class="count">{{ $anggota_aktif[0]->total_aktif }}</div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Anggota Pasif</span>
        <div class="count">{{ $anggota_pasif[0]->total_pasif }}</div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Anggota Berhenti</span>
        <div class="count">{{ $anggota_berhenti[0]->total_berhenti }}</div>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count"></div>
</div>
<div id="national-users-chart" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript">
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
          data: {!! json_encode($jmlAnggotaDpp) !!},
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
      </script>
      
@endsection