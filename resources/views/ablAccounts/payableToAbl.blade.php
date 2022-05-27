@extends('main.header-footer')
@section('main_content')

@php
    $totalDelivered=0;
    $totalComission=0;

    foreach($data as $orders){
        $totalComission=$totalComission+$orders->comission;
        $totalDelivered=$totalDelivered+($orders->total);
    }
@endphp

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="card bg-success p-3 text-center">
                                <span class="h6 d-block font-weight-bold">TOTAL DELIVERED</span>
                                <span class="h6 d-block font-weight-bold">{{$totalDelivered}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="card bg-warning p-3 text-center">
                                <span class="h6 d-block font-weight-bold">TOTAL COMMISSION</span>
                                <span class="h6 d-block font-weight-bold">{{$totalComission}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="card bg-primary p-4 text-center">
                                @php 
                                    $url="/ablcomission/payment/".session('store-id'); 
                                    $disable="";
                                    if($totalComission<=0){
                                        $disable="pointer-events: none";
                                    }    
                                @endphp
                                <a href="{{ $url }}" class="btn btn-danger" style="{{$disable}}">Pay Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Bill Name</th>
                                    <th>Item Name</th>
                                    <th>Unit Price</th>
                                    <th>QTY</th>
                                    <th>Total</th>
                                    <th>ABL Comission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data[0]))
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->invoice}}</td>
                                            <td>{{ date('Y-m-d',strtotime($item->date))}}</td>
                                            <td>{{ $item->bill_name}}</td>
                                            <td>{{ $item->name}}</td>
                                            <td>{{ $item->unit_price}}</td>
                                            <td>{{ $item->qty}}</td>
                                            <td>{{ $item->total}}</td>

                                            <td>{{ $item->comission}}</td>
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
