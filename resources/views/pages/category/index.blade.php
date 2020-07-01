@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card-header">Master @lang('text.category') <div class="float-right"><a href='{{ route('category.create') }}' class='edit-data btn btn-success' data-toggle='tooltip' title='Edit'>@lang('text.add') <i class='fas fa-plus'></i></a></div></div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th>#</th>
                                <th>@lang('text.name')</th>
                                <th>@lang('text.description')</th>
                                <th class="text-center" style="width:10%">@lang('text.action')</th>
                            </thead>
                            <tbody>
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index +1 }}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->description}}</td>
                                        <td class="text-center form-inline">
                                            <a href='{{ route('category.edit', $row->id) }}' class='edit-data btn btn-warning' data-toggle='tooltip' title='Edit'><i class="fas fa-edit"></i></a>
                                            <form id="delete-form" action="{{ route('category.destroy', $row->id) }}" method="POST">
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
                                <th>@lang('text.name')</th>
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