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
                            <h3>Test Send - Peerless</h3>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-body">
                            <form class="frm">
                                <div class="form-group"><label for="to">To</label> <input type="text" class="form-control" name="to" placeholder="Phone Number" value="+18014251023"></div>
                                <div class="form-group"><label for="from">From</label> <input type="text" class="form-control" name="from" placeholder="Phone Number" value="+16305800201"></div>
                                <div class="form-group">
                                    <label>Text</label>
                                    <textarea class="form-control" rows="3" placeholder="SMS Text" name="text">This is a test!</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="mediaURL">MMS Media Link</label>
                                    <textarea class="form-control" rows="3" placeholder="MMS Media Link" name="media">https://pbs.twimg.com/profile_images/875749462957670400/T0lwiBK8_400x400.jpg</textarea>
                                </div>
                                <div>
                                    <input type="button" class="btn btn-default btn-send" value="Send"></input>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- End main content-->

<script>
    $(document).ready(function () {
         $('.btn-send').click(function() {
            var frm = $('.frm');
            var data_post = frm.serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('apisv2.users.collection') }}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:data_post,
                success: function (data, status, jqXHR) {
                    //console.log(data);
                    toastr.success(JSON.parse(data).responseText);
                },
                error: function (jqXHR, status) {
                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
         });
    });
</script>
@endsection