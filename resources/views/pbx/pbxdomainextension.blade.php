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
                            <h3>Domain Extensions</h3>
                            <small>
                                Table for netsapiens domain extensions
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default btn-pull"><span class="pe-7s-refresh-2"></span>&nbsp;&nbsp;Pull Domain Extensions </button>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body" id="maindiv">
                            <div class="loader">
                                <div class="loader-dots"></div>
                            </div>
                            <table id="maintable" class="table table-striped table-hover table-responsive-sm">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Domain Owner</th>
                                    <th>Match Rule</th>
                                    <th>Enable</th>
                                    <th>Match From</th>
                                    <th>Dow</th>
                                    <th>TOD From</th>
                                    <th>TOD To</th>
                                    <th>Valid From</th>
                                    <th>Valid To</th>
                                    <th>Responder</th>
                                    <th>Parameter</th>
                                    <th>To Scheme</th>
                                    <th>To User</th>
                                    <th>To Host</th>
                                    <th>From Name</th>
                                    <th>From Scheme</th>
                                    <th>From User</th>
                                    <th>From Host</th>
                                    <th>Dialplan</th>
                                    <th>Domain</th>
                                    <th>Plan Description</th>
                                    <th>Domain Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($domains as $domain)
                                <tr>
                                    <td><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#action_modal" onclick="settoken(this);"><i class="fa fa-key"></i>Edit</button></td>
                                    <td><a href="/pbxdomain/{{$domain['domain_owner']}}" target="_blank">{{$domain['domain_owner']}}</a></td>
                                    <td>{{$domain['matchrule']}}</td>
                                    <td>{{$domain['enable']}}</td>
                                    <td>{{$domain['match_from']}}</td>
                                    <td>{{$domain['dow']}}</td>
                                    <td>{{$domain['tod_from']}}</td>
                                    <td>{{$domain['tod_to']}}</td>
                                    <td>{{$domain['valid_from']}}</td>
                                    <td>{{$domain['valid_to']}}</td>
                                    <td>{{$domain['responder']}}</td>
                                    <td>{{$domain['parameter']}}</td>
                                    <td>{{$domain['to_scheme']}}</td>
                                    <td>{{$domain['to_user']}}</td>
                                    <td>{{$domain['to_host']}}</td>
                                    <td>{{$domain['from_name']}}</td>
                                    <td>{{$domain['from_scheme']}}</td>
                                    <td>{{$domain['from_user']}}</td>
                                    <td>{{$domain['from_host']}}</td>
                                    <td>{{$domain['dialplan']}}</td>
                                    <td>{{$domain['domain']}}</td>
                                    <td>{{$domain['plan_description']}}</td>
                                    <td>{{$domain['domain_description']}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="modal fade" id="action_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-bar"></div>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Action</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <form id="frm-reset-pass">
                                                <div class="loader">
                                                    <div class="loader-bar"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label" for="newpassword">Item1</label>
                                                    <input type="input" placeholder="" name="newpassword" class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
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
    u="";
    function settoken(e) {u=$(e).parent().parent().children()[1].innerText;}
    $(document).ready(function () {
        $('#maintable').DataTable({
            //"order": [[ 0, "asc" ]],
            "scrollX": true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
        });

        $('.btn-pull').click(function() {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#maindiv').toggleClass('ld-loading'); //Loading...

            $.ajax({
                type: "POST",
                url: "{{ route('apisv2.netsapiens.collectextensions') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{},
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#maindiv').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.info("Reloading...");
                    setTimeout(function(){ location.reload(); }, 1000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('#maindiv').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
