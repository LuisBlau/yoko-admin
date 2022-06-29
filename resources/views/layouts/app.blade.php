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
    <link rel="stylesheet" href="/vendor/switchery/switchery.min.css"/>

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
            <div class="btn-group profil-link" role="group">
                <a href="#" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{isset(Auth::user()->name)?Auth::user()->name:''}}</span>
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
                <li>
                    <a href="/smsmmshistory">SMS and MMS History</a>
                </li>
                <li>
                    <a href="#api" data-toggle="collapse" aria-expanded="false">
                        API<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="api" class="nav nav-second collapse">
                        <li><a href="/apicollection">API Collection</a></li>
                        <li><a href="/apireview">API Review</a></li>
                        <li><a href="/tenstreetreview">TenStreet Review</a></li>
                    </ul>
                </li>
                <li class="nav-category">
                Administration
                </li>
                <li>
                    <a href="#infrastructure" data-toggle="collapse" aria-expanded="false">
                    Infrastructure<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="infrastructure" class="nav nav-second collapse">
                        <li><a href="/switchstatus">Switch Status</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#pbx" data-toggle="collapse" aria-expanded="false">
                    PBX<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="pbx" class="nav nav-second collapse">
                        <li><a href="/pbxdomains">Domains</a></li>
                        <li><a href="/pbxdomainsummary">Domain Summary</a></li>
                        <li><a href="/pbxdomainextension">Domain Extensions</a></li>
                        <li><a href="/pbxsmsenablednumber">SMS Enabled Numbers</a></li>
                        <li><a href="/resendfailedmessages">Resend Failed Messages</a></li>
                        <li><a href="/testpeerless">Test Send - Peerless</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#customers" data-toggle="collapse" aria-expanded="false">
                    Customers<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="customers" class="nav nav-second collapse">
                        <li><a href="/managecustomers">Manage Customers</a></li>
                        <li><a href="/tenstreetcustomerconfiguration">TenStreet Customer Configuration</a></li>
                        {{-- @if (App\Models\Role::find(Auth::user()->role_id)['role_name'] === 'Admin') --}}
                        <li><a href="/tenstreetcallrelayconfig">TenStreet Call Relay Config</a></li>
                        {{-- @endif --}}
                    </ul>
                </li>
                <li>
                    <a href="#accounting" data-toggle="collapse" aria-expanded="false">
                    Accounting<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="accounting" class="nav nav-second collapse">
                        <li><a href="/accounttodomain">Account to Domain</a></li>
                        <li><a href="/accountingmonthlydata">Accounting Monthly Data</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#aabo" data-toggle="collapse" aria-expanded="false">
                    Aabo<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="aabo" class="nav nav-second collapse">
                        <li><a href="/aaborelay">AABO Relay</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#automatedcallqueue" data-toggle="collapse" aria-expanded="false">
                    Automated Call Queue<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="automatedcallqueue" class="nav nav-second collapse">
                        <li><a href="/tenstreetcallrequests">TenStreet Call Requests</a></li>
                        <li><a href="/tenstreetrequestscalled">TenStreet Call Log</a></li>
                        <li><a href="/agentavailabilityconfig">Agent Availability Configuration</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#troubleshooting" data-toggle="collapse" aria-expanded="false">
                    Troubleshooting<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="troubleshooting" class="nav nav-second collapse">
                        <li><a href="/failedjobs">Failed SMS Sends</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#usermanagement" data-toggle="collapse" aria-expanded="false">
                    User Management<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="usermanagement" class="nav nav-second collapse">
                        <li><a href="/manageusers">Manage Users</a></li>
                        <li><a href="/userloginhistory">User Login History</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- End navigation-->
    @yield('content')
    </div>

    <input type="hidden" id="hd_current_time_zone" value="{{session()->get('current_time_zone')}}">

    <!-- /vendor scripts -->
    <script src="/vendor/pacejs/pace.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/sparkline/index.js"></script>
    <script src="/vendor/flot/jquery.flot.min.js"></script>
    <script src="/vendor/flot/jquery.flot.resize.min.js"></script>
    <script src="/vendor/flot/jquery.flot.spline.js"></script>
    <script src="/vendor/select2/dist/js/select2.js"></script>
    <script src="/vendor/toastr/toastr.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <!-- App scripts -->
    <script src="/scripts/luna.js"></script>

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
</body>
</html>
