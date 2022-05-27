@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                @include('mgs.index')
                <div class="m-4">
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <img src="{{ asset('assets\images\logo\logo.png') }}" class="img-center p-4 w-80" > 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    Invoice No: <span class="invoice-invoice-no">{{$invoiceData->invoice}}</span>
                                </div>
                                <div class="col-6 invoice-invoice-text-right">
                                    <span class="invoice-invoice-date">{{date("j M, Y, h:i", strtotime($invoiceData->date_time))}}</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 ">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col border invoice-field">Invoice No: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">{{$invoiceData->invoice}}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col border invoice-field">Payment Method: </div>
                                        <div class="col  border invoice-field invoice-invoice-text-left">{{$invoiceData->payment_method}}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col border invoice-field">Order Date: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">{{date("j M, Y", strtotime($invoiceData->date_time))}}</div>
                                    </div>
                                </div>
                                <div class="col-6 border">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col border invoice-field">Bill To: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">{{$invoiceData->del_name}} </div>
                                    </div>
                                    <div class="row border">
                                        <div class="col  invoice-field">Address: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">
                                            <p>{{$invoiceData->del_address}}</p>    
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col border invoice-field">Phone: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">{{$invoiceData->del_mobile}}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col border invoice-field">Deliver To: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">{{$invoiceData->del_name}} </div>
                                    </div>
                                    <div class="row border">
                                        <div class="col  invoice-field">Address: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">
                                            <p>{{$invoiceData->del_address}}</p>    
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col border invoice-field">Phone: </div>
                                        <div class="col border invoice-field invoice-invoice-text-left">{{$invoiceData->del_mobile}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="row border">
                                <div class="col-12 invoice-field">
                                    Your Order Items
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col border invoice-field field-bold">
                                    NO
                                </div>
                                <div class="col border invoice-field field-bold">
                                    Product Name
                                </div>
                                <div class="col border invoice-field field-bold">
                                    Price
                                </div>
                                <div class="col border invoice-field field-bold">
                                    QTY
                                </div>
                                <div class="col border invoice-field field-bold">
                                    Sub Total 
                                </div>
                            </div>
                            @php
                                $subTotal=0;
                            @endphp
                            @foreach ($orderData as $item)
                                
                                @php
                                    $subTotal+=$item->sub_total;
                                @endphp
                                <div class="row text-center">
                                    <div class="col border invoice-field">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div class="col border invoice-field">
                                       {{ $item->title }}
                                    </div>
                                    <div class="col border invoice-field">
                                        {{ $item->seller_price }}
                                    </div>
                                    <div class="col border invoice-field">
                                        {{ $item->qty }}

                                    </div>
                                    <div class="col border invoice-field">
                                        {{ $item->sub_total }}

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            {{-- <div class="row">
                                <div class="col-10 invoice-invoice-text-right border invoice-field">Sub Total</div>
                                <div class="col-2 invoice-invoice-text-right border invoice-field">{{$subTotal}}</div>
                            </div> --}}
                            
                            <div class="row">
                                <div class="col-10 invoice-invoice-text-right border invoice-field">Total</div>
                                <div class="col-2 invoice-invoice-text-center border invoice-field">{{$subTotal}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 mt-4">
                            <div class="row text-center h4 field-bold">
                                <div class="col">
                                    <span>Terms & Conditions</span>
                                </div>
                            </div>
                            <div class="row text-center h6">
                                <div class="col">
                                    <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   

@endsection


@section('js')
    <script src="{{ asset('assets/js/images/imageshow.js') }}"> </script>
  
@endsection