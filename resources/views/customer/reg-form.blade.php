@extends('main.header-footer')
@section('main_content')

    <section class="page-content-wrapper">
        <div class="page-content">
            <form class="form-horizontal" method="post" action="{{ route('customer-reg') }}">
                @include('mgs.index')
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-row">
                    <div class="form-group mb-2 col-md-6">
                        <label>Name</label><span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group mb-2 col-md-6">
                        <label>Email</label><span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" placeholder="Enter email" required
                                value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label>Mobile</label><span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="number" class="form-control" name="mobile" required
                                value="{{ old('mobile') }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label>Refference Rin</label><span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="text" class="form-control" name="reff_rin" required
                            value="{{$reff_rin}}">
                        </div>
                    </div>
                    
                    <div class="form-group mb-2 col-md-6">
                        <label>Password</label><span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" placeholder="Enter password"
                                required value="{{ old('password') }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 col-md-6">
                        <label>Confirm Password</label><span class="text-danger">*</span>
                        <div class="input-group">
                            <input type="password" class="form-control" name="conpassword"
                                value="{{ old('conpassword') }}">
                        </div>
                    </div>
                    <div class="form-group mb-2 mt-2 col-md-12">
                        <button class="btn btn-primary btn-block site-color-bg form-control" id="btnlogin" type="submit">
                            Register </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
