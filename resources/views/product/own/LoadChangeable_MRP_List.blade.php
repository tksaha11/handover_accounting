
<tr id="loadList">
    @if(isset($data[0]))
        @foreach ($data as $item)
            @php $dataCount++; @endphp
            <tr>
                <td>{{ $dataCount }}</td>
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
        <tr class="load-more" lastID="{{ $lastID }}" dataCount="{{ $dataCount }}"></tr>
    @endif
</tr>

<!-- @section('js')
<script>
        $(document).ready(function() {

            $(window).scroll(function(){

                var lastID = $('.load-more').attr('lastID');
                //console.log(lastID);
                var dataCount = $('.load-more').attr('dataCount');
                if(($(window).scrollTop() + $(window).height() > $(document).height() - 300) && (lastID != 0)){                   

                    $.ajax({
                        type:'GET',
                        url:'/changeable-mrp-product-list/load-product/'+lastID+'/'+dataCount,
                        success:function(html){
                            $('.load-more').remove();
                            $('#loadList').append(html);
                        }, 
                    });
                }
            });
        });
    </script>
@endsection -->