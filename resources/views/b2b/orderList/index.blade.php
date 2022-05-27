@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-4 m-auto font-weight-bold text-center">
                    Order List - Purchase from Admin
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('mgs.index')
                    <div class="col">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice No</th>
                                        <th>Order Date</th>
                                        <th>Total Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{$item->invoice}} 
                                                </td>
                                                <td>
                                                    {{$item->date_time}}
                                                </td>
                                                <td>
                                                    {{$item->tot_qty}}
                                                </td>
                                                <td>
                                                    {{$item->tot_amt}}

                                                </td>
                                                <td>
                                                    {{$item->status}}
                                                </td>
                                                <td class="text-primary">
                                                    <a href="{{ route('b2b-order-invoice',['invoice'=>$item->invoice]) }}" target="_blank" rel="noopener noreferrer">
                                                        <i class="bx bx-file h4"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{-- card end --}}
    </div>
</section>
@endsection


@section('js')
    <script src="{{ asset('assets/js/images/imageshow.js') }}"> </script>
  
@endsection