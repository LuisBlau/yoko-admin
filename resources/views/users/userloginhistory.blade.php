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
                            <h3>User Login History</h3>
                            <small>
                                Table for logins
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
                                    <th>User ID</th>
                                    <th>IP Address</th>
                                    <th>Country</th>
                                    <th>Region</th>
                                    <th>City</th>
                                    <th>Date Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logins as $login)
                                <tr>
                                    <td>{{$login['id']}}</a></td>
                                    <td>{{$login['userid']}}</td>
                                    <td>{{$login['ip']}}</td>
                                    <td>{{$login['country']}}</td>
                                    <td>{{$login['region']}}</td>
                                    <td>{{$login['city']}}</td>
                                    <td>{{niceShort($login['created_at'])}}</td>
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
            // "processing": true,
            // "serverSide": true,
            "order": [[ 6, "desc" ]],
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
            /*
            "ajax": '{{ route('api.users.getuserloginhistory') }}?api_token={{auth()->user()->api_token}}',
            "columns": [
                { "data": "id" },
                { "data": "userid" },
                { "data": "ip" },
                { "data": "country" },
                { "data": "region" },
                { "data": "city" },
                { "data": "created_at" }
            ] */
        });
    });
</script>
@endsection