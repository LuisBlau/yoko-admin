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
                            <h3>Switch Status</h3>
                            <small>
                                Statistics
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        Inbound from Carriers
                                    </th>
                                    <th>
                                        # of Calls
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="in_carrier">
                                    @foreach($total['in_carrier'] as $t)
                                    <tr>
                                        <td>{{$t['carrier']}}</td>
                                        <td><span class="usage1">{{$t['total']}}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        Outbound from Carriers
                                    </th>
                                    <th>
                                        # of Calls
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="out_carrier">
                                    @foreach($total['out_carrier'] as $t)
                                    <tr>
                                        <td>{{$t['carrier']}}</td>
                                        <td><span class="usage1">{{$t['total']}}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        Inbound to Clients
                                    </th>
                                    <th>
                                        # of Calls
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="in_clients">
                                    @foreach($total['in_clients'] as $t)
                                    <tr>
                                        <td>{{$t['from']}}</td>
                                        <td><span class="usage1">{{$t['total']}}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>
                                        Outbound from Clients
                                    </th>
                                    <th>
                                        # of Calls
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="out_clients">
                                    @foreach($total['out_clients'] as $t)
                                    <tr>
                                        <td>{{$t['recipients']}}</td>
                                        <td><span class="usage1">{{$t['total']}}</span></td>
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
        // Function to generate data
        function setUsage(selector){

            var usage1 = Math.floor(Math.random() * 100) + 1;
            $(selector).text(usage1 + '%');
            if (usage1 > 40) {
                $(selector).addClass('c-accent');
            } else {
                $(selector).removeClass('c-accent')
            }
        }

        // Generate data for-9874all span elements
        function generate() {
            //setUsage('.usage1');
            $.ajax({
                type: "POST",
                url: "{{ route('api.infrastructure.switchstatus') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{},
                success: function (data, status, jqXHR) {
                    var incarrier = '';
                    for(var i in data.in_carrier) {
                        incarrier += '<tr><td>' + data.in_carrier[i].carrier + '</td><td><span class="usage1">' + data.in_carrier[i].total + '</span></td></tr>';
                    }
                    $('#in_carrier').html(incarrier);

                    var inclients = '';
                    for(var i in data.in_clients) {
                        inclients += '<tr><td>' + data.in_clients[i].from + '</td><td><span class="usage1">' + data.in_clients[i].total + '</span></td></tr>';
                    }
                    $('#in_clients').html(inclients);

                    var outcarrier = '';
                    for(var i in data.out_carrier) {
                        outcarrier += '<tr><td>' + data.out_carrier[i].carrier + '</td><td><span class="usage1">' + data.out_carrier[i].total + '</span></td></tr>';
                    }
                    $('#out_carrier').html(outcarrier);

                    var outclients = '';
                    for(var i in data.out_clients) {
                        outclients += '<tr><td>' + data.out_clients[i].recipients + '</td><td><span class="usage1">' + data.out_clients[i].total + '</span></td></tr>';
                    }
                    $('#out_clients').html(outclients);
                },
                error: function (jqXHR, status) {
                    console.log(jqXHR);
                }
            });
        }
        // Run interval function
        usageInterval = setInterval(generate, 10000);
    });
</script>
@endsection