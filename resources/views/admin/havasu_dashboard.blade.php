@extends('admin.layouts.app', [ 'current_page' => 'dashboard' ])

@section('content')
    @include('admin.layouts.headers.cards', [ 'title' => 'Dashboard' ])
    
    
    
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-4 col-md-6">
          <div class="card bg-gradient-info">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Lead From WP Form To TS-CRM</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$leads_web_forms}}</span>
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
        <div class="col-xl-4 col-md-6">
          <div class="card bg-gradient-dark">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Lead From Other SRC</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$leads_other_src}}</span>
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
        <div class="col-xl-4 col-md-6">
          <div class="card bg-gradient-success">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Submission</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{$submission}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-success rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-6">  
        <div id="columnchart" style="height: 30vh"  ></div>
        </div>
        <div class="col-xl-6">                
            <div id="piechart" style="height: 30vh"></div> 
        </div><br>
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
            text: 'Leads By Diffrent Sources'
        },
        tooltip: {
            valueSuffix: '%'
        }, 
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
                    {
                        name: 'Leads From WP-Form',
                        y: {{$leads_web_forms}}
                    }, 
                    {
                        name: 'Leads From Other SRC',
                        y: {{$leads_other_src}}
                    }, 
                ]
            }
        ]
    });
    Highcharts.chart('columnchart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Leads By Diffrent Sources'
    }, 
    xAxis: {
        categories: [
            '2023-01-23', 
            '2023-01-22', 
            '2023-01-21', 
            '2023-01-20', 
            '2023-01-19', 
            '2023-01-18', 
             
        ],
        crosshair: true
    },
    yAxis: {
        title: {
            useHTML: true,
            text: 'Leads By Diffrent Sources'
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
            name: 'Leads From Phone-Calls',
            data: [13.93, 13.63, 13.73, 13.67, 14.37 ]

        }, 
        {
            name: 'Leads From Email',
            data: [8, 10, 13.73, 1, 15 ]

        }, 
        {
            name: 'Leads From WP-Form',
            data: [12.24, 12.24, 11.95, 12.02, 11.65 ]

        } 
    ]
  });
    </script>

@endpush