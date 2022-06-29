@extends(auth()->user()->role_id==1?'layouts.app':'layouts.appuser')

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
                            <h3>TenStreet API Review</h3>
                            <small>
                                Table for tenstreet collection
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
                                <tbody></tbody>
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
                                            <br>
                                            <p>Body</p>
                                            <pre class="m-t-sm requestbody"></pre>
                                            <br>
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
    function formatXml(xml) {
        var formatted = '';
        var reg = /(>)(<)(\/*)/g;
        xml = xml.replace(reg, '$1\r\n$2$3');
        var pad = 0;
        jQuery.each(xml.split('\r\n'), function(index, node) {
            var indent = 0;
            if (node.match( /.+<\/\w[^>]*>$/ )) {
                indent = 0;
            } else if (node.match( /^<\/\w/ )) {
                if (pad != 0) {
                    pad -= 1;
                }
            } else if (node.match( /^<\w[^>]*[^\/]>.*$/ )) {
                indent = 1;
            } else {
                indent = 0;
            }

            var padding = '';
            for (var i = 0; i < pad; i++) {
                padding += '  ';
            }

            formatted += padding + node + '\r\n';
            pad += indent;
        });

        return formatted;
    }
    $(document).ready(function () {
        table = $('#maintable').DataTable({
            "order": [[ 2, "desc" ]],
            "scrollX":true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "processing": true,
            "serverSide": true,
            "paging": true,
            "searching": true,
            "ordering": true,
            "language": {
                "zeroRecords": "No data Found",
                "processing": 'Loading...'
            },
            rowId: 'id',
            columns: [
                { data: 'headers' },
                { data: 'body' },
                { data: 'apiDate' }
            ],
            "info": false,
            "ajax": "{{ route('api.apicollection.ajaxtenstreetreviewdata') }}?api_token={{auth()->user()->api_token}}",
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
            url: "{{ route('api.apicollection.loadtenstreetdetails') }}",
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

                //var requestbody = data.body?JSON.parse(data.body):'';
                var requestbody = data.body?formatXml(data.body):'';
                $('.requestbody').html(requestbody.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/ /g, '&nbsp;'));

                $('.apidate').html(data.apiDate);
            },
            error: function (jqXHR, status) {
                console.log(jqXHR);
            }
        });
    }
</script>
@endsection