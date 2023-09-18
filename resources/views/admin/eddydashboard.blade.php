@extends('admin.layouts.app', [ 'current_page' => 'dashboard' ])
@section('content')
    @include('admin.layouts.headers.cards', [ 'title' => 'Dashboard' ])
    <!-- Page content -->
    <div class="container-fluid mt--6">
       
        <form action="" method="GET" id="webform" style="padding:15px"
          enctype="multipart/form-data">
          @csrf
          <div class="row"> 
              <div class="form-group col-md-4">
                  <label class="form-control-label">From Date</label>
                  <input type="date" value="{{ @$_GET['f_date'] }}" name="f_date" class="form-control">
              </div>
              <div class="form-group col-md-4">
                  <label class="form-control-label">To Date</label>
                  <input type="date" value="{{ @$_GET['t_date'] }}" name="t_date" class="form-control">
              </div> 
              <div class="form-group col-md-4">
                <label class="form-control-label">&nbsp;</label>
                <button type="submit" class="form-control btn btn-info">Search</button>
              </div> 
          </div>                
        </form>
       
      <div class="row">
        
        <div class="col-xl-4 col-md-6">
          <div class="card bg-gradient-info">
            <!-- Card body -->            
            <div class="card-body">
              <div class="row">
                <div class="col-md-10">
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total In-Bounds</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{@$totals[0]->Inbound}}</span>

                </div>
                <div class="col-md-2">
                  <div class="icon icon-shape bg-white text-primary rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>                
              </div>
                <hr style="border:1px solid white">
                <div class="row" style="color: black">    
                    <div class="col-md-6">
                        <p>Billable-Hours <span class="text text-left">{{ @$totals[0]->InBillableHours }}</span></p> 
                    </div> 
                    <div class="col-md-6">
                        <p>Connect  <span class="text text-left">{{ round(@$totals[0]->InConnectPercentage,2) }} %</span></p> 
                    </div> 
                    <div class="col-md-6">
                        <p>Edu Tranfer rate  <span class="text text-left">{{ @$totals[0]->InEduTransferRate }}</span></p> 
                    </div>  
                    
                    <div class="col-md-6">
                        <p>EDU Conv Total calls <span class="text text-left">{{ round(@$totals[0]->InEduConvTotalCalls,2) }}%</span></p> 
                    </div> 
                    <div class="col-md-6">
                        <p>Edu Transfer  <span class="text text-left">{{ @$totals[0]->InEduTransfers }}</span></p> 
                    </div>  
                    <div class="col-md-6">
                        <p>Edu Conversions  <span class="text text-left">{{ @$totals[0]->InEduConversions }}</span></p> 
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
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Out-Bounds</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{@$totals[0]->Outbound}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>

              <hr style="border:1px solid white">
              <div class="row" style="color: white">    
                <div class="col-md-6">
                    <p>Billable-Hours <span class="text text-left">{{ @$totals[0]->OutBillableHours }}</span></p> 
                </div> 
                <div class="col-md-6">
                    <p>Connect  <span class="text text-left">{{ round(@$totals[0]->OutConnectPercentage,2) }} %</span></p> 
                </div> 
                <div class="col-md-6">
                    <p>Edu Tranfer rate  <span class="text text-left">{{ @$totals[0]->OutEduTransferRate }}</span></p> 
                </div>  
                
                <div class="col-md-6">
                    <p>EDU Conv Total calls <span class="text text-left">{{ round( @$totals[0]->OutEduConvTotalCalls,2) }}%</span></p> 
                </div> 
                <div class="col-md-6">
                    <p>Edu Transfer  <span class="text text-left">{{ @$totals[0]->OutEduTransfers }}</span></p> 
                </div>  
                <div class="col-md-6">
                    <p>Edu Conversions  <span class="text text-left">{{ @$totals[0]->OutEduConversions }}</span></p> 
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
                  <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total EddyEdu</h5>
                  <span class="h2 font-weight-bold mb-0 text-white">{{@$totals[0]->EddyEdu}}</span>
                </div>
                <div class="col-auto">
                  <div class="icon icon-shape bg-white text-success rounded-circle shadow">
                    <i class="fa fa-life-ring"></i>
                  </div>
                </div>
              </div>
              <hr style="border:1px solid white">
              <div class="row" style="color: white">    
                <div class="col-md-6">
                    <p>Billable-Hours <span class="text text-left">{{ @$totals[0]->EddyBillableHours }}</span></p> 
                </div> 
                <div class="col-md-6">
                    <p>Fomrs  <span class="text text-left">{{ @$totals[0]->forms }}</span></p> 
                </div> 
                <div class="col-md-6">
                    <p>LTs  <span class="text text-left">{{ @$totals[0]->lts }}</span></p> 
                </div>  
                
                <div class="col-md-6">
                    <p>Conversions <span class="text text-left">{{ round(@$totals[0]->conv_percentage,2) }} %</span></p> 
                </div> 
                <div class="col-md-6">
                    <p>LT   <span class="text text-left">{{ round(@$totals[0]->lt_percentage,2) }} %</span></p> 
                </div>  
                <div class="col-md-6">
                    <p>WLPH  <span class="text text-left">{{ @$totals[0]->wlph }}</span></p> 
                </div>  
                
             </div>
            </div>
          </div>
        </div>
      </div>
       
        <div class="row">
          <div class="col-md-6"> 
            <div id="lineChart" style="height: 30vh"></div>
          </div>
          <div class="col-md-6"> 
            <div id="pieChart" style="height: 30vh"></div>
          </div>
        </div>
      @include('admin.layouts.footers.auth')
    </div>
@endsection

@push('js')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
 <script>
  // Data retrieved from https://netmarketshare.com
  Highcharts.chart('pieChart', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Eddy Sale Percentage',
          align: 'left'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
          point: {
              valueSuffix: '%'
          }
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %'
              }
          }
      },
      series: [{
          name: 'Projects',
          colorByPoint: true,
          data: [{
              name: 'EddyEdu',
              y: {{@$totals[0]->EddyEdu}}
          }, {
              name: 'InBound',
              y: {{@$totals[0]->Inbound}}
          },  {
              name: 'OutBound',
              y: {{@$totals[0]->Outbound}}
          } ]
      }]
  });

  Highcharts.chart('lineChart', {
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
        series: [{
          name: 'Inbound',
          data: [
             <?php foreach($lastSevenDaysData as $row){?> 
              {{$row['inbound']}},  
            <?php } ?>
          ]
        }, {
          name: 'OutBound',
          data: [
            <?php foreach($lastSevenDaysData as $row){?> 
              {{$row['outbound']}},  
            <?php } ?>
          ]
        }, {
            name: 'EddyEdu',
            data: [<?php foreach($lastSevenDaysData as $row){?> 
              {{$row['eddy']}},  
            <?php } ?> ]
        }  ]
  });

 </script>
@endpush