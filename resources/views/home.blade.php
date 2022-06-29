@extends('layouts.app')

@section('content')
{{-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"> --}}
{{-- 2 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> --}}
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> --}}
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script> --}}
<link rel="stylesheet" href="{{ asset('assets/morris.css') }}">
<script src="{{ asset('assets/jquery.min.js') }}"></script>
<script src="{{ asset('assets/raphael-min.js') }}"></script>
<script src="{{ asset('assets/morris.min.js') }}"></script>
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
                            <h3>Dashboard</h3>
                            <small>
                            YOKO Networks
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="panel panel-filled">

                        <div class="panel-body">
                            <h2 class="m-b-none">
                                {{$total['in']}} <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i> </span>
                            </h2>

                            <div class="small">Total Inbound Messaging</div>
                            <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> Last <span class="c-white"> 24 H</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <h2 class="m-b-none">
                            {{$total['out']}} <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i> </span>
                            </h2>

                            <div class="small">Total Outbound Messaging</div>
                            <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> Last <span class="c-white">  24 H</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <h2 class="m-b-none">
                            {{$total['sms']}} <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i> </span>
                            </h2>

                            <div class="small">Total SMS Messaging</div>
                            <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> Last <span class="c-white"> 24 H</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <h2 class="m-b-none">
                            {{$total['mms']}} <span class="slight"><i class="fa fa-play fa-rotate-270 text-warning"> </i> </span>
                            </h2>

                            <div class="small">Total MMS Messaging</div>
                            <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> Last <span class="c-white"> 24 H</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="row">
                            <div class="col-md-4">

                                <div class="panel-body">
                                    <div class="stats-title">
                                        <h4><i class="fa fa-bar-chart text-warning" aria-hidden="true"></i> SMS Hourly</h4>
                                    </div>
                                    <div class="sparkline3">
                                        <canvas id="canvas" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="panel-body">
                                    <div class="stats-title">
                                        <h4><i class="fa fa-bar-chart text-warning" aria-hidden="true"></i> SMS/MMS Daily</h4>
                                    </div>
                                    <div class="flot-chart" style="height: 240px;width:100%;">
                                        <div class="flot-chart-content" id="flot-line-chart"></div>
                                    </div>
                                    <div class="small text-center">Day</div>
                                </div>
                            </div>

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
                                    <th>Direction</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Type</th>
                                    <th>Content</th>
                                    <th>Carrier</th>
                                    <th>Status</th>
                                    <th>Date/Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($msglogs as $msg)
                                <tr>
                                    <td>{{$msg['inbound']==1?'Inbound':'Outbound'}}</td>
                                    <td>{{formatphonenumber($msg['from'])}}</td>
                                    <td>{{formatphonenumber($msg['recipients'])}}</td>
                                    <td>{{$msg['mediaURL']?'MMS':'SMS'}}</td>
                                    <td style="cursor:pointer;" data-toggle="modal" data-target="#popup_modal" onclick="loaddetails(this,{{$msg['mediaURL']?1:0}});">
                                        {{$msg['mediaURL']?$msg['mediaURL']:$msg['text']}}
                                    </td>
                                    <td>{{$msg['carrier']}}</td>
                                    <td>{{$msg['responseText']}}</td>
                                    <td>{{ niceShort($msg['created_on']) }}</td>
                                </tr>
                                @endforeach
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- End main content-->
<script src="/vendor/chart.js/dist/Chart.min.js"></script>
<script src="/vendor/datatables/datatables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    function imgerr(img) {
        if (img.src != '/images/no_image_available.png') img.src = '/images/no_image_available.png';
    }
    function loaddetails(tr,type) {
        if(type) {
            //$('.contents').attr("src",tr.innerText);
            $('.contentmodal').html('<img class="contents" src="' + tr.innerText + '" onerror="imgerr(this)"></img>');
        } else {
            $('.contentmodal').html(tr.innerText);
        }
    }
    $(document).ready(function () {
        $('#maintable').DataTable({
            "processing": false,
            "autoWidth": false,
            "paging": false,
            "searching": false,
            "ordering": false,
            columnDefs: [
                { "width": "120px", "targets": [1,2] }
            ],
            fixedColumns: true,
            "info": false,
            buttons: []
        });

        // Sparkline charts
        $.ajax({
            type: "POST",
            url: "{{ route('api.dashboard.smshourly') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{},
            success: function (data, status, jqXHR) {
                var labels = [];
                var chartdata = [];
                for(var i=0;i<24;i++) {
                    labels.push(i);
                    chartdata.push(0);
                }
                for(var d in data) {
                    chartdata[data[d].h] = data[d].transaction;
                }
                var config = {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '',
                            backgroundColor: 'rgb(54, 162, 235)',
                            borderColor: 'rgb(54, 162, 235)',
                            data: chartdata,
                            fill: false,
                        }]
                    },
                    options: {
                        responsive: false,
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Hour'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'SMS Transactions'
                                }
                            }]
                        }
                    }
                };
                var ctx = document.getElementById('canvas');
                ctx.height = 256;
                ctx.width = $('.sparkline3').width();
                window.myLine = new Chart(ctx, config);
            },
            error: function (jqXHR, status) {
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('api.dashboard.smsdaily') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{},
            success: function (data, status, jqXHR) {
                Morris.Area({
                    element: 'flot-line-chart',
                    data: data,
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['SMS', 'MMS']
                });
            },
            error: function (jqXHR, status) {
            }
        });
    });
</script>
@endsection
