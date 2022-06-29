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
                            <h3>API Review</h3>
                            <small>
                                Table for api collection
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table id="maintable" class="table table-striped table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Headers</th>
                                        <th>Body</th>
                                        <th>API Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <!--tr style="cursor:pointer;" data-toggle="modal" data-target="#popup_modal" onclick="loaddetails(id);"-->
                                </tbody>
                            </table>
                            <div class="modal fade" id="popup_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Details</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                            <p>Headers</p>
                                            <pre class="m-t-sm requestheaders"></pre>
                                            <p>Body</p>
                                            <pre class="m-t-sm requestbody"></pre>
                                            <p>API Date</p>
                                            <pre class="m-t-sm apidate"></pre>
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
<script src="vendor/datatables/datatables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        table = $('#maintable').DataTable({
            "order": [[ 2, "desc" ]],
            "scrollX":true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
            rowId: 'message_id',
            columns: [
                { data: 'headers' },
                { data: 'body' },
                { data: 'apiDate' }
            ],
            "info": false,
            "ajax": "{{ route('api.apicollection.ajaxapireviewdata') }}?api_token={{auth()->user()->api_token}}",
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
    });

    $('#maintable').on( 'click', 'tr', function () {
        var id = table.row( this ).id();
        loaddetails(id);
        $('#popup_modal').modal('toggle');
    });

    function loaddetails(idx) {
        $.ajax({
            type: "POST",
            url: "{{ route('api.apicollection.loaddetails') }}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{idx:idx},
            dataType: "json",
            success: function (data, status, jqXHR) {
                //console.log(data);

                $('.requestheaders').html('');
                var headers = data.headers.split(', ');
                for(var i in headers) {
                    $('.requestheaders').append(headers[i]);
                    $('.requestheaders').append('<br>');
                }

                var requestbody = data.body?JSON.parse(data.body):'';
                $('.requestbody').html(JSON.stringify(requestbody, null, "\t"));

                $('.apidate').html(data.apiDate);
            },
            error: function (jqXHR, status) {
                console.log(jqXHR);
            }
        });
    }
</script>
@endsection