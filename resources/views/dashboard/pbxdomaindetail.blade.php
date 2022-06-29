@extends('layouts.appuser')

@section('content')
     <!-- Main content-->
     <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-albums"></i>
                        </div>
                        <div class="header-title">
                            <h3>Domain Overview - {{$domain}}</h3>
                            <small>
                                Table for message logs
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-lg-6">
                    @if(count($domains)>0)
                    <select class="domain form-control" name="domain" style="width: 100%" onchange="loadboard(this.value);">
                        @foreach($domains as $d)
                        <option value="{{$d}}" <?php echo $d==$domain?"selected":""; ?> >{{$d}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Number of Phone Numbers</div>
                            <h2 class="m-b-none server1">{{$num['numext']}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <div class="small">Number of Phone # with SMS Enabled</div>
                            <h2 class="m-b-none server2">{{$num['numextsms']}}</h2>
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
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
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
<script src="/vendor/datatables/datatables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!--script src="https://cdn.datatables.net/plug-ins/1.10.25/pagination/select.js"></script-->

<script>
/* 
  Based on select paging plugin
  https://datatables.net/plug-ins/pagination/select
*/

$.fn.dataTable.SelectPager = function ( context ) {
  var table = new $.fn.dataTable.Api( context );
  var tableId = context.nTable.id;

  // Build select input
  var nPaging = document.createElement('div');
  var nLabel = document.createElement('label');
  var nInput = document.createElement('select');
  var nPage = document.createElement('span');
  var nOf = document.createElement('span');
  nOf.className = "paginate_of";
  nLabel.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Page ";
  if (tableId !== '') {
    nPaging.setAttribute('id', tableId + '_paginate');
    nPaging.className = "dataTables_length";
    nPaging.style.display = "inline";
  }
  nInput.style.width = "75px";
  nInput.className = "form-control form-control-sm";
  
  nLabel.appendChild(nInput);
  nPaging.appendChild(nLabel);
  nLabel.appendChild(nOf);
  nLabel.appendChild(nPage);
  $(nInput).change(function (e) { // Set DataTables page property and redraw the grid on select change event.
    window.scroll(0,0); //scroll to top of page
    if (this.value === "" || this.value.match(/[^0-9]/)) { /* Nothing entered or non-numeric character */
      return;
    }
    
    // Extract table ID from select div.
    tableId = '#' + $(this).closest('div').prop('id').replace('_paginate', '');
    var newPage = this.value * 1 - 1;  // First page is page 0.
    $(tableId).DataTable().page(newPage).draw(false);  // false to remain on page.
  }); /* Take the brutal approach to cancelling text selection */
  $('span', nPaging).bind('mousedown', function () {
    return false;
  });
  $('span', nPaging).bind('selectstart', function () {
    return false;
  });

  this.node = function () {
    return nPaging;
  };

};

$.fn.DataTable.SelectPager = $.fn.dataTable.SelectPager;

$.fn.dataTable.ext.feature.push( {
  fnInit: function ( settings ) {
    var select = new $.fn.dataTable.SelectPager( settings );
    return select.node();
  },
  cFeature: 'S'
} );
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
    function loadboard(val) {
        console.log(val);
        location.href="/home?v="+val;
    }
    $(document).ready(function () {
        $('#maintable').on('draw.dt', function (e, settings) {
    // Get Datatable.
    var table = new $.fn.dataTable.Api( settings );
    var tableId = settings.nTable.id;
    
    var selectPager = document.getElementById(tableId + '_paginate');
    if (selectPager) {
      
      // Get current page and total pages.
      var iPages = table.page.info().pages;
      var iCurrentPage = table.page.info().page;
      
      // Get select elements.
      var spans = selectPager.getElementsByTagName('span');
      var inputs = selectPager.getElementsByTagName('select');
      elSel = inputs[0];
      
      // Update select options if number of pages has changed.
      if(elSel.options.length != iPages) {
        elSel.options.length = 0; //clear the listbox contents
        for (var j = 0; j < iPages; j++) { //add the pages
          var oOption = document.createElement('option');
          oOption.text = j + 1;
          oOption.value = j + 1;
          try {
            elSel.add(oOption, null); // standards compliant; doesn't work in IE
          } catch (ex) {
            elSel.add(oOption); // IE only
          }
        }
        spans[1].innerHTML = "&nbsp;of&nbsp;" + iPages;
      }
      elSel.value = iCurrentPage + 1;
    }
    document.getElementById('maintable_length').style.display = "inline";
  }).DataTable({
            "order": [[ 7, "desc" ]],
            "scrollX":true,
            dom: 'lSftrip',
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            "processing": false,
            "serverSide": true,
            "autoWidth": true,
            "paging": true,
            "searching": true,
            "ordering": true,
            //"sPaginationType": "listbox",
            "language": {
                "zeroRecords": "No data Found",
                "processing": 'Loading...'
            },
            columnDefs: [ 
                { "width": "110px", "targets": [1,2] }
            ],
            "info": false,
            "ajax": "{{ route('api.sms.domainoverview') }}?api_token={{auth()->user()->api_token}}&domain={{$domain}}",
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