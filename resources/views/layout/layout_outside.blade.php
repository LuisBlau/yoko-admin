<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Aabo CRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{URL::asset('assets/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
        <link href="{{ asset('assets/libs/jquery-toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />

        {{--...--}}
		@yield('customstyle')
    </head>

    <body>
        <!-- Pre-loader -->
        <div id="preloader" style="background:rgba(255,255,255,0.6);">
            <div id="status">
                <div class="bouncingLoader"><div ></div><div ></div><div ></div></div>
            </div>
        </div>
		<div>
			{{--...--}}
			@yield('mainbody')
		</div>
        <!--End Div Wrapper -->
        <div class="mt-5">
            <footer class="footer footer-alt">&copy; 2019 - {{date("Y")}} &nbsp;Aabo CRM</footer>
        </div>
        {{--...--}}
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
         <!-- Jquery Ui js -->
        <script src="{{ asset('assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

		@yield('customscript')
	</body>
</html>
