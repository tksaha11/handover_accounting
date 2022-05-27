@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title pull-left m-auto">Change MRP Request List</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{route('changeable-mrp-product-list')}}">
                                <button class="card-title m-auto btn btn-primary">Change MRP</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <form method="get" action="{{route('search-changelist-mrp')}}" class="row">

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
                                <option value='pending' class="text-left">pending</option>
                                <option value='Accept' class="text-left">Accept</option>
                                <option value='Reject' class="text-left">Reject</option>

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
                                    <th>Ex MRP</th>
                                    <th>New MRP</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- @if(isset($data2[0])) --}}
                                    @foreach ($data2 as $item)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <img src="{{ env('store_admin_url').'images/products/'.$item->product_id.'-1.jpg'}}" height="100px" width="100px">

                                            </td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->ex_mrp }}</td>
                                            <td>{{ $item->new_mrp }}</td>
                                            <td>{{ $item->status }}</td>
                                        </tr>
                                    @endforeach
                                {{-- @endif --}}

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
