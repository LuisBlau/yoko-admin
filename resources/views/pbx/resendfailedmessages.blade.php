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
                            <h3>Resend Failed Messages</h3>
                            <small>
                                Table for failed message logs
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
                            Start Date/Time: &nbsp;<input type="datetime-local" id="starttime" name="starttime" value="{{$min}}" min="2021-01-01T00:00" max="2099-12-31T00:00">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-body">
                            End Date/Time: &nbsp;<input type="datetime-local" id="endtime" name="endtime" value="{{$max}}" min="2021-01-01T00:00" max="2099-12-31T00:00">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel">
                        <div class="panel-body">
                        <a href="#" class="btn btn-sm btn-default btn-resend">&nbsp; Resend &nbsp;</a>
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
                                <tbody></tbody>
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
<script src="vendor/datatables/datatables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    function formatPhoneNumber(phoneNumberString) {
        var cleaned = ('' + phoneNumberString).replace(/\D/g, '')
        var match = cleaned.match(/^(1|)?(\d{3})(\d{3})(\d{4})$/)
        if (match) {
            var intlCode = (match[1] ? '+1 ' : '')
            return [intlCode, '(', match[2], ') ', match[3], '-', match[4]].join('')
        }
        return null
    }
    function reformatphone(p) {
        return p.replace(' ','').replace('(','').replace(') ','').replace('-','');
    }
    function imgerr(img) {
        if (img.src != '/images/no_image_available.png') {
            img.src = '/images/no_image_available.png';
        }
    }
    function loaddetails(tr,type) {
        if(type) {
            //$('.contents').attr("src",tr.innerText);
            var imgurl = tr.innerText;
            if(tr.innerText.indexOf('/core1-chi.yokopbx.com/ns-api')>0) {
                var url = new URL(imgurl);
                var id = url.searchParams.get("id");
                imgurl = 'https://yokopbx.s3.us-east-2.amazonaws.com/'+id;
            }
            $('.contentmodal').html('<img class="contents" src="' + imgurl + '" onerror="imgerr(this)"></img>');
        } else {
            $('.contentmodal').html(tr.innerText);
        }
    }
    function loadgrid() {
        var starttime = $('#starttime').val();
        var endtime = $('#endtime').val();
        $('#maintable').DataTable({
            "order": [[ 7, "desc" ]],
            "scrollX":true,
            "bDestroy": true,
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
            columnDefs: [ 
                { "width": "110px", "targets": [1,2] }
            ],
            "info": false,
            "ajax": "{{ route('api.sms.failedsmsmmshistory') }}?api_token={{auth()->user()->api_token}}&starttime="+starttime+"&endtime="+endtime,
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'CSV File', className: 'btn-sm'},
                {extend: 'pdf', title: 'PDF File', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ]
        });
    }
    $(document).ready(function () {
        $('#starttime').change(function(){
            loadgrid();
        });
        $('#endtime').change(function(){
            loadgrid();
        });
        loadgrid();
        $('.btn-resend').click(function() {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('.content').toggleClass('ld-loading'); //Loading...

            $.ajax({
                type: "POST",
                url: "{{ route('api.pbx.resendfailedmessages') }}?api_token={{auth()->user()->api_token}}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{starttime:$('#starttime').val(), endtime:$('#endtime').val()},
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('.content').toggleClass('ld-loading'); //Loading...
                    
                    if(data.cnt == 0) {
                        toastr.info("No record has been resent. " + data.fcnt + " failed.");
                    } else if(data.cnt == 1) {
                        toastr.success("1 record has been resent. " + data.fcnt + " failed.");
                    } else if(data.cnt > 1) {
                        toastr.success(data.cnt + " records have been resent. " + data.fcnt + " failed.");
                    }
                    setTimeout(function() { location.reload(); }, 3000);                        
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('.content').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection