@extends('main.header-footer')
@section('main_content')

    <section class="page-content-wrapper">
        <div class="page-content">
            
        @include('mgs.index')

                <form class="form-horizontal" method="post" action="{{ route('insert-delivery-man') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                    <div class="form-row">
                        <div class="form-group mb-2 col-md-6">
                            <label>Name</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="Enter Delivery Man Name" required>
                            </div>
                        </div>
                        <div class="form-group mb-2 col-md-6">
                            <label>Address</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control" name="address" placeholder="Enter Delivery Man Address" required>
                            </div>
                        </div>

                        <div class="form-group mb-2 col-md-6">
                            <label>Mobile</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="number" class="form-control" name="mobile" placeholder="Enter Delivery Man Mobile Number" required>
                            </div>
                        </div>
                        @error('mobile')
                            <span class="alert alert-danger alert-dismissible fade show">{{$message}}</span><br>
                        @enderror
                        <div class="form-group mb-2 col-md-6">
                            <label>Email</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="email" class="form-control" name="email" placeholder="Enter Delivery Man Email" required>
                            </div>
                        </div>
                        @foreach($data as $info)
                        <div class="form-group mb-2 col-md-6">
                            <label>District</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <select name="district" class="form-control" id="district" required>
                                    <option>
                                        {{$info->district}}
                                    </option>
                                    @foreach ($district as $item)
                                        <option>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        
                        <div class="form-group mb-2 col-md-6">
                            <label>Thana</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <select name="thana" class="form-control" id="thana" required>
                                    <option>
                                        {{$info->thana}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group mb-2 col-md-6">
                            <label>Area</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control" name="area" placeholder="Enter Delivery Man Area" required>
                            </div>
                        </div>

                        @endforeach
                        <div class="form-group mb-2 col-md-6">
                            <label>NID No.</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control" name="nid_no" placeholder="Enter Delivery Man NID Number" required>
                            </div>
                        </div>
                        @error('nid_no')
                            <span class="alert alert-danger alert-dismissible fade show">{{$message}}</span><br>
                        @enderror
                        <div class="form-group mb-2 col-md-6">
                            <label>Bank Name </label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name" required>
                            </div>
                        </div>
                        <div class="form-group mb-2 col-md-6">
                            <label>Account No.</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control" name="account_no" placeholder="Enter Account Number" required>
                            </div>
                        </div>
                        <div class="form-group mb-2 col-md-12">
                            <label>Branch Name</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control" name="branch_name" placeholder="Enter Branch Name" required>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Delivery Man Image</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="file" class="form-control" name="dm_image" onchange="dynamic(this,'imgshow1')" required="">
                            </div>
                            <div class="form-group text-center">
                                <img src="{{env('store_seller_url')}}assets/images/noimage.jpg" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow1">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>NID Image</label><span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="file" class="form-control" name="nid_image" onchange="dynamic(this,'imgshow2')" required="">
                            </div>
                            <div class="form-group text-center">
                                <img src="{{env('store_seller_url')}}assets/images/noimage.jpg" class="imgshow img-fluid img-thumbnail mh-50" id="imgshow2">
                            </div>
                        </div>

                        <div class="form-group mb-2 mt-2 col-md-12">
                            <button class="btn btn-primary btn-block site-color-bg form-control" id="btnlogin" type="submit">
                                Create </button>
                        </div>
                    </div>
                </form>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('assets/js/images/imageshow.js') }}"> </script>
    <script>


        function getThana(){
            var thana=$('#Selected_thana').val();
            
            // $('#thana').html('<option default></option>');

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
   
        }
    $(document).ready(function() {


        getThana();
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
