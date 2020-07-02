@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <h5 class="card-title">@lang('text.add') Data</h5>
                    <hr>
                    <form action="{{ route('category.store') }}" method="post">
                        @csrf 
                        <div class="form-group">
                            <label for="name">@lang('text.name')</label>
                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('text.description')</label>
                            <input id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}"  autocomplete="description" autofocus>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">@lang('text.save')</button>
                            <a href="{{ route('category.index') }}" class="btn btn-primary">@lang('text.back')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection