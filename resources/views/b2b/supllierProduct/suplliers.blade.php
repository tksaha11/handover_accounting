@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-4 m-auto font-weight-bold">
                    Suppliers - Purchase from Admin
                </div>
                <div class="col-7 flex-grow-1 search-bar m-auto">
					<form method="get" action="{{ route('search-b2b-all-suppliers')}}" >
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
                            <div class="col-md-3 col-6">
                                <div class="card">
                                    <a href="{{ route('b2b-suppliers-product',['suppplier_id'=>$item->id]) }}">
                                        <img src="{{ env('store_admin_url').'images/suppliers/logo/'.$item->id.'.jpg'}}" class="img-fluid border shadow-sm p-3" style="width: 300px; height:250px;">
                                    </a>
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

