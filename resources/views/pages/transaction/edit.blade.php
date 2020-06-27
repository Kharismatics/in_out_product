@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">Edit Data</div>

                <div class="card-body">

                    <form action="{{ route('transactions.update', $row->id) }}" method="post">
		            	{{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="people_id">Select People</label>
                            <select class="form-control @error('people_id') is-invalid @enderror" id="people_id" name="people_id">
                                @foreach($peoples as $people)
                                <option value="{{$people->id}}" {{ $row && ($row->people_id == $people->id) ? 'selected':'' }}> {{ $people->name }}</option>
                                @endforeach
                            </select>
                                @error('people_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div> 
                        <div class="form-group">
                            <label for="product_id">Select Product</label>
                            <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                                @foreach($products as $product)
                                <option value="{{$product->id}}" {{ $row && ($row->product_id == $product->id) ? 'selected':'' }}> {{ $product->name }}</option>
                                @endforeach
                            </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div> 
                        <div class="form-group">
                            <label for="transaction_date">Transaction Date</label>
                            <input id="transaction_date" type="text" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" value="{{ $row->transaction_date }}" placeholder="Format (yyyy-mm-dd) example : 2020-01-30"  autocomplete="transaction_date" autofocus>

                                @error('transaction_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                 
                        <div class="form-group">
                            <label for="base_price">Base Price</label>
                            <input id="base_price" type="number" class="form-control @error('base_price') is-invalid @enderror" name="base_price" value="{{ $row->base_price }}"  autocomplete="base_price" autofocus>

                                @error('base_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $row->price }}"  autocomplete="price" autofocus>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ $row->quantity }}"  autocomplete="quantity" autofocus>

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ $row->discount }}"  autocomplete="discount" autofocus>

                                @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input id="cost" type="number" class="form-control @error('cost') is-invalid @enderror" name="cost" value="{{ $row->cost }}"  autocomplete="cost" autofocus>

                                @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="charge">Charge</label>
                            <input id="charge" type="number" class="form-control @error('charge') is-invalid @enderror" name="charge" value="{{ $row->charge }}"  autocomplete="charge" autofocus>

                                @error('charge')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea id="remark" type="text" class="form-control @error('remark') is-invalid @enderror" name="remark"  autocomplete="remark" autofocus>{{ $row->remark }}</textarea>

                                @error('remark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="transaction_status">Transaction Status</label>
                            <div class="col-md-6">                               
                                @for ($i = 1; $i <= 3; $i++)
                                    <label class="radio-inline">
                                    <input type="radio" name="transaction_status" value="{{ $i }}" {{ ($row->transaction_status == $i ) ? 'checked':'' }} />
                                        @switch($i) @case(1) Pending @break @case(2) Progress @break @case(3) Complete @break @endswitch
                                    </label>
                                @endfor
                                <br>
                                @error('transaction_status')
                                    <b class="text-danger">{{ $message }}</b>
                                @enderror
                            </div>        
                        </div>
                        <div class="form-group">
                        <label for="transaction_type">Transaction Type</label>
                            <div class="col-md-6">
                                @for ($i = 1; $i <= 2; $i++)
                                    @switch($i) @case(1) @php $enum='in'; @endphp @break @case(2) @php $enum='out'; @endphp @break @endswitch
                                    <label class="radio-inline">
                                    <input type="radio" name="transaction_type" value="{{ $enum }}" {{ ( $row->transaction_type == $enum ? 'checked':'' ) }} /> {{ $enum }} </label>
                                @endfor
                                <br>
                                @error('transaction_type')
                                    <b class="text-danger">{{ $message }}</b>
                                @enderror
                            </div>        
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-primary">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection