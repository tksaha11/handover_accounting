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

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            @include('mgs.index')
                        </div>
                        <div class="col-5 ">
                            @php
                                $img1 = env('store_admin_url') . 'images/products/' . $data->id . '-1.jpg';
                                $img2 = env('store_admin_url') . 'images/products/' . $data->id . '-2.jpg';
                                $img3 = env('store_admin_url') . 'images/products/' . $data->id . '-3.jpg';

                                $noimage = env('store_admin_url') . 'images/products/noimage.jpg';

                                if (@getimagesize($img2)) {
                                    $img2 = $img2;
                                } else {
                                    $img2 = $noimage;
                                }
                                if (@getimagesize($img3)) {
                                    $img3 = $img3;
                                } else {
                                    $img3 = $noimage;
                                }
                            @endphp

                            <img class="img-fluid border shadow-sm" id="main_img" src="{{ $img1 }}">

                            <div class="row mt-1">
                                <div class="col-3 ">
                                    <img class="img-fluid border shadow-sm img_change"  src="{{ $img1 }}">
                                </div>

                                <div class="col-3">
                                    <img class="img-fluid border shadow-sm img_change"  src="{{ $img2 }}">
                                </div>

                                <div class="col-3">
                                    <img class="img-fluid border shadow-sm img_change" src="{{ $img3 }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mt-3 ml-1">
                            <div class="row">
                                <label class="mb-3">
                                    <h3 class="text-center">{{ $data->title }}</h3>
                                </label>
                                <div class="mb-3">

                                    <h5>{{ $data->description }}</h5>
                                </div>


                                <div class="mt-3 col-12 text-center">
                                    <a href="#" id="addToShop {{ $data->id }}" data-toggle="modal"
                                        data-target="#priceModal{{ $data->id }}"
                                        class="card-footer bg-info text-center ">
                                        <span class="h6 text-light">
                                            Add to Shop
                                        </span>
                                    </a>
                                </div>

                                {{-- start modal --}}
                                <div class="modal fade" id="priceModal{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content radius-30">
                                            <div class="modal-header border-bottom-0">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"> <span aria-hidden="true">×</span>
                                                </button>
                                            </div>

                                            <div class="modal-body pb-5 pl-5 pr-5">
                                                <form method="post" action="{{ route('add-product-from-amardokan') }}">

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="product_id" value="{{ $data->id }}">
                                                    <input type="hidden" name="unit_mrp" value="{{ $data->unit_mrp }}">
                                                    <input type="hidden" name="title" value="{{ $data->title }}">

                                                    <div class="form-group">
                                                        <label>Your Sales Price (Must Not Be Greated Than:
                                                            {{ $data->unit_mrp }} TK)</label>
                                                        <input type="number" class="form-control form-control-lg radius-30"
                                                            name="sale_price" required value=0>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Amar Bazar Percentage(%)</label>
                                                        <input type="number" class="form-control form-control-lg radius-30"
                                                            name="abl_com_amnt" required value=1>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Give Initial Stock</label>
                                                        <input type="number" class="form-control form-control-lg radius-30"
                                                            name="stock" required value=1>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit"
                                                            class="btn btn-info radius-30 btn-lg btn-block ">Add</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- end modal --}}
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
        $(document).ready(function() {

            //image change
            $(".img_change").click(function() {
                var img = $(this).attr('src');

                var check = img.split("-");

                if (check[1]) {
                    $("#main_img").attr('src', img);
                }
            });
        });
    </script>
@endsection
