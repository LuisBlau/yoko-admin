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
                            <h3>Agent Availability Configuration</h3>
                            <small>
                                Table for agent availability configuration
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
                            <h4>Weekly schedule</h4>
                        </div>
                        <div class="panel-body">
                            <form method="post" id="frm-weeklyschedule">
                            <table class="table table-bordered table-responsive-sm">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                    <th>Sun</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Start</td>
                                        <td><input type="time" id="mon_start" name="mon_start" required value="{{isset($ws['mon_start'])?$ws['mon_start']:''}}"></td>
                                        <td><input type="time" id="tue_start" name="tue_start" required value="{{isset($ws['tue_start'])?$ws['tue_start']:''}}"></td>
                                        <td><input type="time" id="wed_start" name="wed_start" required value="{{isset($ws['wed_start'])?$ws['wed_start']:''}}"></td>
                                        <td><input type="time" id="thu_start" name="thu_start" required value="{{isset($ws['thu_start'])?$ws['thu_start']:''}}"></td>
                                        <td><input type="time" id="fri_start" name="fri_start" required value="{{isset($ws['fri_start'])?$ws['fri_start']:''}}"></td>
                                        <td><input type="time" id="sat_start" name="sat_start" required value="{{isset($ws['sat_start'])?$ws['sat_start']:''}}"></td>
                                        <td><input type="time" id="sun_start" name="sun_start" required value="{{isset($ws['sun_start'])?$ws['sun_start']:''}}"></td>
                                    </tr>
                                    <tr>
                                        <td>End</td>
                                        <td><input type="time" id="mon_end" name="mon_end" required value="{{isset($ws['mon_end'])?$ws['mon_end']:''}}"></td>
                                        <td><input type="time" id="tue_end" name="tue_end" required value="{{isset($ws['tue_end'])?$ws['tue_end']:''}}"></td>
                                        <td><input type="time" id="wed_end" name="wed_end" required value="{{isset($ws['wed_end'])?$ws['wed_end']:''}}"></td>
                                        <td><input type="time" id="thu_end" name="thu_end" required value="{{isset($ws['thu_end'])?$ws['thu_end']:''}}"></td>
                                        <td><input type="time" id="fri_end" name="fri_end" required value="{{isset($ws['fri_end'])?$ws['fri_end']:''}}"></td>
                                        <td><input type="time" id="sat_end" name="sat_end" required value="{{isset($ws['sat_end'])?$ws['sat_end']:''}}"></td>
                                        <td><input type="time" id="sun_end" name="sun_end" required value="{{isset($ws['sun_end'])?$ws['sun_end']:''}}"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-default btn-save-weeklyschedule" type="button"><i class="fa fa-save"></i> Save</button>
                            </form>
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
                            <h4>Non-Working Days</h4>
                            <input type="date" id="nonworkingday" name="nonworkingday" min="2021-01-01" max="2099-12-31" required />
                            <button class="btn btn-default btn-sm btn-add-nonworkingday" type="button"><i class="fa fa-plus"></i> Add</button>
                        </div>
                        <div class="panel-body">
                            <table class="table table-responsive-sm" id="nonworkingdays">
                                <thead>
                                </thead>
                                <tbody>
                                    @foreach($nwds as $nwd)
                                    <tr>
                                        <td width="130px">{{$nwd}}</td>
                                        <td><button class="btn btn-default btn-xs" onclick="removedt('{{$nwd}}');"><i class="pe-7s-close"></i>Remove</button></td>
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
<script type="text/javascript" src="{{ asset('assets/jquery.validate.min.js') }}"></script>
<script src="vendor/datatables/datatables.min.js"></script>
<script>
    function removedt(dt) {
        overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
        $.ajax({
            type: "POST",
            url: "{{ route('api.agentavailabilityconfig.deletenonworkingday') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{nonworkingday:dt},
            success: function (data, status, jqXHR) {
                overlay.remove();
                //console.log(data);
                toastr.success("It has been deleted successfully.");
                setTimeout(function(){ location.reload(); }, 1000);
            },
            error: function (jqXHR, status) {
                overlay.remove();
                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
    }
    $(document).ready(function () {
        $('.btn-save-weeklyschedule').click(function() {
            var frm = $('#frm-weeklyschedule');
            if(frm.valid()) {
                frm.toggleClass('ld-loading'); //Loading...
                overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
                $.ajax({
                    type: "POST",
                    url: "{{ route('api.agentavailabilityconfig.saveweeklyschedule') }}?api_token={{auth()->user()->api_token}}",
                    headers: {
                        'Authorization': `Bearer {{auth()->user()->api_token}}`,
                    },
                    data:{data:frm.serialize()},
                    success: function (data, status, jqXHR) {
                        overlay.remove();
                        frm.toggleClass('ld-loading');

                        //console.log(data);
                        toastr.success("Weekly schedule has been updated.");
                    },
                    error: function (jqXHR, status) {
                        overlay.remove();
                        frm.toggleClass('ld-loading');

                        //console.log(jqXHR);
                        toastr.error(jqXHR.responseJSON.message);
                    }
                });
            }
        });

        $('.btn-add-nonworkingday').click(function() {
            var nonworkingday = $('#nonworkingday').val();
            if(!nonworkingday) {
                toastr.error('Please input a non-working date.');
                return;
            }
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $.ajax({
                type: "POST",
                url: "{{ route('api.agentavailabilityconfig.addnonworkingday') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{nonworkingday:nonworkingday},
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    //console.log(data);
                    toastr.success("New non-working day has been added.");
                    setTimeout(function(){ location.reload(); }, 1000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
