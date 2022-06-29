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
                            <h3>TenStreet Call Log</h3>
                            <small>
                                Table for tenstreet log
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
                                    <th>Call Date</th>
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
    $(document).ready(function () {
        $('#maintable').DataTable({
            "order": [[ 0, "desc" ]],
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
            rowId: 'id',
            columns: [
                { data: 'subjectid' },
                { data: 'firstname' },
                { data: 'lastname' },
                { data: 'pphone' },
                { data: 'sphone' },
                { data: 'autocall' },
                { data: 'source' },
                { data: 'call_date' }
            ],
            "info": false,
            "ajax": "{{ route('api.automatedcallqueue.tenstreetrequestscalled') }}?api_token={{auth()->user()->api_token}}",
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