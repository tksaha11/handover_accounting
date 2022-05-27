@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title pull-left m-auto">My All Customer List</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('mgs.index')
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Mobile</th>
                                    <th>Total Order Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data[0]))
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->bill_name }}</td>
                                            <td>{{ $item->bill_address }}</td>
                                            <td>{{ $item->bill_mobile }}</td>
                                            <td>{{ $item->total_order }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                   
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
           
            
        </div>{{-- card end --}}
    </div>
</section>
@endsection
