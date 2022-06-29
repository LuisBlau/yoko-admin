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
                            <h3>SMS Enabled Numbers</h3>
                            <small>
                                Table for netsapiens domain extensions with sms
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <button type="submit" class="btn btn-default btn-pull"><span class="pe-7s-refresh-2"></span>&nbsp;&nbsp;Pull SMS Extensions </button>
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
                                    <th>Number</th>
                                    <th>Application</th>
                                    <th>Dest</th>
                                    <th>Carrier</th>
                                    <th>MMS Capable</th>
                                    <th>Group MMS Capable</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($domains as $domain)
                                <tr>
                                    <td><button class="btn btn-default btn-xs" data-toggle="modal" data-target="#action_modal" onclick="settoken(this);"><i class="fa fa-key"></i>Edit</button></td>
                                    <td><a href="/pbxdomain/{{$domain['domain']}}" target="_blank">{{$domain['domain']}}</a></td>
                                    <td>{{formatphonenumber($domain['number'])}}</td>
                                    <td>{{$domain['application']}}</td>
                                    <td>{{$domain['dest']}}</td>
                                    <td>{{$domain['carrier']}}</td>
                                    <td>{{$domain['mmsCapable']}}</td>
                                    <td>{{$domain['groupMMSCapable']}}</td>
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
            columnDefs: [
                { "width": "110px", "targets": [2] }
            ],
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
                url: "{{ route('apisv2.netsapiens.pulldomainextensionwithsms') }}?api_token={{auth()->user()->api_token}}",
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
