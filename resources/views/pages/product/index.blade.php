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
                    <h5 class="card-title">Master @lang('text.product') <div class="float-right"><a href='{{ route('products.create') }}' class='edit-data btn btn-success' data-toggle='tooltip' title='Edit'>@lang('text.add') <i class='fas fa-plus'></i></a></div></h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table DataTables">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.code')</th>
                                <th>@lang('text.name')</th>
                                <th>@lang('text.category')</th>
                                <th>@lang('text.base_price')</th>
                                <th>@lang('text.price')</th>
                                <th>@lang('text.description')</th>
                                <th class="text-center" style="width:10%">@lang('text.action')</th>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{$row->unique_code}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>@if($row->category) {{$row->category->name}} @endif </td>
                                        <td>{{$row->base_price}}</td>
                                        <td>{{$row->price}}</td>
                                        <td>{{$row->description}}</td>
                                        <td class="text-center form-inline">
                                            <a href='{{ route('products.edit', $row->id) }}' class='edit-data btn btn-warning' data-toggle='tooltip' title='Edit'><i class="fas fa-edit"></i></a>
                                            <form class="delete-form" action="{{ route('products.destroy', $row->id) }}" method="POST">
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
                                <th>@lang('text.code')</th>
                                <th>@lang('text.name')</th>
                                <th>@lang('text.category')</th>
                                <th>@lang('text.base_price')</th>
                                <th>@lang('text.price')</th>
                                <th>@lang('text.description')</th>
                                <th class="text-center" style="width:10%">@lang('text.action')</th>
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