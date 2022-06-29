<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="d-none d-sm-block">
            <form class="app-search">
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </li>

        <li id="top-notification" class="dropdown notification-list">
            <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>


                @if($unread_notification['rowCount']>0)
                <span class="badge badge-success rounded-circle noti-icon-badge" id="notificationalert">{{$unread_notification['rowCount']}}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <span class="float-right">
                            <a href="javascript:;" class="text-dark clearall" onclick="clearall_data_notification()">
                                <small>Clear All</small>
                            </a>
                        </span>Notification
                    </h5>
                </div>

                <div class="slimscroll noti-scroll unread-list">
                    <!-- item-->
                    @foreach($unread_notification['rowData']->take(4) as $itemRow)
                        <a href="javascript:;" class="dropdown-item notify-item">
                        <div class="notify-icon bg-soft-primary text-primary">

						@if(isset($itemRow->notifactaionicon))
						<i class="mdi mdi-{{$itemRow->notifactaionicon}}"></i>
						@else
                            <i class="mdi mdi-comment-account-outline"></i>
						@endif
                        </div>
                        <p class="notify-details">

						{!! Str::limit($itemRow->notificationheader, 100, ' ...') !!}
						</p>
                        <p class="text-muted mb-0 user-msg">
						{!! Str::limit($itemRow->notificationdetails, 100, ' ...') !!}
						<br>
                            <small>


							{{time_elapsed_string($itemRow->created_at)}}</small>
                        </p>
                    </a>
                    @endforeach

                </div>

                <!-- All-->
                <a href="{{ route('web.notifications.index') }}" class="dropdown-item text-center text-primary notify-item notify-all">
                    View all
                    <i class="fi-arrow-right"></i>
                </a>

            </div>
        </li>

        @if (isset($roomid))
        <li id="top-chat" class="dropdown notification-list">
            <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-message-circle noti-icon"></i>
                <span class="badge badge-success rounded-circle noti-icon-badge d-none">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        Messages
                    </h5>
                </div>

                <div class="inbox-widget unread-list px-2">

                </div>

                <!-- All-->
                <a href="javascript:;" class="dropdown-item text-center text-primary notify-item clearall" onclick="clearall()">
                    Clear all
                    <i class="fi-arrow-right"></i>
                </a>

            </div>
        </li>
        @else
        <li id="top-chat" class="dropdown notification-list">
            <a class="nav-link right-bar-toggle  waves-effect waves-light" href="javascript:void(0);">
                <i class="fe-message-circle noti-icon"></i>
                <span class="badge badge-success rounded-circle noti-icon-badge d-none">0</span>
            </a>
        </li>
        @endif

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{{Auth::user()->avatar?Auth::user()->avatar:'../assets/images/users/person.jpg'}}" alt="user-image" class="avatar rounded-circle">
                <span class="pro-user-name ml-1">
                    {{Auth::user()->name}} <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome {{Auth::user()->firstname?Auth::user()->firstname:Auth::user()->name}}!</h6>
                </div>

                @if (Auth::guest())
                    <!-- item-->
                    <a href="{{ url('/login') }}" class="dropdown-item notify-item">
                        <i class="remixicon-login-box-line"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ url('/register') }}" class="dropdown-item notify-item">
                        <i class="remixicon-signal-tower-line"></i>
                        <span>Register</span>
                    </a>

                    @else
                    <!-- item-->
                    <a href="{{ url('/profile') }}" class="dropdown-item notify-item">
                        <i class="remixicon-account-circle-line"></i>
                        <span>User Profile</span>
                    </a>

                    @if (Auth::user()->hasRole('Sales Representative'))
                    <!-- item-->
                    <a href="{{ url('/salesrepprofile') }}" class="dropdown-item notify-item">
                        <i class="remixicon-bank-line"></i>
                        <span>Sales Rep Profile</span>
                    </a>
                    @endif

                    @if (Auth::user()->hasRole('Technician'))
                    <!-- item-->
                    <a href="{{ url('/technicianprofile') }}" class="dropdown-item notify-item">
                        <i class="remixicon-compasses-2-fill"></i>
                        <span>Technician Profile</span>
                    </a>
                    @endif

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="{{ url('/logout') }}" class="dropdown-item notify-item">
                        <i class="remixicon-logout-box-line"></i>
                        <span>Logout</span>
                    </a>
                @endif
                <!-- item-->

            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{url('/')}}" class="logo text-center">
            <span class="logo-lg">
                <img src="../assets/images/logo-light.png" alt="" height="30">
                <!-- <span class="logo-lg-text-light">Xeria</span> -->
            </span>
            <span class="logo-sm">
                <!-- <span class="logo-sm-text-dark">X</span> -->
                <img src="../assets/images/logo-sm.png" alt="" height="30">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button id="toggleBtn" class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li class="dropdown d-lg-block">
            <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                Create New
                <i class="mdi mdi-chevron-down"></i>
            </a>
            <div class="dropdown-menu">
                @if (\Gate::allows('page-leadslist', 'add'))
                <!-- item-->
                @if(checkDevice() == 0)
                <a href="{{ route('web.crm.leadadd') }}" class="dropdown-item">
                    <i class="fe-briefcase mr-1"></i>
                    <span>New Lead</span>
                </a>
                @endif
                @endif
                @if (\Gate::allows('page-customerlist', 'add'))
                <!-- item-->
                <a href="{{ route('web.crm.customeradd') }}" class="dropdown-item">
                    <i class="remixicon-user-star-fill mr-1"></i>
                    <span>New Customer</span>
                </a>
                @endif
                @if (\Gate::allows('page-tasklist', 'add'))
                <!-- item-->
                @if(checkDevice() == 0)
                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target=".bs-example-modal-xl">
                    <i class="remixicon-checkbox-line mr-1"></i>
                    <span>Create New Task</span>
                </a>
                @endif
                @endif
                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#modalTicketType">
                    <i class="fe-activity mr-1"></i>
                    <span>Enter a Ticket</span>
                </a>

            </div>
        </li>
    </ul>
</div>
<!-- end Topbar -->
