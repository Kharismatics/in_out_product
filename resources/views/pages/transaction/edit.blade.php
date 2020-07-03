@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">Edit Data</h5>
                    <hr>
                    <form action="{{ route('transactions.update', $row->id) }}" method="post">
		            	{{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group text-center">
                            <label for="transaction_type">@lang('text.transaction_type')</label>
                            <div class="col-md-12">
                                @for ($i = 1; $i <= 2; $i++)
                                    @switch($i) @case(1) @php $enum='in'; @endphp @break @case(2) @php $enum='out'; @endphp @break @endswitch
                                    <label class="radio-inline">
                                    <input type="radio" name="transaction_type" value="{{ $enum }}" {{ ( $row->transaction_type == $enum ? 'checked':'' ) }} /> {{ ( $enum = 'in' == $enum ? __('text.purchase') : __('text.sales') ) }} </label>
                                @endfor
                                <br>
                                @error('transaction_type')
                                    <b class="text-danger">{{ $message }}</b>
                                @enderror
                            </div>        
                        </div>
                        <div class="form-group transaction_in">
                            <label for="product_id">@lang('text.select') @lang('text.product')</label>
                            <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id">
                                <option value=""> -- @lang('text.select_one') (@lang('text.optional')) -- </option>
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
                        <div class="form-group transaction_out">
                            <label for="product_id">@lang('text.select') @lang('text.transaction') Ref</label>
                            <select class="form-control @error('transaction_id') is-invalid @enderror" id="transaction_id" name="transaction_id">
                                <option value=""> -- @lang('text.select_one') (@lang('text.optional')) -- </option>
                                @foreach($transactions as $transaction)
                                <option value="{{$transaction->id}}" {{ $row && ($row->transaction_id == $transaction->id) ? 'selected':'' }}> {{ $transaction->unique_code }}</option>
                                @endforeach
                            </select>
                                @error('transaction_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div> 
                        <div class="form-group transaction_in transaction_out">
                            <label for="people_id">@lang('text.select') @lang('text.people')</label>
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
                        <div class="form-group transaction_in transaction_out">
                            <label for="transaction_date">@lang('text.transaction_date')</label>
                            <input id="transaction_date" type="text" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" value="{{ $row->transaction_date }}" autocomplete="off" autofocus>

                                @error('transaction_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                 
                        <div class="form-group transaction_in transaction_out">
                            <label for="base_price">@lang('text.base_price')</label>
                            <input id="base_price" type="number" class="form-control @error('base_price') is-invalid @enderror" name="base_price" value="{{ $row->base_price }}"  autocomplete="base_price" autofocus>

                                @error('base_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group transaction_out">
                            <label for="price">@lang('text.price')</label>
                            <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $row->price }}"  autocomplete="price" autofocus>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group transaction_in transaction_out">
                            <label for="quantity">@lang('text.quantity')</label>
                            <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ $row->quantity }}"  autocomplete="quantity" autofocus>

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group transaction_out">
                            <label for="discount">@lang('text.discount')</label>
                            <input id="discount" type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ $row->discount }}"  autocomplete="discount" autofocus>

                                @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group transaction_out">
                            <label for="cost">@lang('text.cost')</label>
                            <input id="cost" type="number" class="form-control @error('cost') is-invalid @enderror" name="cost" value="{{ $row->cost }}"  autocomplete="cost" autofocus>

                                @error('cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group transaction_out">
                            <label for="charge">Charge</label>
                            <input id="charge" type="number" class="form-control @error('charge') is-invalid @enderror" name="charge" value="{{ $row->charge }}"  autocomplete="charge" autofocus>

                                @error('charge')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group transaction_in transaction_out">
                            <label for="remark">@lang('text.remark')</label>
                            <textarea id="remark" type="text" class="form-control @error('remark') is-invalid @enderror" name="remark"  autocomplete="remark" autofocus>{{ $row->remark }}</textarea>

                                @error('remark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group transaction_in transaction_out">
                            <label for="transaction_status">@lang('text.transaction_status')</label>
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
                            <button type="submit" class="btn btn-success">@lang('text.save')</button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-primary">@lang('text.back')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#transaction_date').datepicker({
            setDate: new Date(),
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            format: "dd M yyyy",
            minViewMode: 'month' 
        });
        
        @if (!$row->transaction_type)
            $('.transaction_in,.transaction_out').addClass('d-none');
        @else 
            @if ($row->transaction_type == 'in')
                $('.transaction_out').addClass('d-none'); 
                $('.transaction_in').removeClass('d-none'); 
            @endif
            @if ($row->transaction_type == 'out')
                $('.transaction_in').addClass('d-none'); 
                $('.transaction_out').removeClass('d-none'); 
            @endif
        @endif

        $("select[name='product_id']").change(function(){
            $("input[name='base_price']").val('')
            if ($(this).val()!='') {	
                var id = $(this).val();
                var products = @json($products, JSON_PRETTY_PRINT);
                var item = $.grep(products, function(e){ return e.id == id; });
                $.each(item, function (indexInArray, valueOfElement) { 
                    $("input[name='base_price']").val(valueOfElement.base_price)
                });
            }		
        });
        $("select[name='transaction_id']").change(function(){
            $("input[name='base_price']").val('')
            $("input[name='price']").val('')
            if ($(this).val()!='') {	
                var id = $(this).val();
                var transactions = @json($transactions, JSON_PRETTY_PRINT);
                var item = $.grep(transactions, function(e){ return e.id == id; });
                $.each(item, function (indexInArray, valueOfElement) { 
                    $("input[name='base_price']").val(valueOfElement.base_price)
                    $("input[name='price']").val(valueOfElement.product.price)
                });
            }		
        });
    });
    $("input[name='transaction_type']").change(function(){
        if ($(this).val()=='in') {	
            $('.transaction_out').addClass('d-none'); 
            $('.transaction_in').removeClass('d-none'); 
        }
        else { 
            $('.transaction_in').addClass('d-none'); 
            $('.transaction_out').removeClass('d-none'); 
        }				
    });
    $("input[name='product_id']").change(function(){
        if ($(this).val()!='') {	
            var products = @json($products, JSON_PRETTY_PRINT);
        }			
    });
</script>
@endsection