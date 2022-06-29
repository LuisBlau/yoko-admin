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
        {{--...--}}
		@yield('customstyle')
    </head>

    <body>
		<div>
			{{--...--}}
			@yield('mainbody')
		</div>
		<!--End Div Wrapper -->
		<footer class="footer footer-alt">
      &copy; 2019 - {{date("Y")}} &nbsp;Aabo CRM
        </footer>
        {{--...--}}
		@yield('customscript')
	</body>
</html>
