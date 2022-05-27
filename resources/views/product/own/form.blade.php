@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
  
    <div class="page-content">
        
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title pull-left">Request For Own Product</h3>
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
           
            <form method="post" action="{{ route('insert-own-product') }}" enctype="multipart/form-data">
               
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <small>Title</small><span class="text-danger">*</span>
                            <input class="form-control" name="title" rows="1" required value="{{ old('title') }} ">
                        </div>
                        <div class="form-group col-md-12">
                            <small>Long Description</small>
                            <textarea class="form-control" name="description" rows="2" required>{{ old('description') }} </textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Barcode</small>
                            <input  type="text" class="form-control" name="barcode" value="{{ old('barcode') }}">
                        </div>
                        <div class="form-group col-md-6">
                            <small>Category </small><span class="text-danger">*</span>
                            <select class="form-control" name="category" id="category" required>
                                <option>Select</option>
                                @if (isset($catInfo[0]))
                                    @foreach ($catInfo as $cat)
                                        <option class="text-left" value="{{ $cat->name }}">{{ $cat->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Sub Category </small><span class="text-danger">*</span>
                            <select class="form-control" name="sub_category" id="sub_category" required>
                                <option>TV</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Color </small>
                            <select class="form-control" name="color">
                                <option>Select</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <small>Size </small>
                            <select class="form-control" name="size" >
                            </select>
                        </div>
                        
                                                  
                        <div class="form-group col-md-6">
                            <small>MRP Price</small><span class="text-danger">*</span>
                            <input  type="number" class="form-control" name="unit_mrp" value="{{ old('unit_mrp') }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <small>Sale Price</small><span class="text-danger">*</span>
                            <input  type="number" class="form-control" name="sale_price" value="{{ old('sale_price') }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <small>ABL Percentage</small><span class="text-danger">*</span>
                            <input  type="number" class="form-control" name="abl_com_amnt" value="{{ old('abl_com_amnt') }}" min='1' required>
                        </div>
                        <div class="form-group col-md-4">
                            <small>Initial  Stock</small><span class="text-danger">*</span>
                            <input  type="number" class="form-control" name="stock" value="{{ old('stock') }}" required>
                        </div>
                       
                        
                        
                         @php
                             $img="assets/images/noimage.jpg";
                         @endphp
                        <div class="form-group col-md-4">
                            <small>Main Image</small><span class="text-danger">*</span>
                            <input type="file" class="form-control" name="img1" onChange="dynamic(this,'imgshow1')" required>
                            @if(session('img'))
                                <p class='text-danger'>{{session('img1')}}</p>
                            @endif
                            <div class="form-group text-center">
                                <img src="{{asset($img)}}" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow1" >
                            </div>
                        </div>
                        
                       
                        <div class="form-group col-md-4">
                            <small>Image</small>
                            <input type="file" class="form-control" name="img2" onChange="dynamic(this,'imgshow2')">
                            @if(session('img'))
                                <p class='text-danger'>{{session('img2')}}</p>
                            @endif
                            <div class="form-group text-center">
                                <img src="{{asset($img)}}" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow2" >
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <small>Image</small>
                            <input type="file" class="form-control" name="img3" onChange="dynamic(this,'imgshow3')">
                            @if(session('img'))
                                <p class='text-danger'>{{session('img3')}}</p>
                            @endif
                            <div class="form-group text-center">
                                <img src="{{asset($img)}}" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow3" >
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
