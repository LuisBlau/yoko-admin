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
                            <h3>AABO Relay</h3>
                            <small>
                                Table for aabo relay
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
                                    <th>Extension ID</th>
                                    <th>Destination URL</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0;$i < count($data);$i++)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$arr[$data[$i]['extension_id']]}}</td>
                                    <td>{{$data[$i]['destination_url']}}</td>
                                    <td>
                                        <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#edit_modal" type="button" onclick="settoken({{$data[$i]['id']}})"><i class="fa fa-paste"></i> Edit</button>
                                        <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#delete_modal" type="button" onclick="settoken({{$data[$i]['id']}})"><i class="fa fa-trash-o"></i> <span class="bold">Delete</span></button>
                                    </td>
                                </tr>
                                @endfor
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
                                                <div class="form-group"><label for="extension">Extension ID</label>
                                                    <select class="extension form-control" name="extension" style="width: 100%">
                                                        @foreach($extensions as $extension)
                                                        @if($extension->extension_id == null)
                                                        <option value="{{$extension->id}}">{{$extension->matchrule}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label" for="destination_url">Destination URL</label>
                                                    <input type="input" placeholder="ex. owner.aabocrm.com" name="destination_url" class="form-control">
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
                            <div class="modal fadre" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
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
                                                <div class="form-group"><label for="edit_extension">Extension ID</label>
                                                    <select class="edit_extension form-control" name="edit_extension" style="width: 100%">
                                                        @foreach($extensions as $extension)
                                                        <option value="{{$extension->id}}">{{$extension->matchrule}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label" for="edit_destination_url">Destination URL</label>
                                                    <input type="input" placeholder="" name="edit_destination_url" class="form-control edit_destination_url">
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
            url: "{{ route('api.aaborelay.get') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data: {tid:u},
            success: function (data, status, jqXHR) {
                $('.edit_extension').val(data.extension_id);
                $('.edit_extension').trigger('change');

                $('.edit_destination_url').val(data.destination_url);
            },
            error: function (jqXHR, status) {
                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }

    $(document).ready(function () {
        $(".extension").select2();
        $(".edit_extension").select2();
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

        $('.btn-delete').click(function() {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#delete_modal').toggleClass('ld-loading'); //Loading...

            var data_post = 'u='+u;
            $.ajax({
                type: "POST",
                url: "{{ route('api.aaborelay.delete') }}?api_token={{auth()->user()->api_token}}",
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
                    "extension": {
                        required: true,
                    },
                    "destination_url": {
                        required: true,
                    },
                },
                messages: {
                    "extension": {
                        required: "Please choose an Extension ID.",
                    },
                    "destination_url": {
                        required: "Please input Destination URL.",
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
                    url: "{{ route('api.aaborelay.add') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:data_post,
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        $('#popup_modal').toggleClass('ld-loading'); //Loading...

                        //console.log(data);
                        toastr.success("Added!");
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
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#frm-edit').toggleClass('ld-loading'); //Loading...

            var extension = $(".edit_extension").val();
            var destination_url = $(".edit_destination_url").val();
            data_post = "extension=" + extension + "&u="+u + "&destination_url="+destination_url;
            $.ajax({
                type: "POST",
                url: "{{ route('api.aaborelay.edit') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:data_post,
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#frm-edit').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.success("Updated!");
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
