@extends('admin.layouts.app', [ 'current_page' => 'dashboard' ])

@section('content')
    @include('admin.layouts.headers.cards', [ 'title' => 'Dashboard' ])
    
    @php
$total_dss = \DB::table('sale_dsses')->count();
$total_home_warranty = \DB::table('home_warranties')->count();
$total_mortgage = \DB::table('sale_mortgages')->count();
$total_solar = \DB::table('sale_records')->count();
@endphp
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-info">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total DSS Submissions</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{@$total_dss}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-dark">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Home Warranty Submissions</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{@$total_home_warranty}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-success">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Mortgage Submissions</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{@$total_mortgage}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-success rounded-circle shadow">
                    <i class="fa fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6">
          <div class="card bg-gradient-danger">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Solar Submissions</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{@$total_solar}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-danger rounded-circle shadow">
                    <i class="fa fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-6">  
          <div id="drilldown" style="height: 30vh"  ></div>
        </div>
        <div class="col-xl-6">                
            <div id="piechart" style="height: 30vh"></div> 
        </div><br>
        <div class="col-xl-12">                
          <div id="columnchart" style="height: 40vh"></div> 
        </div>
      </div> 
      
      @include('admin.layouts.footers.auth')
    </div>
@endsection

@push('js') 
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
  
  Highcharts.chart('piechart', {
      colors: ['#01BAF2', '#f6fa4b', '#FAA74B', '#baf201', '#f201ba'],
      chart: {
          type: 'pie'
      },
      title: {
          text: 'Sales Of Every Campaign'
      },
      tooltip: {
          valueSuffix: '%'
      },
      // subtitle: {
      //     text:        ''
      // },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '{point.name}: {point.percentage:.1f}%'
              },
              showInLegend: true
          }
      },
      series: [
          {
              name: 'Percentage',
              colorByPoint: true,
              data: [
                @foreach($pieChart as $key=>$chart)
                  {
                      name: '{{strtoupper($key)}}',
                      y: {{$chart}}
                  },
                @endforeach
              ]
          }
      ]
  });

  Highcharts.chart('columnchart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Previous Seven Days Sales'
    }, 
    xAxis: {
        categories: [

          <?php foreach($lastSevenDaysData as $rw) { ?>  "{{$rw['date']}}", <?php } ?>
             
        ],
        crosshair: true
    },
    yAxis: {
        title: {
            useHTML: true,
            text: 'Sales<sub>2</sub>-equivalents'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
      
      {
        name: 'Solars',
        data: [<?php foreach($lastSevenDaysData as $rw) { echo $rw['solar_count'].",";?><?php } ?>]

      }, {
        name: 'Mortgage',
        data: [<?php foreach($lastSevenDaysData as $rw) { echo $rw['mortgage_count'].",";?><?php } ?>]

      }, {
        name: 'Home-Warranties',
        data: [<?php foreach($lastSevenDaysData as $rw) { echo $rw['warranty_count'].",";?><?php } ?>]

      }, {
        name: 'DSS',
        data: [<?php foreach($lastSevenDaysData as $rw) { echo $rw['dss_count'].",";?><?php } ?>]

      } 
       
      

    ]
  });
  Highcharts.chart('drilldown', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Last 7 Days Submissions'
        },
        subtitle: {
            text: 'Source: ' +
                ''
        },
        xAxis: {
            categories: [
                <?php foreach($lastSevenDaysData as $row){?> 
                    "{{$row['date']}}",  
                <?php } ?> 
            ]
        },
        yAxis: {
            title: {
                text: 'Goal and Ach '
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [
            {
                name: 'Mortgage',
                data: [
                  <?php foreach($lastSevenDaysData as $row){?> 
                    {{$row['mortgage_count']}},  
                <?php } ?>
                ]
            },{
                name: 'Solar',
                data: [
                  <?php foreach($lastSevenDaysData as $row){?> 
                    {{$row['solar_count']}},  
                <?php } ?>
                ]
            }
            ,{
                name: 'DSS',
                data: [
                  <?php foreach($lastSevenDaysData as $row){?> 
                    {{$row['warranty_count']}},  
                <?php } ?>
                ]
            } ,{
                name: 'HomeWarranty',
                data: [
                  <?php foreach($lastSevenDaysData as $row){?> 
                    {{$row['dss_count']}},  
                <?php } ?>
                ]
            }  
            
        ]
  });


</script>

@endpush