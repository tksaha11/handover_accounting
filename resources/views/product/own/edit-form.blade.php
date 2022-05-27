@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">

    <div class="page-content">
        
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title pull-left">Edit Own Product</h3>
                        </div>
                        <div class="col-md-4 text-right">
                            <a class="btn btn-primary" href="{{ route('own-product-list') }}"> OWN Product List</a>
                        </div>

                        <div class="col-md-12">
                            @if (session('warning'))
                                <span class="alert alert-danger d-block" role="alert">
                                    <strong>{{ session('warning') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
           
            <form method="post" action="{{ route('edit-own-product') }}" enctype="multipart/form-data">
                {{-- @csrf --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="product_id" value="{{ $data->id }}">
                <input type="hidden" name="store_p_id" value="{{ $data->store_p_id }}">

                <input type="hidden" name="old_title" value="{{ $data->title }}">


                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <small>Title</small><span class="text-danger">*</span>
                            <input class="form-control" name="title" rows="1" required value="{{ $data->title }} ">
                        </div>
                        <div class="form-group col-md-12">
                            <small>Long Description</small>
                            <textarea class="form-control" name="description" rows="2" required>{{ $data->description }} </textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Barcode</small>
                            <input  type="text" class="form-control" name="barcode" value="{{ $data->barcode }}">
                        </div>
                        <div class="form-group col-md-6">
                            <small>Category </small><span class="text-danger">*</span>
                            <select class="form-control" name="category" required>
                                <option>{{$data->category}}</option>
                                <option>Electronics</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Sub Category </small><span class="text-danger">*</span>
                            <select class="form-control" name="sub_category" required>
                                <option>{{$data->sub_category}}</option>
                                <option>TV</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Color </small>
                            <select class="form-control" name="color">
                                <option>{{$data->color}}</option>

                                <option>White</option>
                                <option>Yellow</option>
                                <option>Red</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Size </small>
                            <select class="form-control" name="size" >
                            </select>
                        </div>
                        
                                                  
                        <div class="form-group col-md-6">
                            <small>MRP Price</small><span class="text-danger">*</span>
                            <input  type="number" class="form-control" name="unit_mrp" value="{{ $data->unit_mrp }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <small>Sale Price</small><span class="text-danger">*</span>
                            <input  type="number" class="form-control" name="sale_price" value="{{ $data->sale_price }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <small>ABL Percentage</small><span class="text-danger">*</span>
                            @php
                                $percen100=$data->sale_price;
                                $percen1=100/$percen100;
                                $percenMain=$data->abl_com_amnt*$percen1;
                            @endphp
                            <input  type="number" class="form-control" name="abl_com_amnt" value="{{ round($percenMain,2) }}" min='1' required>
                        </div>
                        <div class="form-group col-md-4">
                            <small>Initial  Stock</small><span class="text-danger">*</span>
                            <input  type="number" class="form-control" name="stock" value="{{ $data->stock }}" required>
                        </div>
                       
                         @php

                            $img1="assets/images/products/".$data->id.'-1.jpg';
                            $img2="assets/images/products/".$data->id.'-2.jpg';
                            $img3="assets/images/products/".$data->id.'-3.jpg';
                            if (!@getimagesize($img1)) 
                                $img1="assets/images/noimage.jpg";
                            if (!@getimagesize($img2)) 
                                $img2="assets/images/noimage.jpg";
                            if (!@getimagesize($img3)) 
                                $img3="assets/images/noimage.jpg";

                         @endphp
                        <div class="form-group col-md-4">
                            <small>Main Image</small>
                            <input type="file" class="form-control" name="img1" onChange="dynamic(this,'imgshow1')">
                            @if(session('img'))
                                <p class='text-danger'></p>
                            @endif
                            <div class="form-group text-center">
                                <img src="{{asset($img1)}}" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow1" >
                            </div>
                        </div>
                        
                       
                        <div class="form-group col-md-4">
                            <small>Image</small>
                            <input type="file" class="form-control" name="img2" onChange="dynamic(this,'imgshow2')">
                            @if(session('img'))
                                <p class='text-danger'></p>
                            @endif
                            <div class="form-group text-center">
                                <img src="{{asset($img2)}}" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow2" >
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <small>Image</small>
                            <input type="file" class="form-control" name="img3" onChange="dynamic(this,'imgshow3')">
                            @if(session('img'))
                                <p class='text-danger'></p>
                            @endif
                            <div class="form-group text-center">
                                <img src="{{asset($img3)}}" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow3" >
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" name="add" class="btn btn-primary form-control">Send Request</button>
                </div>
            </form>
        </div>{{-- card end --}}
    </div>
</section>
@endsection


@section('js')
    <script src="{{ asset('assets/js/images/imageshow.js') }}"> </script>
  
@endsection