@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.stock')</h5>
                    {{-- <hr> --}}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Product</th>
                                <th>Stock</th>
                            </thead>
                            <tbody>
                                {{-- @if (count($rows) == 0)
                                    <tr>
                                        <td colspan="4"><center>Data Empty</center></td>
                                    </tr>
                                @endif --}}
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index }}</td>
                                        <td>{{$row->product}}</td>
                                        <td>{{$row->stock}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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
})
</script>
@endsection