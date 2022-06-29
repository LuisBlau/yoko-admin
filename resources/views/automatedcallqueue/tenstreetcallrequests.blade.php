@extends($role==1?'layouts.app':'layouts.appuser')

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
                            <h3>TenStreet Call Requests</h3>
                            <small>
                                Table for tenstreet api collection
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            <h4>Waiting List</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive-sm" id="maintable">
                                <thead>
                                <tr>
                                    <th>Subject ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>PPhone</th>
                                    <th>SPhone</th>
                                    <th>Autocall</th>
                                    <th>Source</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                            </div>
                            <h4>Archived Call Requests</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive-sm" id="subtable">
                                <thead>
                                <tr>
                                    <th>Subject ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>PPhone</th>
                                    <th>SPhone</th>
                                    <th>Autocall</th>
                                    <th>Source</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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
    function send_to_queue(e) {
        //console.log($(e).parent().parent().attr('id'));
        var rid = $(e).parent().parent().attr('id');
        overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');

        $.ajax({
            type: "POST",
            url: "{{ route('api.tenstreetcallrequests.sendtoqueue') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{rid:rid},
            success: function (data, status, jqXHR) {
                overlay.remove();
                
                //console.log(data);
                toastr.success("The record has been pushed to PBX.");
                setTimeout(function() { location.reload(); }, 3000);                        
            },
            error: function (jqXHR, status) {
                overlay.remove();

                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }

    function archive_call_request(e) {
        //console.log($(e).parent().parent().attr('id'));
        var rid = $(e).parent().parent().attr('id');
        overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');

        $.ajax({
            type: "POST",
            url: "{{ route('api.tenstreetcallrequests.archivecallrequest') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{rid:rid},
            success: function (data, status, jqXHR) {
                overlay.remove();
                
                //console.log(data);
                toastr.success("The record has been archived.");
                setTimeout(function() { location.reload(); }, 500);                        
            },
            error: function (jqXHR, status) {
                overlay.remove();

                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }

    $(document).ready(function () {
        $('#maintable').DataTable({
            "order": [[ 0, "desc" ]],
            "scrollX":true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
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
            rowId: 'id',
            columns: [
                { data: 'subjectid' },
                { data: 'firstname' },
                { data: 'lastname' },
                { data: 'pphone' },
                { data: 'sphone' },
                { data: 'autocall' },
                { data: 'source' },
                { data: 'created_at' },
                { data: 'action' },
            ],
            "info": false,
            "ajax": "{{ route('api.automatedcallqueue.tenstreetcallrequests') }}?api_token={{auth()->user()->api_token}}",
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });

        $('#subtable').DataTable({
            "order": [[ 0, "desc" ]],
            "scrollX":true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[5, 10, 25, 50], [5, 10, 25, 50]],
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
            rowId: 'id',
            columns: [
                { data: 'subjectid' },
                { data: 'firstname' },
                { data: 'lastname' },
                { data: 'pphone' },
                { data: 'sphone' },
                { data: 'autocall' },
                { data: 'source' },
                { data: 'created_at' },
                { data: 'action' },
            ],
            "info": false,
            "ajax": "{{ route('api.automatedcallqueue.tenstreetarchivedcallrequests') }}?api_token={{auth()->user()->api_token}}",
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
    });
</script>
@endsection