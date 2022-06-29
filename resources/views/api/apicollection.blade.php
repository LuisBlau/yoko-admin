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
                            <h3>API Collection</h3>
                            <small>
                                Request headers & body
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                    <label for="APIDestination">API Destination</label>
                    <input type="text" class="form-control" id="APIDestination" placeholder="URL..." value="http://ip-api.com/json?callback="></div>
                    <button type="submit" class="btn btn-default" id="getAPIContents">Submit</button>
                    <hr>
                    <p>Request Headers</p>
                    <pre class="m-t-sm requestheaders"></pre>
                    <p>Request Body</p>
                    <pre class="m-t-sm requestbody"></pre>
                    <p>Response Body</p>
                    <pre class="m-t-sm responsebody"></pre>
                </div>
            </div>
        </div>
    </section>
<!-- End main content-->
<script>
    $(document).ready(function () {
        $('#getAPIContents').click(function() {
            var url = $('#APIDestination').val();
            $.ajax({
                type: "POST",
                url: "{{ route('api.apicollection.getapicollection') }}",
                headers: {
                    'Authorization': `Bearer {{auth()->user()->api_token}}`,
                },
                data:{url:url},
                dataType: "json",
                success: function (data, status, jqXHR) {
                    console.log(data);
                    $('.requestheaders').html('');
                    for(var i in data.headers) {
                        $('.requestheaders').append(data.headers[i]);
                        $('.requestheaders').append('<br>');
                    }
                    //var requestbody = JSON.parse(data.requestbody);
                    var responsebody = JSON.parse(data.responsebody);
                    $('.requestbody').html(data.requestbody);
                    $('.responsebody').html(JSON.stringify(responsebody, null, "\t"));
                },
                error: function (jqXHR, status) {
                    console.log(jqXHR);
                }
            });
        });
    });
</script>
@endsection