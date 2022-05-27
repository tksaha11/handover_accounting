@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title pull-left m-auto">My Changeable MRP Product List</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <form method="get" action="{{ route('search-changeable-mrp-product-list') }}" class="row">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-12 col-md-2">
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
                    <div class="col-12 col-md-2">
                        <div class="form-group m-auto">
                            <select class="form-control form-control text-center" name="status" id="status">
                                <option value=0>Status</option>
                                <option value='pending' class="text-left">Pending</option>
                                <option value='active' class="text-left">Accept</option>
                                <!-- <option value='Reject' class="text-left">Reject</option> -->

                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group m-auto">
                            <input type="search" class="form-control text-center" placeholder="Product Name" name="title">
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-info col">Find</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @if (session('success'))
                            <span class="alert alert-success d-block" role="alert">
                                <strong>{{ session('success') }}</strong>
                            </span>
                        @endif
                        @if (session('warning'))
                            <span class="alert alert-danger d-block" role="alert">
                                <strong>{{ session('warning') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>MRP</th>
                                    {{-- <th>Sale</th>
                                    <th>Stock</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(isset($data[0]))
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($item->status=='active')
                                                    <img src="{{ env('store_admin_url').'images/products/'.$item->product_id.'-1.jpg'}}" height="100px" width="100px">
                                                @else
                                                    <img src="{{asset('assets/images/products/'.$item->product_id.'-1.jpg')}}" height="100px" width="100px">
                                                @endif

                                            </td>
                                            <td>{{$item->title}}</td>
                                            <td>{{$item->unit_mrp}}</td>
                                            {{-- <td>{{$item->sale_price}}</td>
                                            <td>{{ $item->stock}}</td> --}}
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>
                                                <a href="#" class="d-block  border-bottom p-1  btn btn-outline-danger btn-sm " data-toggle="modal" data-target="#editItemModal{{$item->product_id}}">Change MRP</a>
                                            </td>
                                            {{-- start modal --}}
                                            <div class="modal fade" id="editItemModal{{$item->product_id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content radius-30">
                                                        <div class="modal-header border-bottom-0">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>


                                                        <div class="modal-body pb-5 pl-5 pr-5">
                                                            <form method="post" action="{{ route('insert-change-mrp-value') }}" >
                                                                @csrf
                                                                {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                                                                <input type="hidden" name="product_id" value="{{ $item->product_id}}">
                                                                <input type="hidden" name="ex_mrp" value="{{ $item->unit_mrp }}">

                                                                <div class="form-group">
                                                                    <label>Enter New MRP</label>
                                                                    <input type="number" class="form-control form-control-lg radius-30" name="unit_price" required value=0>
                                                                </div>

                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-info radius-30 btn-lg btn-block ">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end edit item modal --}}

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
