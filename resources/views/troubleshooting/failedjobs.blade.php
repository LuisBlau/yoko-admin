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
                            <h3>Failed SMS Sends</h3>
                            <small>
                                Table for failed jobs
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
                                    <th>ID</th>
                                    <th>Message ID</th>
                                    <th>Payload</th>
                                    <th>Exception</th>
                                    <th>Failed At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($failedjobs as $failedjob)
                                <tr>
                                    <td>{{$failedjob['id']}}</a></td>
                                    <td>{{$failedjob['message_id']}}</td>
                                    <td>{{$failedjob['payload']}}</td>
                                    <td>{{$failedjob['exception']}}</td>
                                    <td>{{$failedjob['failed_at']}}</td>
                                </tr>
                                @endforeach
                                </tbody>
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
            "order": [[ 4, "desc" ]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
        });
    });
</script>
@endsection