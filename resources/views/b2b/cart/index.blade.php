@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">

        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-4 m-auto font-weight-bold text-center">
                    Cart - Purchase from Admin
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('mgs.index')
                    <div class="col">
                    <form method="post" action="{{ route('confirm-b2b-order') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>QTY</th>
                                        <th>Abl Comission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($data[0]))
                                        @php
                                            $totAmt=0;
                                        @endphp
                                        @foreach ($data as $item)

                                            @php
                                                $totAmt+=$item->seller_price*$item->qty;
                                            @endphp
                                            <tr id="{{$item->id}}_tr">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ env('store_admin_url').'images/products/'.$item->id.'-1.jpg'}}" height="100px" width="100px">
                                                </td>
                                                <td>
                                                    {{ $item->title }}
                                                </td>
                                                <td >
                                                    ৳ <span id="{{$item->id}}_seller_price">{{ $item->seller_price }}</span>
                                                </td>
                                                <td>
                                                    <div class="product_content grid_content">
                                                        <div class="input-group px-4 ">
                                                            <input type="hidden" name="b2b_cart_id" id="{{$item->id}}_b2b_cart_id" value="{{$item->b2b_cart_id}}">

                                                            <div class="input-group-prepend ">
                                                                <a  id="{{$item->id}}_increment" class="cart-click input-group-text add-to-cart-qty  bg-primary text-white">+</a>
                                                            </div>
                                                            <input id="{{$item->id}}" name="pQty" type="number" class="form-control text-center" value="{{$item->qty}}" min="1" max="100" readonly="">
                                                            <div class="input-group-append">
                                                                <a  id="{{$item->id}}_decrement" class="cart-click input-group-text add-to-cart-qty bg-primary text-white">-</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product_content grid_content">
                                                        <div class="input-group px-4 ">
                                                            <input type="number" name="abl_comission[{{$item->b2b_p_id}}]" class="form-control text-center" value="1" min="1" max="100">
                                                            <h4 class="ml-2">%</h4>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i id="{{$item->id}}_remove" class="remove-cart fadeIn animated bx bx-trash h4 btn"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-primary req">
                                            <td class="h4 text-light" colspan="5">
                                                Total
                                            </td>
                                            <td class="h4 text-light totAmt"  colspan="2">
                                                ৳ <span id="totAmt">{{$totAmt}}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row float-right mt-3 mr-2 req">
                            <button  type="submit" class="btn btn-primary m-1 px-5 py-2 radius-30 shadow-md">Confirm Requisition</button>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>{{-- card end --}}
    </div>
</section>
@endsection

@section('js')
<script>

    $(document).ready(function(){
        //for hide total amount
        var rowCount = $('#myTable tbody tr').length-1
        if(rowCount<=0)
        {
            $('.req').hide();
        }

        $('.remove-cart').click(function(){
            let item_id_w=$(this).attr('id');
            let item_id_explide=item_id_w.split('_');
            let item_id='#'+item_id_explide[0];

            //change in db
            let b2b_cart_id_id=item_id+'_b2b_cart_id';
            let b2b_cart_id=$(b2b_cart_id_id).val();
            // alert(b2b_cart_id);
            $.ajax({
                    type:'POST',
                    url: "{{ url('/remove-from-b2b-cart') }}",
                    data:{
                        b2b_cart_id:b2b_cart_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(result){
                        // console.log('Item added in your cart');
                        console.log(result);
                        // location.reload('true');
                    }
            });

           //remove table row
            let tr_action="tr"+item_id+"_tr";
            $(tr_action).remove();

           //for hide total amount
           var rowCount = $('#myTable tbody tr').length-1

           console.log(rowCount)
            if(rowCount<=0)
            {
                $('.req').hide();
            }

        });


        //cart increment and decrement
        $(".cart-click").click(function(){

            let item_id_w=$(this).attr('id');
            let item_id_explide=item_id_w.split('_');

            let item_id='#'+item_id_explide[0];
            let pQty=parseInt($(item_id).val());


            //For Change total amount
            let totAmt=parseInt($('#totAmt').html());
            let seller_price_id=item_id+'_seller_price';
            let seller_price=parseInt($(seller_price_id).html());

            let update_type=1;
            if(item_id_explide[1]=='increment')
            {
                //qty increment
                pQty=pQty+1;
                $(item_id).val(pQty);

                //total amount change
                $("#totAmt").html(totAmt+seller_price);

            }
            else if(item_id_explide[1]=='decrement')
            {
                if(pQty>0)
                {
                    update_type=-1;
                    //qty decrement
                    pQty=pQty-1;
                    $(item_id).val(pQty);

                    //total amount change
                    $("#totAmt").html(totAmt-seller_price);
                }
            }

            //change in db
            let b2b_cart_id_id=item_id+'_b2b_cart_id';
            let b2b_cart_id=$(b2b_cart_id_id).val();
            // alert(b2b_cart_id);
            $.ajax({
                    type:'POST',
                    url: "{{ url('/update-b2b-cart') }}",
                    data:{
                        b2b_cart_id:b2b_cart_id,
                        update_type: update_type,
                        _token: "{{ csrf_token() }}"
                    },
                    success:function(result){
                        // console.log('Item added in your cart');
                        console.log(result);
                        // location.reload('true');
                    }
            });

            //remove table row. from cart show list.
            if(pQty<=0)
            {
                let tr_action="tr"+item_id+"_tr";
                $(tr_action).remove();
            }


            //for hide total amount
            var rowCount = $('#myTable tbody tr').length-1
            if(rowCount<=0)
            {
                $('.req').hide();
            }
        });


    });
</script>
@endsection
