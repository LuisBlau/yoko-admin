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
                            <h3>Domains</h3>
                            <small>
                                Table for netsapiens domains
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default btn-pull"><span class="pe-7s-refresh-2"></span>&nbsp;&nbsp;Pull Domains from PBX </button>
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
                                    <th>Territory</th>
                                    <th>Dial Match</th>
                                    <th>Description</th>
                                    <th>MOH</th>
                                    <th>MOR</th>
                                    <th>MOT</th>
                                    <th>RMOH</th>
                                    <th>Rating</th>
                                    <th>RESI</th>
                                    <th>Mksdir</th>
                                    <th>Call Limit</th>
                                    <th>Call Limit Ext</th>
                                    <th>Sublimit</th>
                                    <th>Max Call Queue</th>
                                    <th>Max Aa</th>
                                    <th>Max Conference</th>
                                    <th>Max Department</th>
                                    <th>Mksmax Userdir</th>
                                    <th>Max Device</th>
                                    <th>Timezone</th>
                                    <th>Dial Plan</th>
                                    <th>Dial Policy</th>
                                    <th>Policies</th>
                                    <th>Email Sender</th>
                                    <th>SMTP Host</th>
                                    <th>SMTP Port</th>
                                    <th>SMTP UID</th>
                                    <th>SMTP PWD</th>
                                    <th>From User</th>
                                    <th>From Host</th>
                                    <th>Active Call</th>
                                    <th>Count For Limit</th>
                                    <th>Count External</th>
                                    <th>Subcount</th>
                                    <th>Max Site</th>
                                    <th>Max Fax</th>
                                    <th>SSO</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($domains as $domain)
                                <tr>
                                <td><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#action_modal" onclick="settoken(this);"><i class="fa fa-key"></i>Edit</button></td>
                                    <td><a href="/pbxdomain/{{$domain['domain']}}" target="_blank">{{$domain['domain']}}</a></td>
                                    <td>{{$domain['territory']}}</td>
                                    <td>{{$domain['dial_match']}}</td>
                                    <td>{{$domain['description']}}</td>
                                    <td>{{$domain['moh']}}</td>
                                    <td>{{$domain['mor']}}</td>
                                    <td>{{$domain['mot']}}</td>
                                    <td>{{$domain['rmoh']}}</td>
                                    <td>{{$domain['rating']}}</td>
                                    <td>{{$domain['resi']}}</td>
                                    <td>{{$domain['mksdir']}}</td>
                                    <td>{{$domain['call_limit']}}</td>
                                    <td>{{$domain['call_limit_ext']}}</td>
                                    <td>{{$domain['sub_limit']}}</td>
                                    <td>{{$domain['max_call_queue']}}</td>
                                    <td>{{$domain['max_aa']}}</td>
                                    <td>{{$domain['max_conference']}}</td>
                                    <td>{{$domain['max_department']}}</td>
                                    <td>{{$domain['max_user']}}</td>
                                    <td>{{$domain['max_device']}}</td>
                                    <td>{{$domain['time_zone']}}</td>
                                    <td>{{$domain['dial_plan']}}</td>
                                    <td>{{$domain['dial_policy']}}</td>
                                    <td>{{$domain['policies']}}</td>
                                    <td>{{$domain['email_sender']}}</td>
                                    <td>{{$domain['smtp_host']}}</td>
                                    <td>{{$domain['smtp_port']}}</td>
                                    <td>{{$domain['smtp_uid']}}</td>
                                    <td>{{$domain['smtp_pwd']}}</td>
                                    <td>{{$domain['from_user']}}</td>
                                    <td>{{$domain['from_host']}}</td>
                                    <td>{{$domain['active_call']}}</td>
                                    <td>{{$domain['countForLimit']}}</td>
                                    <td>{{$domain['countExternal']}}</td>
                                    <td>{{$domain['sub_count']}}</td>
                                    <td>{{$domain['max_site']}}</td>
                                    <td>{{$domain['max_fax']}}</td>
                                    <td>{{$domain['sso']}}</td>
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
                url: "{{ route('apisv2.netsapiens.pulldomains') }}?api_token={{auth()->user()->api_token}}",
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
