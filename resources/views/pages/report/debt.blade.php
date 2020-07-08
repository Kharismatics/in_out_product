@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title"> @lang('text.debt') </h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.type')</th>
                                <th>@lang('text.people')</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{$row->transaction_type}}</td>
                                        <td>{{$row->people}}</td>
                                        <td>{{$row->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><h5><b>Total</b></h5></td>
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

        total = api
            .column(3)
            .data()
            .reduce(function (a, b) {
                return (intVal(a) + intVal(b));
            }, 0);

        text_class = (total >= 0) ? 'text-success' : 'text-danger' ;

        $(api.column(3).footer()).html(
            '<h5><b class="'+text_class+'">'+ total +'</b></h5>'
        );
    }
});

$('.filter-data').click(function (e) {     
    $( ".filter-form" ).submit();
});
</script>
@endsection