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
                            <h3>Account to Domain</h3>
                            <small>
                                Table for accounting clients
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#popup_modal" ><span class="pe-7s-add-user"></span>&nbsp;&nbsp;Add </button>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table id="maintable" class="table table-striped table-hover table-responsive-sm">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Domain</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0;$i < count($data);$i++)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$data[$i]['client']}}</td>
                                    <td>{{$data[$i]['domain']}}</td>
                                    <td>
                                        <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#edit_modal" type="button" onclick="settoken({{$data[$i]['id']}})"><i class="fa fa-paste"></i> Edit</button>
                                        <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#delete_modal" type="button" onclick="settoken({{$data[$i]['id']}})"><i class="fa fa-trash-o"></i> <span class="bold">Delete</span></button>
                                    </td>
                                </tr>
                                @endfor
                                </tbody>
                            </table>
                            <div class="modal fade" id="popup_modal" role="dialog">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">New Record</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <form id="frm-default">
                                            <div class="modal-body">
                                                <div class="form-group"><label for="domains">Domain</label>
                                                    <select class="domains form-control" name="domain" style="width: 100%">
                                                        @foreach($domains as $domain)
                                                        <option value="{{$domain}}">{{$domain}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group"><label for="clientid">Accounting ID</label>
                                                    <select class="clientid form-control" name="clientid" style="width: 100%">
                                                        @foreach($clients as $client)
                                                        <option value="{{$client['id']}}">{{$client['client']}}</option>
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
                            <div class="modal fade" id="edit_modal" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Edit Record</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <form id="frm-edit">
                                                <div class="form-group"><label for="edit-domains">Domain</label>
                                                    <select class="edit-domains form-control" name="domain" style="width: 100%">
                                                        @foreach($domains as $domain)
                                                        <option value="{{$domain}}">{{$domain}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group"><label for="edit-clientid">Accounting ID</label>
                                                    <select class="edit-clientid form-control" name="clientid" style="width: 100%">
                                                        @foreach($clients as $client)
                                                        <option value="{{$client['id']}}">{{$client['client']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-update">Save</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Delete Record</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-delete">Delete</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @foreach($domains as $domain)
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#popup_modal" onclick="setdomain('{{$domain}}')">{{ucfirst($domain)}}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
<!-- End main content-->
<script type="text/javascript" src="{{ asset('assets/jquery.validate.min.js') }}"></script>
<script src="vendor/datatables/datatables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script>
    u="";
    refresh_flag = false;
    function setdomain(d) {
        $(".domains").val(d);
        $('.domains').trigger('change');
    }
    function settoken(e) {
        u=e;
        $.ajax({
            type: "POST",
            url: "{{ route('api.clients.get') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data: {tid:u},
            success: function (data, status, jqXHR) {
                $('.edit-domains').val(data.domain);
                $('.edit-domains').trigger('change');

                $('.edit-clientid').val(data.account_id);
                $('.edit-clientid').trigger('change');
            },
            error: function (jqXHR, status) {
                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }

    $(document).ready(function () {
        $('#popup_modal').on('hidden.bs.modal', function () {
            if(refresh_flag) location.reload();
        });
        $('#edit_modal').on('hidden.bs.modal', function () {
            if(refresh_flag) location.reload();
        });

        $(".domains").select2();
        $(".clientid").select2();
        $(".edit-domains").select2();
        $(".edit-clientid").select2();
        $('#maintable').DataTable({
            // "processing": true,
            // "serverSide": true,
            "order": [[ 0, "asc" ]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
        });

        $('.btn-delete').click(function() {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#delete_modal').toggleClass('ld-loading'); //Loading...

            var data_post = 'u='+u;
            $.ajax({
                type: "POST",
                url: "{{ route('api.clients.delete') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:data_post,
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#delete_modal').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.success("Deleted!");
                    setTimeout(function(){ location.reload(); }, 3000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('#delete_modal').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });

        $('.btn-add').click(function() {
            var frm = $('#frm-default');
            frm.validate({
                rules: {
                    "domains": {
                        required: true,
                    },
                    "clientid": {
                        required: true,
                    },
                },
                messages: {
                    "domains": {
                        required: "Please choose a domain.",
                    },
                    "clientid": {
                        required: "Please choose a client.",
                    },
                },
                submitHandler: function(frm) {

                }
            });
            if(frm.valid()) {
                refresh_flag = true;
                overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
                $('#popup_modal').toggleClass('ld-loading'); //Loading...

                var data_post = frm.serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.clients.add') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:data_post,
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        $('#popup_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(data);
                        toastr.success("Added!");
                        //setTimeout(function(){ location.reload(); }, 3000);
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
            refresh_flag = true;
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#frm-edit').toggleClass('ld-loading'); //Loading...

            var domain = $(".edit-domains").val();
            var client_id = $(".edit-clientid").val();
            data_post = "domain=" + domain + "&u="+u + "&client_id="+client_id;
            $.ajax({
                type: "POST",
                url: "{{ route('api.clients.edit') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:data_post,
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#frm-edit').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.success("Updated!");
                    //setTimeout(function() { location.reload(); }, 3000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('#frm-edit').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
