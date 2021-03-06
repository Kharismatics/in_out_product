@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.stock') Detail</h5>
                    {{-- <hr> --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.date')</th>
                                <th>@lang('text.stock')</th>
                            </thead>
                            <tbody>
                                {{-- @if (count($rows) == 0)
                                    <tr>
                                        <td colspan="4"><center>Data Empty</center></td>
                                    </tr>
                                @endif --}}
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{$row->transaction_date}}</td>
                                        <td>{{$row->stock}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
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
    buttons: [
        { extend: "copy", text: '<i class="fas fa-copy"></i>', className: 'btn btn-secondary',titleAttr: 'Copy'},
        { extend: "excel", text: '<i class="fas fa-file-excel"></i>', className: 'btn btn-success',titleAttr: 'Export to Excel'},
        { extend: "pdf", text: '<i class="fas fa-file-pdf"></i>', className: 'btn btn-danger',titleAttr: 'Export to pdf'},
        { extend: "print", text: '<i class="fas fa-print"></i>', className: 'btn btn-secondary',titleAttr: 'Print'}
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
            .column(2)
            .data()
            .reduce(function (a, b) {
                return (intVal(a) + intVal(b));
            }, 0);

        $(api.column(2).footer()).html(
            '<h5><b>'+ total +'</b></h5>'
        );
    }
})
</script>
@endsection