@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card-header">@lang('text.transaction') <div class="float-right"><a href='{{ route('transactions.create') }}' class='edit-data btn btn-success' data-toggle='tooltip' title='Edit'>@lang('text.add') <i class='fas fa-plus'></i></a></div></div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.date')</th>
                                <th>@lang('text.to')/@lang('text.from')</th>
                                <th>@lang('text.product')</th>
                                <th>@lang('text.base_price')</th>
                                <th>@lang('text.price')</th>
                                <th>@lang('text.quantity')</th>
                                <th>@lang('text.discount')</th>
                                <th>Cost</th>
                                <th>Charge</th>
                                <th>@lang('text.remark')</th>
                                <th>Status</th>
                                <th>@lang('text.in')/@lang('text.out')</th>
                                <th class="text-center" style="width:200">@lang('text.action')</th>
                            </thead>
                            <tbody>
                                @if (count($rows) == 0)
                                    <tr>
                                        <td colspan="14"><center>Data @lang('text.empty')</center></td>
                                    </tr>
                                @endif
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{$row->transaction_date}}</td>
                                        <td>{{$row->people->name}}</td>
                                        <td>{{$row->product->name}}</td>
                                        <td>{{$row->base_price}}</td>
                                        <td>{{$row->price}}</td>
                                        <td>{{$row->quantity}}</td>
                                        <td>{{$row->discount}}</td>
                                        <td>{{$row->cost}}</td>
                                        <td>{{$row->charge}}</td>
                                        <td>{{$row->remark}}</td>
                                        <td>@switch($row->transaction_status) @case(1) Pending @break @case(2) Progress @break @case(3) Complete @break @endswitch</td>
                                        <td>{{$row->transaction_type}}</td>
                                        <td class="text-center form-inline">
                                            <a href='{{ route('transactions.edit', $row->id) }}' class='edit-data btn btn-warning' data-toggle='tooltip' title='Edit'><i class="fas fa-edit"></i></a>
                                            <form id="delete-form" action="{{ route('transactions.destroy', $row->id) }}" method="POST">
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
                                <th>@lang('text.date')</th>
                                <th>@lang('text.to')/@lang('text.from')</th>
                                <th>@lang('text.product')</th>
                                <th>@lang('text.base_price')</th>
                                <th>@lang('text.price')</th>
                                <th>@lang('text.quantity')</th>
                                <th>@lang('text.discount')</th>
                                <th>Cost</th>
                                <th>Charge</th>
                                <th>@lang('text.remark')</th>
                                <th>Status</th>
                                <th>@lang('text.in')/@lang('text.out')</th>
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
</script>
@endsection