@if(isset($data[0]))
    @foreach ($data as $item)
        @php $dataCount++; @endphp
        <tr>
            <td>{{ $dataCount }}</td>
            <td>
                @if($item->product_status=='active')
                    <img src="{{ env('store_admin_url').'images/products/'.$item->product_id.'-1.jpg'}}" height="100px" width="100px">
                @else
                    <img src="{{asset('assets/images/products/'.$item->product_id.'-1.jpg')}}" height="100px" width="100px">
                @endif
                
            </td>
            <td>{{$item->title}}</td>
            <td>{{$item->unit_mrp}}</td>
            <td>{{$item->sale_price}}</td>
            <td>{{ $item->stock}}</td>
            <td>{{ ucfirst($item->product_status) }}</td>
            <td>
                <a href="#" class="d-block  border-bottom p-1  btn btn-outline-danger btn-sm " data-toggle="modal" data-target="#editItemModal{{$item->store_p_id}}">Edit Item</a>

                <a href="#" class="d-block border-bottom p-1  btn btn-outline-danger btn-sm my-1" data-toggle="modal" data-target="#updateStockModal{{$item->store_p_id}}">Update Stock</a>

                @php
                    $linkDisable="";
                    if($item->product_status!='active')
                        $linkDisable="disabled";
                @endphp
                @if($item->store_enlist==0)
                    <a href="{{ route('enlist-store-proudct',['store_p_id'=>$item->store_p_id,'enlist'=>1]) }}" class="d-block  p-1 btn btn-outline-danger btn-sm {{$linkDisable}}">Add to Live</a>
                @else
                    <a href="{{ route('enlist-store-proudct',['store_p_id'=>$item->store_p_id,'enlist'=>0]) }}" class="d-block  p-1 btn btn-outline-danger btn-sm ">Remove From Live</a>
                @endif
            </td>
            {{-- start modal --}}
            <div class="modal fade" id="editItemModal{{$item->store_p_id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content radius-30">
                        <div class="modal-header border-bottom-0">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                            </button>
                        </div>
                        

                        <div class="modal-body pb-5 pl-5 pr-5">
                            <form method="post" action="{{ route('edit-my-shop-product-info') }}" >

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="store_p_id" value="{{ $item->store_p_id}}">
                                <input type="hidden" name="unit_mrp" value="{{$item->unit_mrp}}">
                                
                                <div class="form-group">
                                    <label>Your Sales Price (Must Not Be Greated Than: {{$item->unit_mrp}} TK)</label>
                                    <input type="number" class="form-control form-control-lg radius-30" name="sale_price" required value=0>
                                </div>
                                <div class="form-group">
                                    <label>Amar Bazar Percentage(%)</label>
                                    <input type="number" class="form-control form-control-lg radius-30" name="abl_com_amnt" required value=1>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info radius-30 btn-lg btn-block " >EDIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end edit item modal --}}

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
    <tr class="load-more" lastID="{{ $lastID }}" dataCount="{{ $dataCount }}">
    </tr>
    <div class="row">
        <img src="loading.gif"/>
    </div>
@endif


