@extends('main.header-footer')

@section('main_content')
<section class="page-content-wrapper">

    <div class="page-content">
        
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="card-title pull-left">Own Product List</h3>
                        </div>
                        <div class="col-md-4 text-right">
                           <a class="btn btn-primary" href="{{ route('upload-own-product-form') }}"> Upload Own Product</a>
                        </div>

                        <div class="col-md-12">
                            @if (session('success'))
                                <span class="alert alert-success d-block" role="alert">
                                    <strong>{{ session('success') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="datatable" class="table table-bordered table-hover text-center table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Unit Mrp</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @isset($data)
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->unit_mrp }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->sub_category }}</td>
                                    <td>{{ ucwords($item->status) }}</td>
                                    @if($item->status=='pending')
                                        <td> <a href="{{ route('edit-own-product-form',['product_id'=>$item->id])}} " class="btn btn-outline-primary"> Edit </a></td>
                                    @else
                                        <td> <a href="#" class="btn btn-outline-primary disabled"  role="button" aria-disabled="true">Edit Disable </a></td>
                                    @endif

                                </tr>
                            @endforeach
                        @endisset  
                    </tbody>
                </table>
            </div>
           
        </div>{{-- card end --}}
    </div>
</section>
@endsection

