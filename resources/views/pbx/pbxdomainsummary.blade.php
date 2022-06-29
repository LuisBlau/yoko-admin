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
                            <h3>Domain Summary</h3>
                            <small>
                                Table for netsapiens domain summaries
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default btn-pull"><span class="pe-7s-refresh-2"></span>&nbsp;&nbsp;Pull Domain Summaries from PBX </button>
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
                                    <th>Domain</th>
                                    <th>Description</th>
                                    <th>Territory</th>
                                    <th>Call Limit</th>
                                    <th>Max Call Queue</th>
                                    <th>Max Aa</th>
                                    <th>Max Conference</th>
                                    <th>Max Department</th>
                                    <th>Max User</th>
                                    <th>Current User</th>
                                    <th>Current Department</th>
                                    <th>Current Queue</th>
                                    <th>Current Agent</th>
                                    <th>Current Park</th>
                                    <th>Current Aa</th>
                                    <th>Current Conference</th>
                                    <th>Current Phonenumbers</th>
                                    <th>Current Tollfree</th>
                                    <th>Current Scope Basic User</th>
                                    <th>Current Scope Office Manager</th>
                                    <th>Current Scope Super User</th>
                                    <th>Current Service Code System Aa</th>
                                    <th>Current Service Code System Conf</th>
                                    <th>Current Service Code System Queue</th>
                                    <th>Current Service Code System User</th>
                                    <th>Current Registered Device</th>
                                    <th>Current Device</th>
                                    <th>Calculation Time Ms</th>
                                    <th>Active Calls Onnet Last</th>
                                    <th>Active Calls Offnet Last</th>
                                    <th>Active Calls Onnet Current</th>
                                    <th>Active Calls Offnet Current</th>
                                    <th>SMS Inbound Last</th>
                                    <th>SMS Inbound Current</th>
                                    <th>SMS Inbound Today</th>
                                    <th>SMS Outbound Today</th>
                                    <th>SMS Outbound Current</th>
                                    <th>SMS Outbound Last</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($domains as $domain)
                                <tr>
                                <td><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#action_modal" onclick="settoken(this);"><i class="fa fa-key"></i>Edit</button></td>
                                    <td><a href="/pbxdomain/{{$domain['domain']}}" target="_blank">{{$domain['domain']}}</a></td>
                                    <td>{{$domain['description']}}</td>
                                    <td>{{$domain['territory']}}</td>
                                    <td>{{$domain['call_limit']}}</td>
                                    <td>{{$domain['max_call_queue']}}</td>
                                    <td>{{$domain['max_aa']}}</td>
                                    <td>{{$domain['max_conference']}}</td>
                                    <td>{{$domain['max_department']}}</td>
                                    <td>{{$domain['max_user']}}</td>
                                    <td>{{$domain['current_user']}}</td>
                                    <td>{{$domain['current_department']}}</td>
                                    <td>{{$domain['current_queue']}}</td>
                                    <td>{{$domain['current_agent']}}</td>
                                    <td>{{$domain['current_park']}}</td>
                                    <td>{{$domain['current_aa']}}</td>
                                    <td>{{$domain['current_conference']}}</td>
                                    <td>{{$domain['current_phonenumbers']}}</td>
                                    <td>{{$domain['current_tollfree']}}</td>
                                    <td>{{$domain['current_scope_Basic_User']}}</td>
                                    <td>{{$domain['current_scope_Office_Manager']}}</td>
                                    <td>{{$domain['current_scope_Super_User']}}</td>
                                    <td>{{$domain['current_service_code_system-aa']}}</td>
                                    <td>{{$domain['current_service_code_system-conf']}}</td>
                                    <td>{{$domain['current_service_code_system-queue']}}</td>
                                    <td>{{$domain['current_service_code_system-user']}}</td>
                                    <td>{{$domain['current_registered_device']}}</td>
                                    <td>{{$domain['current_device']}}</td>
                                    <td>{{$domain['calculation_time_ms']}}</td>
                                    <td>{{$domain['active_calls_onnet_last']}}</td>
                                    <td>{{$domain['active_calls_offnet_last']}}</td>
                                    <td>{{$domain['active_calls_onnet_current']}}</td>
                                    <td>{{$domain['active_calls_offnet_current']}}</td>
                                    <td>{{$domain['sms_inbound_last']}}</td>
                                    <td>{{$domain['sms_inbound_current']}}</td>
                                    <td>{{$domain['sms_inbound_today']}}</td>
                                    <td>{{$domain['sms_outbound_today']}}</td>
                                    <td>{{$domain['sms_outbound_current']}}</td>
                                    <td>{{$domain['sms_outbound_last']}}</td>
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
            "order": [[ 0, "asc" ]],
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
                url: "{{ route('apisv2.netsapiens.pulldomainsummaries') }}?api_token={{auth()->user()->api_token}}",
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
