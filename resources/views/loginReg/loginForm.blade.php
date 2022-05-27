<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Amardokan Seller</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">

</head>

<body>

    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="card">
                            <div class="card-body border-bottom p-0 auth-header-box">
                                <div class="text-center p-3">
                                    <img src="{{ asset('assets/images/logo/logo.png') }}" class="img-fluid" alt="logo">
                                    <h4 class="mt-3 mb-1  font-weight-semibold font-18 site-color-text"> Sign In</h4>
                                    <p class="text-muted  mb-0">Sign in to continue Amardokan</p>
                                    <p class="text-danger font-weight-bold mb-0">For any problem call: 01810025182</p>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="tab-pane active p-3">
                                    <form class="form-horizontal" method="post" action="{{ route('store-login') }}">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        @if (session('warning'))
                                            <span class="alert alert-danger d-block" role="alert">
                                                <strong>{{ session('warning') }}</strong>
                                            </span>
                                        @endif
                                        <div class="form-group mb-2">
                                            <label>Mobile</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="mobile" placeholder="Enter mobile">
                                            </div>
                                        </div>
                                    
                                        <div class="form-group mb-2">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="password" placeholder="Enter password">
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <button class="btn btn-primary btn-block site-color-bg" id="btnlogin" type="submit"> Login </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--end form-->
                                    <div class="m-3 text-center text-muted">
                                        <p class="mb-0">Don't have an account ? <a class="site-color-text ml-2" href="{{ route('store-reg-form')}}"> Easy Registration</a></p>
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>

</body>

</html>
