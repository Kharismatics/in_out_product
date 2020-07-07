@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.transaction') <div class="float-right"><a href='{{ route('transactions.create') }}' class='edit-data btn btn-success' data-toggle='tooltip' title='Edit'>@lang('text.add') <i class='fas fa-plus'></i></a></div></h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table DataTables">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.type')</th>
                                <th>@lang('text.code')</th>
                                <th>@lang('text.date')</th>
                                <th>@lang('text.to')/@lang('text.from')</th>
                                <th>@lang('text.product')</th>
                                <th>@lang('text.transaction')</th>
                                <th>@lang('text.base_price')</th>
                                <th>@lang('text.price')</th>
                                <th>@lang('text.quantity')</th>
                                <th>@lang('text.discount')</th>
                                <th>Cost</th>
                                <th>Charge</th>
                                <th>@lang('text.remark')</th>
                                <th>Status</th>
                                <th class="text-center" style="width:200">@lang('text.action')</th>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{($row->transaction_type == 'in') ? __('text.purchase') : __('text.sales') }}</td>
                                        <td class="{{ ($row->transaction_type == 'in') ? 'text-danger' : 'text-success' }}">{{$row->unique_code}}</td>
                                        <td>{{$row->transaction_date}}</td>
                                        <td>{{$row->people->name}}</td>
                                        <td>{{ ( $row->product ) ? $row->product->name:'' }}</td>
                                        <td>{{ ( $row->transaction ) ? $row->transaction->unique_code:'' }}</td>
                                        <td>{{$row->base_price}}</td>
                                        <td>{{$row->price}}</td>
                                        <td>{{$row->quantity}}</td>
                                        <td>{{$row->discount}}</td>
                                        <td>{{$row->cost}}</td>
                                        <td>{{$row->charge}}</td>
                                        <td>{{$row->remark}}</td>
                                        <td>@switch($row->transaction_status) @case(1) Pending @break @case(2) Progress @break @case(3) Complete @break @endswitch<br>@switch($row->paid) @case(0) @lang('text.unpaid') @break @case(1) @lang('text.paid') @break @endswitch</td>
                                        <td class="text-center form-inline">
                                            <a href='{{ route('transactions.edit', $row->id) }}' class='edit-data btn btn-warning' data-toggle='tooltip' title='Edit'><i class="fas fa-edit"></i></a>
                                            <form class="delete-form" action="{{ route('transactions.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')    
                                                <a class='delete-data btn btn-danger' data-toggle='tooltip' title='delete'><i class='fa fa-trash'></i></a>   
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <th>#</th>
                                <th>@lang('text.type')</th>
                                <th>@lang('text.code')</th>
                                <th>@lang('text.date')</th>
                                <th>@lang('text.to')/@lang('text.from')</th>
                                <th>@lang('text.product')</th>
                                <th>@lang('text.transaction')</th>
                                <th>@lang('text.base_price')</th>
                                <th>@lang('text.price')</th>
                                <th>@lang('text.quantity')</th>
                                <th>@lang('text.discount')</th>
                                <th>Cost</th>
                                <th>Charge</th>
                                <th>@lang('text.remark')</th>
                                <th>Status</th>
                                <th class="text-center" style="width:200">@lang('text.action')</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript"> 
$(document).ready(function () {
    var transactions = @json($rows, JSON_PRETTY_PRINT);
});
function AjaxUpdate(params) {     
    $.ajax({
        type: "POST",
        url: "{{ route('transactions.create') }}",
        data: {
            tes : 1,
            _method : 'PUT',
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            console.log(response);     
        }
    });
 }
</script>
@endsection