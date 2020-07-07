@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="filter-form" action="{{ route('sales') }}" method="POST" enctype="multipart/form-data">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @csrf
                            @method('POST') 
                            @foreach ($intervals as $index => $item)
                                <label class="filter-data btn btn-outline-info">
                                    <input type="radio" name="interval" value='{{ $item["interval"] }}' {{ ($item['interval'] == $interval) ? 'checked':'' }} autocomplete="off">{{ $item["caption"] }}
                                </label>                                
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.sales')</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.date')</th>
                                <th>@lang('text.unique_code')</th>
                                <th>@lang('text.people')</th>
                                <th>@lang('text.product')</th>
                                <th>@lang('text.price')</th>
                                <th>@lang('text.quantity')</th>
                                <th>@lang('text.purchase')</th>
                                <th>@lang('text.sales')</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{$row->transaction_date}}</td>
                                        <td>{{$row->unique_code}}</td>
                                        <td>{{$row->people}}</td>
                                        <td>{{$row->product}}</td>
                                        <td>{{$row->price}}</td>
                                        <td>{{$row->quantity}}</td>
                                        <td>{{$row->purchase}}</td>
                                        <td>{{$row->sales}}</td>
                                        <td>{{$row->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><h5><b>Total</b></h5></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript"> 
var table = $('.table').DataTable({
    dom: 'Btr',
    paging: false,
    buttons: [
        { extend: "copy", footer:true, text: '<i class="fas fa-copy"></i>', className: 'btn btn-secondary',titleAttr: 'Copy'},
        { extend: "excel", footer:true, text: '<i class="fas fa-file-excel"></i>', className: 'btn btn-success',titleAttr: 'Export to Excel'},
        { extend: "pdf", footer:true, text: '<i class="fas fa-file-pdf"></i>', className: 'btn btn-danger',titleAttr: 'Export to pdf'},
        { extend: "print", footer:true, text: '<i class="fas fa-print"></i>', className: 'btn btn-secondary',titleAttr: 'Print'}
    ],
    footerCallback: function (row, data, start, end, display) {
        var api = this.api(),
            data;
        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '') * 1 :
                typeof i === 'number' ?
                i : 0;
        };
        // get total of column
        total_purchase = api
            .column(7)
            .data()
            .reduce(function (a, b) {                
                return (intVal(a) + intVal(b));
            }, 0);

        total_sales = api
            .column(8)
            .data()
            .reduce(function (a, b) {
                return (intVal(a) + intVal(b));
            }, 0);

        total = api
            .column(9)
            .data()
            .reduce(function (a, b) {
                return (intVal(a) + intVal(b));
            }, 0);

        text_class = (total > 0) ? 'text-success' : 'text-danger' ;

        $(api.column(7).footer()).html(
            '<p class="text-danger">'+ total_purchase +'</p>'
        );
        $(api.column(8).footer()).html(
            '<p class="text-success">'+ total_sales +'</p>'
        );
        $(api.column(9).footer()).html(
            '<h5><b class="'+text_class+'">'+ total +'</b></h5>'
        );
    }
});

$('.filter-data').click(function (e) {     
    $( ".filter-form" ).submit();
});
</script>
@endsection