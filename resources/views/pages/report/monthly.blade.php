@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daily Report</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>People</th>
                                <th>Product</th>
                                <th>Transaction</th>
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
                                        <td>{{$row->people}}</td>
                                        <td>{{$row->product}}</td>
                                        <td>{{$row->transaction_type}}</td>
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