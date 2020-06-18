@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Master People <div class="float-right"><a href='{{ route('peoples.create') }}' class='edit-data btn btn-success' data-toggle='tooltip' title='Edit'>Add <i class='fas fa-plus'></i></a></div></div>

                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if (count($rows) == 0)
                                <tr>
                                    <td colspan="6"><center>Data Empty</center></td>
                                </tr>
                            @endif
                            @foreach ($rows as $index => $row)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>{{$row->phone}}</td>
                                    <td>{{$row->address}}</td>
                                    <td class="text-center form-inline">
                                        <a href='{{ route('peoples.edit', $row->id) }}' class='edit-data btn btn-warning' data-toggle='tooltip' title='Edit'><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('peoples.destroy', $row->id) }}" method="POST">
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