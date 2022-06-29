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
                            <h3>SMS and MMS History</h3>
                            <small>
                                Table for message logs
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
                                    <th>Direction</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Type</th>
                                    <th>Content</th>
                                    <th>Carrier</th>
                                    <th>Status</th>
                                    <th>Date/Time</th>
                                    <th>Action</th>
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
                            <div class="modal fade" id="history_modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                                <div class="loader">
                                    <div class="loader-circle"></div>
                                </div>
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header text-center">
                                            <h4 class="modal-title">Conversation History</h4>
                                            <!--small>Details</small-->
                                        </div>
                                        <div class="modal-body">
                                        <div class="v-timeline vertical-container">
                                            <!--div class="vertical-timeline-block">
                                                <div class="vertical-timeline-icon">
                                                    <i class="fa fa-user c-accent"></i>
                                                </div>
                                                <div class="vertical-timeline-content">
                                                    <div class="p-sm">
                                                        <span class="vertical-date pull-right"> Saturday <br/> <small>12:17:43 PM</small> </span>
                                                        <h2>It is a long established fact</h2>
                                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                    </div>
                                                </div>
                                            </div-->
                                        </div>
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
    function setpn(e) {
        var chn = $(e).parent().parent().children();
        var from = reformatphone(chn[1].innerText);
        var to = reformatphone(chn[2].innerText);

        overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
        $('#history_modal').toggleClass('ld-loading'); //Loading...
        
        $.ajax({
            type: "POST",
            url: "{{ route('api.sms.history') }}?api_token={{auth()->user()->api_token}}",
            headers: {
                'Authorization': `Bearer {{auth()->user()->api_token}}`,
            },
            data:{from:from, to:to},
            success: function (data, status, jqXHR) {
                var html = "";
                for(var i in data[0]) {
                    var cls = "vertical-timeline-content-to";
                    var content =  data[0][i].text? data[0][i].text:'<img style="max-width:200px;" src="' + data[0][i].mediaURL + '" onerror="imgerr(this)"></img>';
                    if(from == data[0][i].from) {
                        cls = "vertical-timeline-content-from";
                    }
                    html = html + `<div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon">
                            <i class="fa fa-user c-accent"></i>
                        </div>
                        <div class="vertical-timeline-content ` + cls + `">
                            <div class="p-sm">
                                <span class="vertical-date pull-right"><small>` + data[0][i].created_on + `</small> </span>
                                <h4>` + formatPhoneNumber(data[0][i].from) + `</h4>
                                <p>` + content + `</p>
                            </div>
                        </div>
                    </div>`;
                }
                $('.vertical-container').html(html);

                overlay.remove();
                $('#history_modal').toggleClass('ld-loading'); //Loading...   
            },
            error: function (jqXHR, status) {
                overlay.remove();
                $('#history_modal').toggleClass('ld-loading'); //Loading...

                //console.log(jqXHR);
                toastr.error(jqXHR.responseJSON.message);
            }
        });
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
    $(document).ready(function () {
        $('#maintable').DataTable({
            "order": [[ 7, "desc" ]],
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
            columnDefs: [ 
                { "width": "110px", "targets": [1,2] }
            ],
            "info": false,
            "ajax": "{{ route('api.sms.ajaxsmsmmshistory') }}?api_token={{auth()->user()->api_token}}",
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