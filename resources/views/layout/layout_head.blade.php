<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Yoko</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Yoko DEVELOPMENT v1.0" name="description" />
        <meta content="Yoko" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        <link rel="stylesheet" href="../assets/css/select2.min.css" />
        <!-- App css -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />

        <!-- start -->
        <link href="../assets/libs/jquery-toast/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/jquery-toast/summernote-bs4.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/jquery-toast/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <!-- end -->
        <style>
        span.fa.fa-eye.active{
            color:green;
        }
        </style>
        <!-- Responsive css -->
        <link href="../css/responsive.css" rel="stylesheet" type="text/css" />
        <!-- Custom css -->
        <link href="../css/custom.css" rel="stylesheet" type="text/css" />
        {{--...--}}
        @yield('customstyle')

        <script>
        var roomid = '';
        var eroomid = '{{$eroom}}';
        var notification_view = false;
        var tenant = '{{$tenant}}';
        </script>
        <link rel="stylesheet" href="../assets/libs/sweetalert2/sweetalert2.min.css">
        <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
    </head>

    <body @if(!Cache::get('leftpannel')??0) class="left-side-menu-dark" @else class="left-side-menu-dark sidebar-enable enlarged" @endif >

        <!-- Pre-loader -->
        <div id="preloader">
            <div id="status">
                <div class="bouncingLoader"><div ></div><div ></div><div ></div></div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="wrapper">
            @include('layout.layout_topBar')
            @include('layout.layout_leftSidebar')
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        {{--...--}}
                        @yield('mainbody')
                    </div> <!-- container -->

                </div> <!-- content -->
                @include('layout.layout_footer')
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        <!-- Modal -->
        <div id="create_task" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">

                <form id="taskForm" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myExtraLargeModalLabel">Task Card</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="ClearEditTaskData()">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="modal-title mb-3" id="myExtraLargeModalLabel"><a id="watched"> <span class="fa fa-eye"></span></a> Watch</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-2">Task Name <span class="text-primary">*</span></h4>
                                        <input type="text" class="form-control mb-2" name="taskName" id="taskName" required="" parsley-trigger="change" data-parsley-maxlength="50">
                                        <h4 class="header-title mb-3">Description <span class="text-primary">*</span></h4>
                                        <div id="summernote-editor" name="taskDetails"></div> <!-- end summernote-editor-->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                                <form id="todo-list">
                                <h4 class="header-title mb-3"><i class="fa fa-check"></i>Checklist</h4>
                                    <div class="progress mb-3">
                                    <div class="progress-bar  bg-success"  style="width:0%">0%</div>
                                    </div>
                                    <div id="add-todo">
                                        <i class="fa fa-plus"></i>
                                        Add an Item
                                    </div>
                                    </form>

                                    <div class="btn-group mt-1">
                                        <button type="button" class="btn btn-comment-color waves-effect">Activity </button>
                                    </div>
                                    <div class="btn-group mt-1">
                                        <button type="button" class="btn btn-comment-color waves-effect waves-light">Comments</button>

                                    </div>

                                    <div class="media mb-4 mt-1">
                                    @if(!empty((Auth::user()->avatar)))
                                        <img class="d-flex mr-2 rounded-circle avatar-sm" src="{{ (Auth::user()->avatar)}}" alt="Generic placeholder image">
                                    @else
                                        <img class="d-flex mr-2 rounded-circle avatar-sm" src="../images/users/default-user.png" alt="Generic placeholder image">
                                    @endif
                                        <div class="media-body">
                                            <input type="text" id="taskNote" name="taskNote" class="form-control" placeholder="Add a comment....">
                                        </div>
                                    </div>
                                </div>
                            <div class="col-lg-4">
                                <h5>Tags</h5>
                                <div class="">
                                    <select class="js-example-basic-multiple-limit-tagnew" id="taskTag" name="taskTag" multiple="multiple">
                                    @foreach(commondata()['tasktag'] as $taglist)
                                        <option value="{{$taglist->taskTag}}">{{$taglist->taskTag}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <h5 class="mt-2">Assigned To <span class="text-primary">*</span></h5>
                                <div class="">
                                    <select class="search-dropdown" id="userId" name="userId" multiple="multiple" required="">
                                        @foreach(commondata()['user'] as $ulist)
                                        <option value="{{$ulist->id}}">{{$ulist->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <h5 class="mt-2">Lead</h5>
                                <div class="">
                                    <select class="search-dropdown" id="addleadid" name="leadid">
                                        <option value="">Choose..</option>
                                        @foreach(commondata()['lead'] as $ulist)
                                        <option value="{{$ulist->leadid}}">{{$ulist->firstname}} {{$ulist->lastname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(Route::currentRouteName() != "web.taskproject.kanbanboard")
                                <h5 class="mt-2">Task Project</h5>
                                <select class="selectpicker" id="taskProjectId" name="taskProjectId" data-style="btn-light">
                                    <option value="" selected>Choose...</option>
                                    @foreach(commondata()['taskproject'] as $tproject)
                                    <option value="{{$tproject->taskProjectId}}">{{$tproject->taskProjectName}}</option>
                                    @endforeach
                                </select>
                                @endif
                                <h5 class="mt-2">Task Board</h5>
                                <select class="selectpicker" id="taskBoardId" name="taskBoardId" data-style="btn-light">
                                </select>
                                <h5 class="mt-2">Importance <span class="text-primary">*</span></h5>
                                <select class="selectpicker" name="importance" id="importance" parsley-trigger="change" data-style="btn-light" required>
                                    <option value="" selected>Choose...</option>
                                    @for($i=1; $i<=9; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>

                                <h5 class="mt-2">Active Status <span class="text-primary">*</span></h5>
                                <select class="selectpicker" name="status" id="addstatus" parsley-trigger="change" data-style="btn-light" required>
                                    <option value="" selected>Choose...</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Closed">Closed</option>
                                </select>

                                <h5 class="mt-2">Task Status</h5>
                                <select class="selectpicker" name="taskStatusId" id="taskStatusId" data-style="btn-light">
                                    <option value="" selected>Choose...</option>
                                    @foreach(commondata()['taskstatus'] as $tstatus)
                                    <option value="{{ $tstatus->taskStatusId}}">{{$tstatus->taskStatus}}</option>
                                    @endforeach
                                </select>

                                <div class="form-group mt-2">
                                    <strong>Start Date <span class="text-primary">*</span></strong>
                                    <div class="input-group">
                                        <input type="text"  id="startDate" name="startDate" class="datepicker form-control"
                                        parsley-trigger="change" required data-provide="datepicker" placeholder="Pick Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <strong>Date Completed</strong>
                                    <div class="input-group">
                                        <input type="text"  id="dateCompleted" name="completedDate" class="datepicker form-control"
                                        parsley-trigger="change" data-provide="datepicker" placeholder="Pick Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <strong>Due Date</strong>
                                    <div class="input-group">
                                        <input type="text"  id="dueDate" name="dueDate" class="datepicker form-control"
                                        parsley-trigger="change" data-provide="datepicker" placeholder="Pick Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>

                                </div>

                                <h5 class="mt-2">REPORTER</h5>
                                <div class="">
                                @if(!empty((Auth::user()->avatar)))
                                    <img src="{{ (Auth::user()->avatar)}}" alt="task-user" class="avatar-sm img-thumbnail rounded-circle"> {{Auth::user()->name}}
                                @else
                                    <img src="../images/users/default-user.png" alt="task-user" class="avatar-sm img-thumbnail rounded-circle"> {{Auth::user()->name}}
                                @endif
                                </div>

                            </div>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="savetask" >Save Changes</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- End Modal -->

           <!--Start Edit Task Modal -->
        <div id="edit_task" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form id="edittaskForm" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myExtraLargeModalLabel">Task Card</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="ClearEditTaskData()">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h4 class="modal-title mb-3" id="myExtraLargeModalLabel"><a id="editwatched"><span class="fa fa-eye active"></span></a> <span id="totalcount"> </span>  Watch  </h4>
                                <div class="card">
                                    <div class="card-body">
                                    <input type="hidden" name="taskidedit" id="taskidedit" value="">
                                    <h4 class="header-title mb-3 mt-2">Task Name <span class="text-primary">*</span></h4>
                                        <input type="text" class="form-control" parsley-trigger="change" name="taskName" id="edittaskName" required="" value="11111111">
                                        <h4 class="header-title mb-3 mt-2">Description<span class="text-primary">*</span></h4>
                                        <div id="summernote-editor-edit" name="taskDetails" parsley-trigger="text" required="">

                                    </div> <!-- end summernote-editor-->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                                <form id="todo-list">
                                <h4 class="header-title mb-3"><i class="fa fa-check"></i>Checklist</h4>
                                    <div class="progress mb-3">
                                    <div class="progress-bar  bg-success" id="progressbartask" style="width:0%">0%</div>
                                    </div>
                                    <div id="taskchecklist-edit">

                                    </div>
                                    <div id="edit-todo">
                                        <i class="fa fa-plus"></i>
                                        Add an Item
                                    </div>
                                    </form>

                                    <div class="btn-group mt-1">
                                        <button type="button" class="btn btn-comment-color waves-effect">Activity </button>
                                    </div>
                                    <div class="btn-group mt-1">
                                        <button type="button" class="btn btn-comment-color waves-effect waves-light">Comments</button>
                                    </div>

                                    <div class="media mb-4 mt-1">
                                        <div class="media-body" >
                                            <div id="edittasknotev"></div>
                                        </div>
                                    </div>


                                </div>
                            <div class="col-lg-4">
                                <h5>Tags</h5>
                                <div class="">
                                    <select class="js-example-basic-multiple-limit-tagnew" id="edittaskTag" name="taskTag" multiple="multiple">
                                    @foreach(commondata()['tasktag'] as $taglist)
                                                <option value="{{$taglist->taskTag}}">{{$taglist->taskTag}}</option>
                                                @endforeach
                                    </select>
                                </div>

                                <h5 class="mt-2">Assigned To <span class="text-primary">*</span></h5>
                                <div class="">
                                    <select class="search-dropdown" required="" id="edituserId" name="userId" multiple="multiple">
                                        @foreach(commondata()['user'] as $ulist)
                                        <option value="{{$ulist->id}}">{{$ulist->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <h5 class="mt-2">Lead</h5>
                                <div class="">
                                    <select class="search-dropdown" id="editleadid" name="leadid">
                                        <option value="">Choose..</option>
                                        @foreach(commondata()['lead'] as $ulist)
                                        <option value="{{$ulist->leadid}}">{{$ulist->firstname}} {{$ulist->lastname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @if(Route::currentRouteName() != "web.taskproject.kanbanboard")
                                <h5 class="mt-2">Task Project</h5>
                                <select class="selectpicker" id="edittaskProjectId" name="taskProjectId" data-style="btn-light">
                                <option value="" selected>Choose...</option>
                                    @foreach(commondata()['taskproject'] as $tproject)
                                    <option value="{{$tproject->taskProjectId}}">{{$tproject->taskProjectName}}</option>
                                    @endforeach
                                </select>
                                @else
                                <input type="hidden" name="edittaskProjectId" id="edittaskProjectId">
                                @endif
                                <h5 class="mt-2">Task Board</h5>
                                <select class="selectpicker" id="edittaskBoardId" name="taskBoardId" data-style="btn-light">
                                </select>
                                <h5 class="mt-2">Importance <span class="text-primary">*</span></h5>
                                <select class="selectpicker" name="editimportance" id="editimportance" data-style="btn-light" required parsley-trigger="change">
                                    <option value="" selected>Choose...</option>
                                    @for($i=1; $i<=10; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>

                                <h5 class="mt-2">Active Status <span class="text-primary">*</span></h5>
                                <select class="selectpicker" name="status" id="editstatus" data-style="btn-light" required>
                                    <option value=" " selected>Choose...</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Closed">Closed</option>
                                </select>

                                <h5 class="mt-2">Task Status</h5>
                                <select class="selectpicker"  name="taskStatusId" id="edittaskStatusId" data-style="btn-light">
                                    <option value="" selected>Choose...</option>
                                    @foreach(commondata()['taskstatus'] as $tstatus)
                                    <option value="{{ $tstatus->taskStatusId}}">{{$tstatus->taskStatus}}</option>
                                    @endforeach
                                </select>

                                <div class="form-group mt-2">
                                    <strong>Start Date <span class="text-primary">*</span></strong>
                                    <div class="input-group">
                                        <input type="text"  id="editstartDate" name="startDate" class="datepicker form-control"
                                        parsley-trigger="change" required data-provide="datepicker" placeholder="Pick Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <strong>Date Completed</strong>
                                    <div class="input-group">
                                        <input type="text"  id="editcompletedDate" name="dateCompleted" class="datepicker form-control"
                                        parsley-trigger="change" data-provide="datepicker" placeholder="Pick Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <strong>Due Date</strong>
                                    <div class="input-group">
                                        <input type="text"  id="editdueDate" name="dueDate" class="datepicker form-control"
                                        parsley-trigger="change" data-provide="datepicker" placeholder="Pick Date">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="ti-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mt-2">REPORTER</h5>
                                <div class="mb-2" id="createdby">
                                    <img src="../assets/images/users/avatar-1.jpg" alt="task-user" class="avatar-sm img-thumbnail rounded-circle">
                                </div>

                            </div>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="editsavetask" >Save Changes</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- End Edit Task Modal -->
        <!-------------New TicketType Selection Modal------------->
        <div id="modalTicketType" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ticket Type Selection</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form  method="POST" action="{{ route('web.ticketing.add') }}">
                        @csrf
                        <div class="modal-body p-4">
                            <input type="hidden" name = "leadid" value={{ isset($lead) ? $lead->leadid : '' }}>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="select_3" class="col-form-label">Select Ticket Type</label>
                                    <select id="select_3" name="Type" required="" class="form-control">
                                        <option value="Install">Install</option>
                                        <option value="Service">Service</option>
                                        <option value="Hold">Hold</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success waves-effect waves-light" id="run-credit">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal -->
        <!-------------End New TicketType Selection Modal------------->

        @include('layout.layout_rightSidebar')
        @include('layout.layout_scripts')
        {{--...--}}
        @yield('customscript')
        @include('layout.alert')
    </body>
</html>
