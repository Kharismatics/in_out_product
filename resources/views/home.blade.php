@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center pb-3">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="card">
                
                <div class="card-body">
                    <h5 class="card-title">Dashboard</h5>
                    <hr>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @lang('text.welcome')
                    
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row pb-3">
        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">Chart</h5>
                    <hr>
                    <canvas id="myChart" height="158"></canvas>                  
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.purchase')</h5>
                    <hr>
                    <canvas id="PurchaseChart" height="150"></canvas>                  
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.sales')</h5>
                    <hr>
                    <canvas id="SalesChart" height="150"></canvas>                    
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script>    

    // var ctx = document.getElementById("myChart").getContext('2d');
    // var myChart = new Chart(ctx, {
    //     type: 'line',
    //     data: {
    //         labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
    //         datasets: [{
    //         label: 'Sales',
    //         data: [3200, 1800, 4305, 3022, 6310, 5120, 5880, 6154],
    //         borderWidth: 2,
    //         backgroundColor: 'rgba(63,82,227,.8)',
    //         borderWidth: 0,
    //         borderColor: 'transparent',
    //         pointBorderWidth: 0,
    //         pointRadius: 3.5,
    //         pointBackgroundColor: 'transparent',
    //         pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
    //         },
    //         {
    //         label: 'Budget',
    //         data: [2207, 3403, 2200, 5025, 2302, 4208, 3880, 4880],
    //         borderWidth: 2,
    //         backgroundColor: 'rgba(254,86,83,.7)',
    //         borderWidth: 0,
    //         borderColor: 'transparent',
    //         pointBorderWidth: 0 ,
    //         pointRadius: 3.5,
    //         pointBackgroundColor: 'transparent',
    //         pointHoverBackgroundColor: 'rgba(254,86,83,.8)',
    //         }]
    //     },
    //     options: {
    //         legend: {
    //         display: false
    //         },
    //         scales: {
    //         yAxes: [{
    //             gridLines: {
    //             // display: false,
    //             drawBorder: false,
    //             color: '#f2f2f2',
    //             },
    //             ticks: {
    //             beginAtZero: true,
    //             stepSize: 1500,
    //             callback: function(value, index, values) {
    //                 return '$' + value;
    //             }
    //             }
    //         }],
    //         xAxes: [{
    //             gridLines: {
    //             display: false,
    //             tickMarkLength: 15,
    //             }
    //         }]
    //         },
    //     }
    // });

    var ctxPurchase = document.getElementById('PurchaseChart').getContext('2d');
    var PurchaseChart = new Chart(ctxPurchase, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
            label: '@lang("text.statistic")',
            data: [],
            borderWidth: 5,
            borderColor: '#dc3545',
            backgroundColor: 'transparent',
            pointBackgroundColor: '#fff',
            pointBorderColor: '#dc3545',
            pointRadius: 4
            }]
        },
        options: {
            legend: {
            display: false
            },
            scales: {
            yAxes: [{
                gridLines: {
                display: false,
                drawBorder: false,
                },
                ticks: {
                stepSize: 100000
                }
            }],
            xAxes: [{                
                gridLines: {
                display: false,
                color: '#fbfbfb',
                lineWidth: 2
                }
            }]
            },
        }
    });    
    $.ajax({
        type: "POST",
        url: "{{ route('purchase_chart') }}",
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            var json = JSON.parse(response);
            
            PurchaseChart.data.labels = json.data.labels;    
            PurchaseChart.data.datasets[0].data = json.data.datasets[0].data;    
            PurchaseChart.update(); 
        }
    });
    var ctxSales = document.getElementById('SalesChart').getContext('2d');
    var SalesChart = new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
            label: '{{__("text.statistic")}}',
            data: [],
            borderWidth: 5,
            borderColor: '#28a745',
            backgroundColor: 'transparent',
            pointBackgroundColor: '#fff',
            pointBorderColor: '#28a745',
            pointRadius: 4,
            }]
        },
        options: {
            legend: {
            display: false
            },
            scales: {
            yAxes: [{
                gridLines: {
                display: false,
                drawBorder: false,
                },
                ticks: {
                stepSize: 100000
                }
            }],
            xAxes: [{                
                gridLines: {
                display: false,
                color: '#fbfbfb',
                lineWidth: 2
                }
            }]
            },
        }
    });    
    $.ajax({
        type: "POST",
        url: "{{ route('sales_chart') }}",
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            var json = JSON.parse(response);
            
            SalesChart.data.labels = json.data.labels;    
            SalesChart.data.datasets[0].data = json.data.datasets[0].data;    
            SalesChart.update(); 
        }
    });
</script>
@endsection