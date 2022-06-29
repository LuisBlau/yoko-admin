@extends('layouts.app')

@section('content')

     <!-- Main content-->
     <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-albums"></i>
                        </div>
                        <div class="header-title">
                            <h3>Manage Customers</h3>
                            <small>
                                Table for users
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#popup_modal" ><span class="pe-7s-add-user"></span>&nbsp;&nbsp;Add New User </button>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table id="maintable" class="table table-striped table-hover table-responsive-sm">
                                <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Email Address</th>
                                    <th>Domains</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user['name']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td>{{$user['domains']!='null'?$user['domains']:''}}</td>
                                    <td>
                                    @if($user['status'])
                                    <span class="label label-accent">Active</span>
                                    @else
                                    <span class="label label-default">In-Active</span>
                                    @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#reset_domain_modal" onclick="loaddomainsetting({{$user['id']}});"><i class="pe-7s-plus"></i></button>
                                        <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#edit_status_modal" onclick="setstatus({{$user['id']}}, {{$user['status']}});"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#reset_pass_modal" onclick="settoken({{$user}});"><i class="fa fa-key"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="modal fade" id="popup_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">New User</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <form id="frm-default">
                                            <div class="modal-body">
                                                <div class="form-group"><label for="username">Username</label> <input type="text" class="form-control" name="username" placeholder="Name" ></div>
                                                <div class="form-group"><label for="emailaddress">Email address</label> <input type="email" class="form-control" name="emailaddress" placeholder="Email" ></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default btn-add">Add</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="reset_domain_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Domain Management</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <form id="frm-reset-domains">
                                                <div class="loader">
                                                    <div class="loader-bar"></div>
                                                </div>
                                                <select class="select2_domains form-control" multiple="multiple" style="width: 100%">
                                                @foreach($domains as $domain)
                                                    <option value="{{$domain}}">{{$domain}}</option>
                                                @endforeach
                                                </select>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-update-domains">Save</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit_status_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Edit</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <form id="frm-reset-pass">
                                                <div class="loader">
                                                    <div class="loader-bar"></div>
                                                </div>
                                                <input type="hidden" name="_token" value="{{$user->verification_token}}">
                                                Active Status:&nbsp;&nbsp;
                                                <input type="checkbox" class="active-status"></input>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-update-status">Save</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="reset_pass_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Reset Password</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <form id="frm-reset-pass">
                                                <div class="loader">
                                                    <div class="loader-bar"></div>
                                                </div>
                                                <input type="hidden" name="_token" value="{{$user->verification_token}}">
                                                <div class="form-group">
                                                    <p>To send the customer a password reset email, click [Email Now] button below.</p>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-update-password">Email Now</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- End main content-->
<script type="text/javascript" src="{{ asset('assets/jquery.validate.min.js') }}"></script>
<script src="vendor/datatables/datatables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    u="";email='';
    function settoken(e) {
        email = e.email;
    }
    function setstatus(e, status) {
        u=e;
        $(".active-status").prop('checked', !status).trigger("click");
    }
    function loaddomainsetting(e) {
        u=e;
        $.ajax({
            type: "POST",
            url: "{{ route('api.customers.getcustomerdomains') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data: {uid:u},
            success: function (data, status, jqXHR) {
                $('.select2_domains').val(data);
                $('.select2_domains').trigger('change');
            },
            error: function (jqXHR, status) {
                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }

    $(document).ready(function () {
        $(".select2_domains").select2();
        var active_status = document.querySelector('.active-status');
        var switchery_active_status = new Switchery(active_status, {color:'#03a9f4'});
        //btn-update-status

        $('#maintable').DataTable({
            // "processing": true,
            // "serverSide": true,
            "order": [[ 0, "asc" ]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
        });

        $('.btn-update-status').click(function() {
            var updated_status = $(".active-status").prop('checked');
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#edit_status_modal').toggleClass('ld-loading'); //Loading...

            $.ajax({
                type: "POST",
                url: "{{ route('api.customers.updatestatus') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data: {uid:u, status:updated_status?1:0},
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#edit_status_modal').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    if(updated_status) toastr.success("The customer account has been activated.");
                    if(!updated_status) toastr.success("The customer account has been inactivated.");
                    setTimeout(function(){ location.reload(); }, 3000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('#edit_status_modal').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });

        $('.btn-update-password').click(function() {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#reset_pass_modal').toggleClass('ld-loading'); //Loading...

            $.ajax({
                type: "POST",
                url: "{{ route('api.customers.resetpassword') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data: {emailaddress:email},
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#reset_pass_modal').toggleClass('ld-loading'); //Loading...

                    toastr.success("A confirmation link has been emailed to " + email + ".");
                    setTimeout(function(){ location.reload(); }, 3000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('#reset_pass_modal').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });

        $('.btn-add').click(function() {
            var frm = $('#frm-default');
            frm.validate({
                rules: {
                    "username": {
                        required: true,
                    },
                    "emailaddress": {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    "username": {
                        required: "Please enter username.",
                    },
                    "emailaddress": {
                        required: "Please enter email address.",
                    },
                },
                submitHandler: function(frm) {

                }
            });
            if(frm.valid()) {
                overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
                $('#popup_modal').toggleClass('ld-loading'); //Loading...

                var data_post = frm.serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.customers.add') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:data_post,
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        $('#popup_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(data);
                        toastr.success("A confirmation email has been sent to " + data.email + ".");
                        setTimeout(function(){ location.reload(); }, 3000);
                    },
                    error: function (jqXHR, status) {
                        overlay.remove();
                        $('#popup_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(jqXHR);
                        toastr.error(jqXHR.responseJSON.message);
                    }
                });
            }
        });

        $('.btn-update-domains').click(function() {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#frm-reset-domains').toggleClass('ld-loading'); //Loading...

            var domains = $(".select2_domains").val();
            data_post = "domains=" + domains + "&u="+u;
            $.ajax({
                type: "POST",
                url: "{{ route('api.customers.updatedomains') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:data_post,
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#frm-reset-domains').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.success("Customer domains has been updated.");
                    setTimeout(function() { location.reload(); }, 3000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('#frm-reset-domains').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
