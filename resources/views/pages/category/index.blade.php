@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="card-header">Master Category <div class="float-right"><a href='{{ route('category.create') }}' class='edit-data btn btn-success' data-toggle='tooltip' title='Edit'>Add <i class='fas fa-plus'></i></a></div></div>

                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if (count($rows) == 0)
                                <tr>
                                    <td colspan="4"><center>Data Empty</center></td>
                                </tr>
                            @endif
                            @foreach ($rows as $index => $row)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->description}}</td>
                                    <td class="text-center form-inline">
                                        <a href='{{ route('category.edit', $row->id) }}' class='edit-data btn btn-warning' data-toggle='tooltip' title='Edit'><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('category.destroy', $row->id) }}" method="POST">
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
<script type="application/javascript"> 
</script>
@endsection