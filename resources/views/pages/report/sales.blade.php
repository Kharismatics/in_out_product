@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">Sales Report</h5>
                    {{-- <hr> --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.unique_code')</th>
                                <th>@lang('text.people')</th>
                                <th>@lang('text.product')</th>
                                <th>@lang('text.purchase')</th>
                                <th>@lang('text.sales')</th>
                            </thead>
                            <tbody>
                                @if (count($rows) == 0)
                                    <tr>
                                        <td colspan="4"><center>Data Empty</center></td>
                                    </tr>
                                @endif
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{$row->unique_code}}</td>
                                        <td>{{$row->people}}</td>
                                        <td>{{$row->product}}</td>
                                        <td>{{$row->purchase}}</td>
                                        <td>{{$row->sales}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-center" colspan="2"><h5>Total</h5></td>
                                    <td class="text-center" colspan="2"></td>
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
    buttons: [
        { extend: "copy", exportOptions: { columns: 'th:not(:last-child)' },  text: '<i class="fas fa-copy"></i>', className: 'btn btn-secondary',titleAttr: 'Copy'},
        { extend: "excel", exportOptions: { columns: 'th:not(:last-child)' },   text: '<i class="fas fa-file-excel"></i>', className: 'btn btn-success',titleAttr: 'Export to Excel'},
        { extend: "pdf", exportOptions: { columns: 'th:not(:last-child)' },   text: '<i class="fas fa-file-pdf"></i>', className: 'btn btn-danger',titleAttr: 'Export to pdf'},
        { extend: "print", exportOptions: { columns: 'th:not(:last-child)' },   text: '<i class="fas fa-print"></i>', className: 'btn btn-secondary',titleAttr: 'Print'}
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
            .column(4)
            .data()
            .reduce(function (a, b) {
                return (intVal(a) + intVal(b));
            }, 0);

        total_sales = api
            .column(5)
            .data()
            .reduce(function (a, b) {
                return (intVal(a) + intVal(b));
            }, 0);

        balance =  total_sales - total_purchase;
        text_class = (balance > 0) ? 'text-success' : 'text-danger' ;

        $(api.column(3).footer()).html(
           '<b class="'+text_class+'">'+ balance.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +'</b>'
        );

        $(api.column(4).footer()).html(
            total_purchase.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        );

        $(api.column(5).footer()).html(
            total_sales.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        );
    }
});
</script>
@endsection