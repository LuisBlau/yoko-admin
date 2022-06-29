<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Yoko') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css"/>

    <!-- App styles -->
    <link rel="stylesheet" href="styles/pe-icons/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="styles/pe-icons/helper.css"/>
    <link rel="stylesheet" href="styles/stroke-icons/style.css"/>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="blank  pace-done">
<!-- Wrapper-->
<div class="wrapper">
    <!-- Main content-->
    <section class="content">
        <div class="container-center animated slideInDown">
            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Login</h3>
                    <small>
                        Please enter your credentials to login.
                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="email">Email Address</label>
                            <input type="email" placeholder="example@gmail.com" title="Please enter you username" required="" value="" name="email" id="email" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="form-text small">Your unique username for the application</span>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="password">Password</label>
                            <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="form-text small">Your strong password</span>
                        </div>
                        <!--div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div-->
                        <div>
                            <button class="btn btn-accent">Login</button>
                            <a class="btn btn-w-md btn-link" href="/forgotpassword">Forgot your password?</a-->
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->
</div>

<!-- Vendor scripts -->
<script src="vendor/pacejs/pace.min.js"></script>
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- App scripts -->
<script src="scripts/luna.js"></script>
</body>
</html>