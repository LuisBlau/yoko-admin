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
                            <h3>TenStreet Call Relay Configuration</h3>
                            <small>
                                Table for tenstreet call relay configs
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#popup_modal" ><span class="pe-7s-file"></span>&nbsp;&nbsp;Add New Subscription</button>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table id="maintable" class="table table-striped table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Domain</th>
                                        <th>Destination URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($configs as $config) --}}
                                    @for($i=0; $i < count($configs); $i++)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td>{{$configs[$i]['domain']->domain}}</td>
                                        <td>{{$configs[$i]['destination_url']}}</td>
                                        <td>
                                            <button
                                                class="btn btn-default btn-xs"
                                                data-toggle="modal"
                                                data-target="#edit_modal"
                                                onclick="settoken({{$configs[$i]['id']}});"><i class="fa fa-paste"></i> Edit
                                            </button>
                                            <button
                                                class="btn btn-xs btn-default"
                                                data-toggle="modal"
                                                data-target="#delete_modal"
                                                type="button"
                                                onclick="settoken({{$configs[$i]['id']}})"><i class="fa fa-trash-o"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @endfor
                                    {{-- @endforeach --}}
                                </tbody>
                            </table>
                            <div class="modal fade" id="popup_modal" role="dialog">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Add New Subscription</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <form id="frm-default">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="domain">Domain</label>
                                                    <select class="select2_domains form-control" name="domain" style="width: 100%">
                                                        @foreach($domains as $domain)
                                                            <option value="{{$domain['id']}}">{{$domain['domain']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="destination">Destination URL</label>
                                                    <input type="text" class="form-control" name="destination" >
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default btn-add">Add</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
                                            <h4 class="modal-title">Edit Subscription</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <form id="frm-edit">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="edit_domain">Domain</label>
                                                    <select class="select2_domains form-control" name="edit_domain" style="width: 100%">
                                                        @foreach($domains as $domain)
                                                            <option value="{{$domain['id']}}">{{$domain['domain']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_destination">Destination URL</label>
                                                    <input type="text" class="form-control" name="edit_destination" >
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-default btn-update">Update</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="delete_modal" role="dialog">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Delete Subscription</h4>
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
        </div>
    </section>
<!-- End main content-->
<script type="text/javascript" src="{{ asset('assets/jquery.validate.min.js') }}"></script>
<script src="vendor/datatables/datatables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/popper/popper.min.js"></script>
<script>
    u="";
    function settoken(e) {
        u=e;
        $.ajax({
            type: "POST",
            url: "{{ route('api.tenstreetcallrelayconfig.get') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data: {tcid:u},
            success: function (data, status, jqXHR) {
                console.log(data);
                $('select[name="edit_domain"]').val(data.netsapiens_domain_id);
                $('select[name="edit_domain"]').trigger('change');
                $('input[name="edit_destination"]').val(data.destination_url);
            },
            error: function (jqXHR, status) {
                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }

    $(document).ready(function () {
        $(".select2_domains").select2({
            placeholder: "Select a domain",
            allowClear: true
        });
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

        $('.btn-add').click(function() {
            var frm = $('#frm-default');
            frm.validate({
                rules: {
                    "domain": {
                        required: true,
                    },
                    "destination": {
                        required: true,
                    },
                },
                messages: {
                    "domain": {
                        required: "Please choose a domain.",
                    },
                    "destination": {
                        required: "Please input a destination URL.",
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
                    url: "{{ route('api.tenstreetcallrelayconfig.add') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:data_post,
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        $('#popup_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(data);
                        toastr.success("A new subscription has been added.");
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
                    "edit_domain": {
                        required: true,
                    },
                    "edit_destination": {
                        required: true,
                    },
                },
                messages: {
                    "edit_domain": {
                        required: "Please choose a domain.",
                    },
                    "edit_destination": {
                        required: "Please input a destination URL.",
                    },
                },
                submitHandler: function(frm) {

                }
            });
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#frm-edit').toggleClass('ld-loading'); //Loading...

            var data_post = $('#frm-edit').serialize();
            data_post = data_post + "&u="+u;
            $.ajax({
                type: "POST",
                url: "{{ route('api.tenstreetcallrelayconfig.update') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:data_post,
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#frm-edit').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.success("The subscription has been updated.");
                    setTimeout(function() { location.reload(); }, 3000);
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
