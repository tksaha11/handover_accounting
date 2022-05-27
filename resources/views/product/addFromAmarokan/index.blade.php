@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">  
    <div class="page-content">
        
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title pull-left m-auto">Add Product from Amardokan</h4>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="card-header">
                <form method="get" action="{{ route('search-amardokan-product-for-add') }}" class="row">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-12 col-md-3">
                        <div class="form-group m-auto">
                            <select class="form-control form-control text-center" name="category" id="category">
                                <option value="0">Category</option>
                                @if (isset($catInfo[0]))
                                    @foreach ($catInfo as $cat)
                                        <option class="text-left" value="{{ $cat->name }}">{{ $cat->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group m-auto">
                            <select class="form-control form-control text-center" name="sub_category" id="sub_category">
                                <option value=0>Sub Category</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group m-auto">
                            <input type="search" class="form-control text-center" placeholder="Product Name" name="title">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-info col">Find</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('mgs.index')
                    </div>
                    @if(isset($data[0]))
                        @foreach ($data as $item)
                            <div class="col-6 col-md-3">
                                <div class="card shadow-lg">
                                    <a href="{{ route('amardokan-product-details-view',['product_id'=>$item->id])}}">
                                        <div>
                                            <img src="{{env('store_admin_url').'images/products/'.$item->id.'-1.jpg'}}" class="img-fluid">
                                        </div>
                                        <div class="card-body ">
                                            @php
    
                                                $title=$item->title;
                                            @endphp
                                            <h6 class="">{{$title}}</h6>
                                        </div>
                                    </a>
                                    
                                    <a href="#" id="addToShop {{$item->id}}" data-toggle="modal" data-target="#priceModal{{$item->id}}" class="card-footer bg-info text-center ">
                                        <span class="h6 text-light">
                                            Add to Shop
                                        </span> 
                                    </a>
                                </div>

                                {{-- start modal --}}
                                <div class="modal fade" id="priceModal{{$item->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content radius-30">
                                            <div class="modal-header border-bottom-0">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            
                                            <div class="modal-body pb-5 pl-5 pr-5">
                                                <form method="post" action="{{ route('add-product-from-amardokan') }}" >

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="product_id" value="{{$item->id}}">
                                                    <input type="hidden" name="unit_mrp" value="{{$item->unit_mrp}}">
                                                    <input type="hidden" name="title" value="{{$item->title}}">

                                                    <div class="form-group">
                                                        <label>Your Sales Price (Must Not Be Greated Than: {{$item->unit_mrp}} TK)</label>
                                                        <input type="number" class="form-control form-control-lg radius-30" name="sale_price" required value=0>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Amar Bazar Percentage(%)</label>
                                                        <input type="number" class="form-control form-control-lg radius-30" name="abl_com_amnt" required value=1>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Give Initial Stock</label>
                                                        <input type="number" class="form-control form-control-lg radius-30" name="stock" required value=1>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-info radius-30 btn-lg btn-block " >Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- end modal --}}
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
        $(document).ready(function() {

            $("#category").change(function() {
                let cat = $("#category").val();
                $('#sub_category').html('<option default value=0>Sub Category</option>');
                $.ajax({
                    type: 'GET',
                    url: "get-sub-category/" + cat,

                    success: function(result) {
                        console.log(result);
                        $.each(result, function(i, item) {

                            $('#sub_category').append($("<option>", {
                                value: item.name,
                                text: item.name
                            }));
                            $('#sub_category option').addClass('text-left');
                        });
                    }
                });
            });
        });
    </script>
@endsection