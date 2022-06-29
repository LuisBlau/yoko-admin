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
                            <h3>Accounting Monthly Data</h3>
                            <small>
                                Table for daily billing counts
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-body">
                            Select Month & Year:<br><input type="month" id="starttime" name="starttime" value="{{date('Y-m')}}" onchange="javascript:loadgrid();">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-body">
                            Client:<br>
                            <select class="clientid form-control" name="clientid" id="clientid" style="width: 100%"  onchange="javascript:loadgrid();">
                                @foreach($clients as $client)
                                <option value="{{$client['id']}}">{{$client['client']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Avg Num Ext</div>
                            <h2 class="m-b-none avg_num_ext"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">MAX Num Ext</div>
                            <h2 class="m-b-none max_num_ext"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Total SMS Out</div>
                            <h2 class="m-b-none total_sms_out"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Total SMS In</div>
                            <h2 class="m-b-none total_sms_in"></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Total MMS Out</div>
                            <h2 class="m-b-none total_mms_out"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Total MMS In</div>
                            <h2 class="m-b-none total_mms_in"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Grand Total Out</div>
                            <h2 class="m-b-none grand_total_out"></h2>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Grand Total In</div>
                            <h2 class="m-b-none grand_total_in"></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                        <table class="table table-responsive-sm" id="maintable">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Date</th>
                                    <th>Num Ext</th>
                                    <th>SMS In</th>
                                    <th>MMS In</th>
                                    <th>SMS Out</th>
                                    <th>MMS Out</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="modal fade" id="popup_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Content</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <!--p>Content</p-->
                                            <pre class="m-t-sm contentmodal">
                                                
                                            </pre>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="history_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-circle"></div>
                                </div>
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Conversation History</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                        <div class="v-timeline vertical-container">
                                            <!--div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon">
                                                    <i class="fa fa-user c-accent"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <div class="p-sm">
                                                        <span class="vertical-date pull-right"> Saturday <br/> <small>12:17:43 PM</small> </span>
                                                        <h2>It is a long established fact</h2>
                                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                    </div>
                                                </div>
                                            </div-->
                                        </div>
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
<script src="/vendor/datatables/datatables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    function loadgrid() {
        var year_month = $('#starttime').val();
        var client_id = $('#clientid').val();
        $('#maintable').DataTable({
            "order": [[ 1, "desc" ]],
            "scrollX":true,
            "bDestroy": true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "processing": true,
            "serverSide": true,
            "autoWidth": true,
            "paging": true,
            "searching": true,
            "ordering": true,
            "language": {
                "zeroRecords": "No data Found",
                "processing": 'Loading...'
            },
            "columns": [
                { "data": "domain" },
                { "data": "date_of_count" },
                { "data": "num_of_extensions" },
                { "data": "num_of_sms_messages_in" },
                { "data": "num_of_mms_messages_in" },
                { "data": "num_of_sms_messages_out" },
                { "data": "num_of_mms_messages_out" }
            ],
            columnDefs: [ 
                { "width": "110px", "targets": [1,2] }
            ],
            "info": false,
            "ajax": "{{ route('api.accounting.getmonthlydata') }}?api_token={{auth()->user()->api_token}}&year_month="+year_month+"&client_id="+client_id,
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

        $.ajax({
            type: "POST",
            url: "{{ route('api.accounting.getstats') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{year_month:year_month, client_id:client_id},
            success: function (data, status, jqXHR) {
                console.log(data);
                $('.avg_num_ext').html(data.avg_num_ext);
                $('.grand_total_in').html(data.grand_total_in);
                $('.grand_total_out').html(data.grand_total_out);
                $('.max_num_ext').html(data.max_num_ext);
                $('.total_mms_in').html(data.total_mms_in);
                $('.total_mms_out').html(data.total_mms_out);
                $('.total_sms_in').html(data.total_sms_in);
                $('.total_sms_out').html(data.total_sms_out);
            },
            error: function (jqXHR, status) {
            }
        });
    }
    $(document).ready(function () {
        $('.clientid').select2();
        loadgrid();
    });
</script>
@endsection