@extends('main.header-footer')

@section('main_content')
<section class="page-content-wrapper">
    <div class="page-content">
        <form class="form-horizontal" method="post" class="row" action="{{ route('store-profile-update') }}">
            @include('mgs.index')
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-row">
                <div class="form-group mb-2 col-md-6">
                    <label>Mobile as username</label><span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="number" class="form-control" name="mobile" required value="{{ $store->mobile }}" readonly>
                    </div>
                </div>

                <div class="form-group mb-2 col-md-6">
                    <label>Email</label><span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="email" class="form-control" name="email" placeholder="Enter email" required
                            value="{{ $store->email }}">
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Owner name</label><span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="text" class="form-control" name="own_name" required
                            value="{{ $store->own_name }}">
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Organization Name</label><span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="text" class="form-control" name="shop_name" required
                            value="{{ $store->shop_name }}" disabled>
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Organization Address</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        <textarea class="form-control" name="shop_address"
                            required> {{ $store->shop_address }}</textarea>
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Delivery Charge</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="number" class="form-control" name="del_charge" required value="{{ $store->del_charge }}">
                    </div>
                </div>
               
                <div class="form-group mb-2 col-md-6">
                    <label>Shop Contact</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="number" class="form-control" name="shop_contact" required
                            value="{{ $store->shop_contact }}">
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Shop Rin</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="text" class="form-control" name="rin" required value="{{ $store->rin }}">
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Delivery Area</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="text" class="form-control" name="delArea"
                            required value="{{ $store->del_area }}">
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>District</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        <select class="form-control" name="district" id="district">
                            @foreach ($district as $item)
                                @if($item==$store->district)
                                    <option selected>{{ $item }}</option>
                                @else
                                    <option>{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Thana</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        <select class="form-control" name="thana" id="thana">
                            <option> {{ $store->thana }} </option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Business Category</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @php
                            $cat = ['Other', 'Consumer, Variety, Grocery, Mudi', 'Chain store, Supershop, Department Store', 'Bakery, Confectionery, Fast Food, Juice Bar', 'Rice, Meat & Fish, Vegetables', 'Mobile,Telecom, Electronics, Electrical', 'Hotel Motel, Restaurant', 'Travel, Tour Operations, Ticketing', 'Pharmacy', 'Optical Shop', 'Hospital, Diagnostic Center, Dental Care', 'Library, Stationery, office Products', 'Machinery, Hardware', 'Bicycle, Bikes, Automobile', 'Fashion, Shoes Store', 'Salon, Beauty Parlor', 'Furniture, Home Appliances', 'Flower Gift Shop', 'Jewellers', 'Garment', 'Rod, Cement', 'Developer, Engineering', 'C&F, Freight Frowrding', 'Food & Bevarage, Agro', 'Cosmetic, Toiletries'];
                        @endphp
                        <select class="form-control" name="shop_cat">
                        
                            @foreach ($cat as $item)
                                @if ($item==$store->shop_cat)
                                    <option selected>{{ $item }}</option>
                                @else
                                    <option>{{ $item }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group mb-2 col-md-6">
                    <label>ABL Plan</label>
                    <div class="input-group">
                        <select class="form-control" name="abl_plan">
                            <option>{{ $store->abl_plan }}</option>
                        </select>
                    </div>
                </div>


                <div class="form-group mb-2 col-md-6">
                    <label>Password</label><span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Enter password">
                    </div>
                </div>
                <div class="form-group mb-2 col-md-6">
                    <label>Confirm Password</label><span class="text-danger">*</span>
                    <div class="input-group">
                        <input type="password" class="form-control" name="conpassword">
                    </div>
                </div>
                <div class="form-group mb-2 mt-2 col-md-12">
                    <button class="btn btn-warning btn-block site-color-bg form-control" id="btnlogin" type="submit">
                        Update </button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        //thana list
        $('#district').on('change', function() {
            $('#thana').html('<option default></option>');

            var dist=$('#district').val();
            var api="https://portal2.amarbazarltd.com/ablApi/getThana.php?xdistrict="+dist+"&username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
            $.ajax({  
                url:api, 
                type : "GET",                                  				
                success : function(result) {
                    $.each(result, function(key, val){
                        $('#thana').append('<option>'+val+'</option>');
                    });
                }
            })
        })
    });

</script>
@endsection

