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
                            <h3>TenStreet Customer Configuration</h3>
                            <small>
                                Table for tenstreet configs
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#popup_modal" ><span class="pe-7s-file"></span>&nbsp;&nbsp;Add </button>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table id="maintable" class="table table-striped table-hover table-responsive-sm">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Queue Name</th>
                                    <th>Origination DID</th>
                                    <th>ANI DID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($configs as $config)
                                <tr>
                                    <td>{{$config['domain']}}</td>
                                    <td>{{$config['queue_name']}}</td>
                                    <td>{{$config['origination_did']}}</td>
                                    <td>{{$config['ani_did']}}</td>
                                    <td>
                                    @if($config['status'])
                                    <span class="label label-accent">Active</span>
                                    @else
                                    <span class="label label-default">In-Active</span>
                                    @endif
                                    </td>
                                    <td><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#edit_modal" onclick="settoken({{$config['id']}});"><i class="pe-7s-edit"></i></button></td>
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
                                            <h4 class="modal-title">New Record</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <form id="frm-default">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="domain">Domain</label>
                                                    <select class="select2_domains form-control" name="domain" style="width: 100%">
                                                        @foreach($domains as $domain)
                                                            <option value="{{$domain}}">{{$domain}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="queuename">Queue Name</label>
                                                    <input type="text" class="form-control" name="queuename" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="origination_did">Origination DID</label>
                                                    <input type="tel" class="form-control" name="origination_did" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="ani_did">ANI DID</label>
                                                    <input type="text" class="form-control" name="ani_did" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="select2_status form-control" name="status" style="width: 100%">
                                                        <option value="1">Active</option>
                                                        <option value="0">In-Active</option>
                                                    </select>
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
                            <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Edit Record</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <form id="frm-edit">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="edit_domain">Domain</label>
                                                    <select class="select2_domains form-control" name="edit_domain" style="width: 100%">
                                                        @foreach($domains as $domain)
                                                            <option value="{{$domain}}">{{$domain}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_queuename">Queue Name</label>
                                                    <input type="text" class="form-control" name="edit_queuename" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_origination_did">Origination DID</label>
                                                    <input type="tel" class="form-control" name="edit_origination_did" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_ani_did">ANI DID</label>
                                                    <input type="text" class="form-control" name="edit_ani_did" >
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_status">Status</label>
                                                    <select class="select2_status form-control" name="edit_status" style="width: 100%">
                                                        <option value="1">Active</option>
                                                        <option value="0">In-Active</option>
                                                    </select>
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
    u="";
    function settoken(e) {
        u=e;
        $.ajax({
            type: "POST",
            url: "{{ route('api.tenstreetcustomerconfig.get') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data: {tcid:u},
            success: function (data, status, jqXHR) {
                //console.log(data);
                $('select[name="edit_domain"]').val(data.domain);
                $('select[name="edit_domain"]').trigger('change');
                $('input[name="edit_queuename"]').val(data.queue_name);
                $('input[name="edit_origination_did"]').val(data.origination_did);
                $('input[name="edit_ani_did"]').val(data.ani_did);
                $('select[name="edit_status"]').val(data.status);
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
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
                    "status": {
                        required: true,
                    },
                },
                messages: {
                    "domain": {
                        required: "Please choose a domain.",
                    },
                    "status": {
                        required: "Please select a status.",
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
                    url: "{{ route('api.tenstreetcustomerconfig.add') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:data_post,
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        $('#popup_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(data);
                        toastr.success("A new record has been added.");
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
                    "edit_status": {
                        required: true,
                    },
                },
                messages: {
                    "edit_domain": {
                        required: "Please choose a domain.",
                    },
                    "edit_status": {
                        required: "Please select a status.",
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
                url: "{{ route('api.tenstreetcustomerconfig.update') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:data_post,
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#frm-edit').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.success("The record has been updated.");
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
