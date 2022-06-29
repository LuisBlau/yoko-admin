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
                            <h3>Manage Users</h3>
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
                                    <th>Role</th>
                                    <th>Customer Admin</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user['name']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td>{{$user['role_name']}}</td>
                                    <td>{{$user['customer_admin']?'Yes':'No'}}</td>
                                    <td>
                                    @if($user['status'])
                                    <span class="label label-accent">Active</span>
                                    @else
                                    <span class="label label-default">In-Active</span>
                                    @endif
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-default btn-xs"
                                            data-toggle="modal"
                                            data-target="#edit_modal"
                                            onclick='editUser({{ $user->id }})'>
                                            <i class="fa fa-edit"></i> Edit
                                        </button>
                                        <button
                                            class="btn btn-default btn-xs"
                                            data-toggle="modal"
                                            data-target="#reset_pass_modal"
                                            onclick="settoken(this);"><i class="fa fa-key"></i> Reset Password
                                        </button>
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
                                                <div class="form-group"><label for="roleid">Role</label>
                                                    <select class="roleid form-control" name="roleid" style="width: 100%">
                                                        @foreach($roles as $role)
                                                        <option value="{{$role['id']}}">{{$role['role_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default btn-add">Add</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit_modal" role="dialog">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Edit User</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <form id="frm-edit">
                                            <div class="modal-body">
                                                <div class="form-group"><label for="edit_username">Username</label>
                                                    <input type="text" class="edit_username form-control" name="edit_username" placeholder="Name" >
                                                </div>
                                                <div class="form-group"><label for="edit_email">Email address</label>
                                                    <input type="email" class="edit_email form-control" name="edit_email" placeholder="Email" >
                                                </div>
                                                <div class="form-group"><label for="edit_role">Role</label>
                                                    <select class="edit_role form-control" name="edit_role" style="width: 100%">
                                                        @foreach($roles as $role)
                                                            <option value="{{$role['id']}}">{{$role['role_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group"><label for="edit_customeradmin">Customer Type</label>
                                                    <select class="edit_customeradmin form-control" name="edit_customeradmin" style="width: 100%">
                                                        <option value="0">Customer</option>
                                                        <option value="1">Customer Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default btn-update">Update</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="reset_pass_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
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
                                                <!--div class="form-group">
                                                    <label class="col-form-label" for="currentpassword">Current Password</label>
                                                    <input type="password" placeholder="" name="currentpassword" class="form-control">
                                                </div-->
                                                <div class="form-group">
                                                    <label class="col-form-label" for="newpassword">New Password</label>
                                                    <input type="password" placeholder="" name="newpassword" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label" for="confirmpassword">Confirm Password</label>
                                                    <input type="password" placeholder="" name="confirmpassword" class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-update-password">Update Password</button>
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
    var u="";
    function settoken(e) {u=$(e).parent().parent().children()[1].innerText;}
    function editUser(id) {
        u = id;
        $.ajax({
            type: "POST",
            url: "{{ route('api.users.get') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data: {id: id},
            success: function (data, status, jqXHR) {
                $('.edit_username').val(data.name);
                $('.edit_email').val(data.email);

                $('.edit_role').val(data.role_id);
                $('.edit_role').trigger('change');
                $('.edit_customeradmin').val(data.customer_admin);
                $('.edit_customeradmin').trigger('change');
            },
            error: function (jqXHR, status) {
                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }
    $(document).ready(function () {
        $(".roleid").select2();
        $(".edit_role").select2();
        $(".edit_customeradmin").select2();
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
            // "ajax": '{{ route('api.users.getlist') }}?api_token={{auth()->user()->api_token}}',
            // "columns": [
            //     { "data": "id" },
            //     { "data": "email" },
            //     { "data": "role_id" },
            //     { "data": "status" }
            // ]
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
                    url: "{{ route('api.users.add') }}?api_token={{auth()->user()->api_token}}",
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

        $('.btn-update').click(function() {
            var frm = $('#frm-edit');
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
                $('#edit_modal').toggleClass('ld-loading'); //Loading...

                let data_put = frm.serialize();
                data_put = data_put + "&id="+u;
                $.ajax({
                    type: "PUT",
                    url: "{{ route('api.users.update') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:data_put,
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        $('#edit_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(data);
                        toastr.success("The user has been updated.");
                        // $('#edit_modal').modal('hide');
                        // setTimeout(function(){ location.reload(); }, 300);
                        setTimeout(function(){ location.reload(); }, 3000);
                    },
                    error: function (jqXHR, status) {
                        overlay.remove();
                        $('#edit_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(jqXHR);
                        toastr.error(jqXHR.responseJSON.message);
                    }
                });
            }
        });

        $('.btn-update-password').click(function() {
            var frm = $('#frm-reset-pass');
            frm.validate({
                rules: {
                    // "currentpassword": {
                    //     required: true,
                    // },
                    "newpassword": {
                        required: true,
                        minlength: 6,
                        maxlength: 50,
                    },
                    "confirmpassword": {
                        required: true,
                        minlength: 6,
                        maxlength: 50,
                        equalTo: "[name='newpassword']"
                    },
                },
                submitHandler: function(frm) {

                }
            });
            if(frm.valid()) {
                overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
                $('#frm-reset-pass').toggleClass('ld-loading'); //Loading...

                var data_post = frm.serialize();
                data_post = data_post+"&u="+u;
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.users.resetpassword') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:data_post,
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        $('#frm-reset-pass').toggleClass('ld-loading'); //Loading...

                        //console.log(data);
                        toastr.success("Password has been reset.");
                        setTimeout(function() { location.reload(); }, 3000);
                    },
                    error: function (jqXHR, status) {
                        overlay.remove();
                        $('#frm-reset-pass').toggleClass('ld-loading'); //Loading...

                        //console.log(jqXHR);
                        toastr.error(jqXHR.responseJSON.message);
                    }
                });
            }
        });
    });
</script>
@endsection
