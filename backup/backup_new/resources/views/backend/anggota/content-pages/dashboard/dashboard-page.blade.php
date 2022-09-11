@extends('backend/anggota/base.main-page')
@section('title','Dashboard Anggota')
@section('content-pages')
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
          text: 'Dewan Pengurus Provinsi & Pusat'
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
          name: 'DPP & DPN Members',
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