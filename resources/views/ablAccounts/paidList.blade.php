@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12 text-center h3">
                    Paid List
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
                                    <th>ABl Comission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data[0]))
                                    @php
                                        $tot_amt=0;
                                        $tot_com=0;
                                    @endphp
                                    @foreach ($data as $item)
                                        @php
                                            $tot_amt+=($item->total);
                                            $tot_com+=$item->comission;
                                        @endphp
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
                                    <tr>
                                        <td class="text-right" colspan="6"><strong>Total</strong></td>
                                        <td>{{$tot_amt}}</td>
                                        <td>{{$tot_com}}</td>
                                    </tr>
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
