@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="alert alert-danger" role="alert">
            <h5 class="alert-heading text-center m-auto ">
                সরবরাহকারীদের নির্দেশনা অনুযায়ী পণ্যের দাম যেকোন সময় সংযোজন-বিয়োজন হতে পারে।
            </h5>
        </div>
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-4 m-auto font-weight-bold">
                    New Arrival - Purchase from Admin
                </div>
                <div class="col-7 flex-grow-1 search-bar m-auto">
                    <form method="get" action="{{ route('search-b2b-new-arrival')}}" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="input-group">
                            <div class="input-group-prepend search-arrow-back">
                                <button class="btn btn-search-back" type="button"><i class="bx bx-arrow-back"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control" placeholder="search" name='search_qry'>
                            <div class="input-group-append">
                                <button class="btn btn-search" type="submit"><i class="lni lni-search-alt"></i>
                                </button>
                            </div>
                        </div>
                    </form>
				</div>
                <div class="col-1">
                    @include('b2b.cart.cart-icon')
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('mgs.index')

                    @if(isset($data[0]))
                        @foreach ($data as $item)

                        <div class="col-lg-3 col-md-3 col-sm-3  col-6 text-center">
                            <div class="card p-1">

                                <a href="{{ route('b2b-product-details-view',['product_id'=>$item->id])}} ">
                                    <img class="img-fluid border shadow-sm mb-2" src="{{ env('store_admin_url').'images/products/'.$item->id.'-1.jpg'}}">
                                    <div class="h6">{{$item->title}}</div>
                                    <div class="h6">৳ {{$item->seller_price}}</div>
                                    <div class="text-muted">Unit MRP ৳<span id="unitMrp">{{$item->unit_mrp}}</span></div>
                                </a>

                                <div class="product_content grid_content">
                                    <form method="post" action="{{ route('b2b-add-to-cart')}}">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        {{-- <input type="hidden" name="product_id" value="{{$item->id}}" >
                                        --}}
                                        <input type="hidden" name="b2b_p_id" value="{{$item->b2b_p_id}}">

                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <a id="{{$item->id}}_increment" class="cart-click input-group-text add-to-cart-qty bg-dark text-white">+</a>
                                            </div>

                                            <input id="{{$item->id}}" name="pQty" type="number" class="form-control text-center" value="1" min="1" max="100" readonly="">

                                            <div class="input-group-append">
                                                <a id="{{$item->id}}_decrement" class="cart-click input-group-text add-to-cart-qty bg-dark text-white">-</a>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" id="{{$item->id}}_addToCart" name="submit"  class="add-to-cart btn btn-primary mt-2 col-12 text-white h5">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>


        </div>{{-- card end --}}
    </div>
</section>
@endsection

@section('js')
<script>

    $(document).ready(function(){

        //cart increment and decrement
        $(".cart-click").click(function(){
            let item_id_w=$(this).attr('id');
            let item_id_explide=item_id_w.split('_');

            let item_id='#'+item_id_explide[0];
            let pQty=parseInt($(item_id).val());

            if(item_id_explide[1]=='increment')
            {
                pQty=pQty+1;
                $(item_id).val(pQty);
            }
            else if(item_id_explide[1]=='decrement')
            {
                if(pQty>0)
                {
                    pQty=pQty-1;
                    $(item_id).val(pQty);
                }
            }

            //disabled and enabled add to cart button
            let addToCart=item_id+'_addToCart';
            if(pQty<=0)
            {
                $(addToCart).prop('disabled', true);
            }
            else
            {
                $(addToCart).prop('disabled', false);
            }
        });


    });
</script>
@endsection
