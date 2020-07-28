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
    <div class="row">
        <div class="col-md-6">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.best_product')</h5>
                    <hr>
                    <canvas id="BestProductChart" height="150"></canvas>                  
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.best_customer')</h5>
                    <hr>
                    <canvas id="BestCustomerChart" height="150"></canvas>                  
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
<script>    
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
            if (response) {
                var json = JSON.parse(response);
                
                PurchaseChart.data.labels = json.data.labels;    
                PurchaseChart.data.datasets[0].data = json.data.datasets[0].data;    
                PurchaseChart.update(); 
            }
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
            if (response) {
                var json = JSON.parse(response);
                
                SalesChart.data.labels = json.data.labels;    
                SalesChart.data.datasets[0].data = json.data.datasets[0].data;    
                SalesChart.update(); 
            }
        }
    });
    var ctxBestProduct = document.getElementById('BestProductChart').getContext('2d');
    var BestProductChart = new Chart(ctxBestProduct, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
            label: '{{__("text.statistic")}}',
            data: [],
            }]
        },
        options: {
            plugins: {
                colorschemes: {
                    scheme: 'office.Parallax6'
                }
            }
        }
    });    
    $.ajax({
        type: "POST",
        url: "{{ route('best_product_chart') }}",
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response) {
                var json = JSON.parse(response);                
                BestProductChart.data.labels = json.data.labels;  
                for (let index = 0; index < json.data.datasets.length; index++) {
                    BestProductChart.data.datasets[index].data = json.data.datasets[index].data;   
                } 
                BestProductChart.update(); 
            }
        }
    });
    var ctxBestCustomer = document.getElementById('BestCustomerChart').getContext('2d');
    var BestCustomerChart = new Chart(ctxBestCustomer, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
            label: '{{__("text.statistic")}}',
            data: [],
            }]
        },
        options: {
            plugins: {
                colorschemes: {
                    scheme: 'brewer.SetTwo8'
                }
            }
        }
    });    
    $.ajax({
        type: "POST",
        url: "{{ route('best_customer_chart') }}",
        data: {
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response) {
                var json = JSON.parse(response);                
                BestCustomerChart.data.labels = json.data.labels;  
                for (let index = 0; index < json.data.datasets.length; index++) {
                    BestCustomerChart.data.datasets[index].data = json.data.datasets[index].data;   
                } 
                BestCustomerChart.update(); 
            }
        }
    });
</script>
@endsection