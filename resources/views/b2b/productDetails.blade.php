@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">

        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-11">
                            <h4 class="card-title pull-left m-auto">Add Product from Amardokan</h4>
                        </div>
                        <div class="col-1">
                            @include('b2b.cart.cart-icon')
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('mgs.index')
                    </div>
                    <div class="col-5 ">
                        @php
                            $img1=env('store_admin_url').'images/products/'.$data->id.'-1.jpg';
                            $img2=env('store_admin_url').'images/products/'.$data->id.'-2.jpg';
                            $img3=env('store_admin_url').'images/products/'.$data->id.'-3.jpg';

                            $noimage=env('store_admin_url').'images/products/noimage.jpg';

                            if(@getimagesize($img2))
                            {
                               $img2=$img2;
                            }
                            else
                            {
                                $img2=$noimage;
                            }
                            if(@getimagesize($img3))
                            {
                               $img3=$img3;
                            }
                            else
                            {
                                $img3=$noimage;
                            }
                        @endphp

                        <img class="img-fluid border shadow-sm" id="main_img" src="{{ $img1 }}">

                        <div class="row mt-1">
                            <div class="col-3 ">
                                <img class="img-fluid border shadow-sm img_change" src="{{ $img1 }}">
                            </div>

                            <div class="col-3">
                                <img class="img-fluid border shadow-sm img_change" src="{{$img2}}">
                            </div>

                            <div class="col-3">
                                <img class="img-fluid border shadow-sm img_change" src="{{ $img3 }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 mt-3  ml-1 text-left">
                        <div class="row">
                            <label class="mb-3">
                                <h3 class="text-center">{{ $data->title }}</h3>
                            </label>
                            <div class="mb-3">

                                <h5>{{ $data->description}}</h5>
                            </div>
                            <div class="mb-3">

                                <h5> ৳{{ $data->seller_price}}</h5>
                            </div>


                            <div class="mt-3 col-12">
                                <div class="product_content grid_content">
                                    <form method="post" action="{{ route('b2b-add-to-cart')}}">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                                        <input type="hidden" name="b2b_p_id" value="{{$data->b2b_p_id}}">

                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <a id="{{$data->id}}_increment" class="cart-click input-group-text add-to-cart-qty bg-dark text-white">+</a>
                                            </div>

                                            <input id="{{$data->id}}" name="pQty" type="number" class="form-control text-center" value="1" min="1" max="100" readonly="">

                                            <div class="input-group-append">
                                                <a id="{{$data->id}}_decrement" class="cart-click input-group-text add-to-cart-qty bg-dark text-white">-</a>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" id="{{$data->id}}_addToCart" name="submit"  class="add-to-cart btn btn-primary mt-2 col-12 text-white h5">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>


                        </div>
                    </div>
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

        //image change
        $(".img_change").click(function(){
            var img=$(this).attr('src');

            var check= img.split("-");

            if(check[1])
            {
                $("#main_img").attr('src',img);
            }
        });


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

