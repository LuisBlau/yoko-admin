<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>YOKO Networks</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

    <!-- /vendor styles -->
    <link rel="stylesheet" href="/vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="/vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="/vendor/datatables/datatables.min.css"/>
    <link rel="stylesheet" href="/vendor/select2/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="/vendor/toastr/toastr.min.css"/>
    <!-- App styles -->
    <link rel="stylesheet" href="/styles/pe-icons/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="/styles/pe-icons/helper.css"/>
    <link rel="stylesheet" href="/styles/stroke-icons/style.css"/>
    <link rel="stylesheet" href="/styles/style.css">

    <script src="/vendor/jquery/dist/jquery.min.js"></script>
</head>
<body class="pace-done">
<div class="wrapper">

    <!-- Header-->
    <nav class="navbar navbar-expand-md navbar-default fixed-top">
        <div class="navbar-header">
            <div id="mobile-menu">
                <div class="left-nav-toggle">
                    <a href="#">
                        <i class="stroke-hamburgermenu"></i>
                    </a>
                </div>
            </div>
            <a class="navbar-brand" href="/home">
            YOKO Networks
            </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="left-nav-toggle">
                <a href="">
                    <i class="stroke-hamburgermenu"></i>
                </a>
            </div>
            <form class="navbar-form mr-auto">
                <input type="text" class="form-control" placeholder="Search" style="width: 175px">
            </form>
            <!--ul class="nav navbar-nav">
                <li class="nav-item profil-link">
                    <a href="/login">
                        <span class="profile-address">{{Auth::user()->name}}</span>
                        <img src="/images/profile.jpg" class="rounded-circle" alt="">
                    </a>
                </li>
            </ul-->
            <div class="btn-group profil-link" role="group">
                <a href="#" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{Auth::user()->name}}</span>
                    <img src="/images/profile.jpg" class="rounded-circle" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown" style="position: absolute; transform: translate3d(-103px, 34px, 0px); top: 13px; left: 37px; will-change: transform;" x-placement="bottom-end">
                    <!--div class="dropdown-divider"></div-->
                    <a class="dropdown-item" href="/logout">
                        <i class="si si-logout"></i> Sign Out
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- End header-->

    <!-- Navigation-->
    <aside class="navigation">
        <nav>
            <ul class="nav luna-nav">
                <li class="nav-category">
                    Main
                </li>
                <li>
                    <a href="/home">Dashboard</a>
                </li>
                @if (auth()->user()->customer_admin==1)
                <li><a href="/tenstreetcallrequests">TenStreet Call Requests</a></li>
                <li><a href="/tenstreetrequestscalled">TenStreet Call Log</a></li>
                <li><a href="/agentavailabilityconfig">Agent Availability Configuration</a></li>
                <li><a href="/tenstreetreview">TenStreet Review</a></li>
                @endif
                <!--li>
                    <a href="#menu1" data-toggle="collapse" aria-expanded="false">
                        Menu1<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="menu1" class="nav nav-second collapse">
                        <li><a href="#">Page1</a></li>
                    </ul>
                </li-->
            </ul>
        </nav>
    </aside>
    <!-- End navigation-->
    @yield('content')
    </div>

    <input type="hidden" id="hd_current_time_zone" value="{{session()->get('current_time_zone')}}">
    <script type="text/javascript">
        $(document).ready(function() {
            if($('#hd_current_time_zone').val() =="") { // Check for hidden field is empty. if is it empty only execute the post function
                var current_date = new Date();
                curent_zone = -current_date.getTimezoneOffset() * 60;
                $('#hd_current_time_zone').val(curent_zone);
                document.cookie="curent_zone="+curent_zone;
            }
        });

        var ele = $('a[href="'+location.pathname+'"]');
        ele.parent().addClass('active');
        ele.parent().parent().addClass('show');
        ele.parent().parent().parent().addClass('active');
    </script>

    <!-- /vendor scripts -->
    <script src="/vendor/pacejs/pace.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/sparkline/index.js"></script>
    <script src="/vendor/flot/jquery.flot.min.js"></script>
    <script src="/vendor/flot/jquery.flot.resize.min.js"></script>
    <script src="/vendor/flot/jquery.flot.spline.js"></script>
    <script src="/vendor/select2/dist/js/select2.js"></script>
    <script src="/vendor/toastr/toastr.min.js"></script>
    <!-- App scripts -->
    <script src="/scripts/luna.js"></script>

</body>
</html>
