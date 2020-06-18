@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">Edit Data</div>

                <div class="card-body">

                    <form action="{{ route('products.update', $row->id) }}" method="post">
		            	{{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="unique_code">Unique Code</label>
                            <input id="unique_code" type="text" class="form-control @error('unique_code') is-invalid @enderror" name="unique_code" value="{{ $row->unique_code }}"  autocomplete="unique_code" autofocus>

                                @error('unique_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $row->name }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="category_id">Select Category</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ $row && ($row->category_id == $category->id) ? 'selected':'' }}> {{ $category->name }}</option>
                                @endforeach
                            </select>
                                @error('category_id')
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
                            <label for="description">Description</label>
                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $row->description }}"  autocomplete="description" autofocus>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection