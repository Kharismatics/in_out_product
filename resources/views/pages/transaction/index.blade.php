@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card-header">Transactions <div class="float-right"><a href='{{ route('transactions.create') }}' class='edit-data btn btn-success' data-toggle='tooltip' title='Edit'>Add <i class='fas fa-plus'></i></a></div></div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th>#</th>
                                <th>Date</th>
                                <th>To/From</th>
                                <th>Product</th>
                                <th>Base Price</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Discount</th>
                                <th>Cost</th>
                                <th>Charge</th>
                                <th>Remark</th>
                                <th>Status</th>
                                <th>In/Out</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if (count($rows) == 0)
                                    <tr>
                                        <td colspan="14"><center>Data Empty</center></td>
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
                                            <form action="{{ route('transactions.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')    
                                                <button type="submit" class='edit-data btn btn-danger' data-toggle='tooltip' title='delete'><i class='fa fa-trash'></i></button>   
                                            </form>
                                        </td>
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
</script>
@endsection