@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title pull-left m-auto">Discount Offer</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="card-title pull-right m-auto">
                                <a href="{{ route('campaign-req-product-list',['campaign_name'=>'Discount Offer']) }}" class="btn btn-info radius-30 btn btn-block">Add Product</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <form method="get" action="{{ route('search-discount-offer') }}" class="row">

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
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>MRP</th>
                                    <th>Sale</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data[0]))
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ env('store_admin_url').'images/products/'.$item->product_id.'-1.jpg' }}" height="100px" width="100px">
                                        </td>
                                        <td>{{ $item->title}}</td>
                                        <td>{{ $item->unit_mrp}}</td>
                                        <td>{{ $item->sale_price}}</td>
                                        <td>{{ $item->stock}}</td>
                                        <td>
                                            <a href="#" class="border-bottom p-1 d-block btn btn-outline-danger btn-sm mb-1" data-toggle="modal" data-target="#updateStockModal{{$item->store_p_id}}">Update Stock</a>

                                            <a href="{{ route('add-or-remove-from-campaign',['store_p_id'=>$item->store_p_id,'type'=>0,'campaign_name'=>$campaign_name]) }}" class="d-block  p-1 btn btn-outline-danger btn-sm">Remove</a>
                                        </td>
                                        
    
                                       {{-- start stock update modal --}}
                                       <div class="modal fade" id="updateStockModal{{$item->store_p_id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content radius-30">
                                                <div class="modal-header border-bottom-0">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="{{ route('store-stock-update') }}" >

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="store_p_id" value="{{$item->store_p_id}}">
                                                    

                                                    <div class="modal-body pb-5 pl-5 pr-5">
                                                        <div class="form-group">
                                                            <label>Update Type</label>
                                                            <select class="form-control form-control-lg radius-30" name="update_type"> 
                                                                <option value='1'>Stock In</option>
                                                                <option value='0'>Stock Out</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Stock</label>
                                                            <input type="number" class="form-control form-control-lg radius-30" name="stock" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-info radius-30 btn-lg btn-block">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end stock update modal --}}
    
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