<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{trans('messages.app_name')}} | Login</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <link rel="shortcut icon" href="{{asset('assets/images/branding/logo.jpg')}}">

    <script src="{{asset('assets/js/layout.js')}}"></script>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/custom.min.css')}}?v={{time()}}" rel="stylesheet" type="text/css"/>

</head>

<body>

<div class="auth-page-wrapper pt-5">
    <div class="auth-one-bg-position bg-primary" id="auth-particles">

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <div class="auth-page-content">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-sm-3 mb-4 text-white-50">
                                <div>
                                    <a href="#" class="d-inline-block auth-logo">
                                        <img src="{{asset('assets/images/branding/logo.jpg')}}" alt="" style="max-width:100px"/>
                                    </a>
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to {{trans('messages.app_name')}}.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                               placeholder="Enter Email" autocomplete="off">
                                    </div>

                                    <div class="mb-3">
                                        {{--                                        <div class="float-end">--}}
                                        {{--                                            <a href="#" class="text-muted">Forgot password?</a>--}}
                                        {{--                                        </div>--}}
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input"
                                                   name="password"
                                                   placeholder="Enter password" id="password-input" autocomplete="off">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Sign In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            Copyright
                            &copy;
                            <script>document.write(new Date().getFullYear())</script>
                            {{trans('messages.app_name')}}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<script>var hostUrl = 'assets/'</script>
<script>
    var form_url = '/login-check'
    var redirect_url = '/dashboard'
    var APP_URL = {!! json_encode(url('/admin')) !!};
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/plugins/blockUI/blockUI.js') }}"></script>
<script src="{{ asset('assets/plugins/axios/axios.min.js') }}"></script>
<script src="{{asset('assets/custom-js/custom.js')}}?v={{time()}}"></script>
<script src="{{ asset('assets/custom-js/custom/form.js') }}?v={{time()}}"></script>

<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
<script src="{{asset('assets/js/plugins.js')}}"></script>

<!-- particles js -->
<script src="{{asset('assets/libs/particles.js/particles.js')}}"></script>
<!-- particles app js -->
<script src="{{asset('assets/js/pages/particles.app.js')}}"></script>
<!-- password-addon init -->
<script src="{{asset('assets/js/pages/password-addon.init.js')}}"></script>
</body>

</html>
