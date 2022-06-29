<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

    <!-- Page title -->
    <title>Forgot Password | Yoko</title>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/vendor/fontawesome/css/font-awesome.css"/>
    <link rel="stylesheet" href="/vendor/animate.css/animate.css"/>
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="/vendor/toastr/toastr.min.css"/>
    <!-- App styles -->
    <link rel="stylesheet" href="/styles/pe-icons/pe-icon-7-stroke.css"/>
    <link rel="stylesheet" href="/styles/pe-icons/helper.css"/>
    <link rel="stylesheet" href="/styles/stroke-icons/style.css"/>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body class="blank">

<!-- Wrapper-->
<div class="wrapper">


    <!-- Main content-->
    <section class="content">
        <div class="container-center animated slideInDown">

            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-id"></i>
                </div>
                <div class="header-title">
                    <h3>Forgot password</h3>
                    <small>
                        Please input your email address to reset your password.
                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-body">
                    <form id="frm-default" method="post">
                        <div class="loader">
                            <div class="loader-bar"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="emailaddress">Email address</label>
                            <input type="email" placeholder="example@gmail.com" name="emailaddress" id="emailaddress" class="form-control">
                            <span class="form-text small">Your address email to send new password</span>
                        </div>
                        <div>
                            <button class="btn btn-accent btn-send">Send new password</button>
                            <a class="btn btn-default" href="/">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->

</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="/vendor/pacejs/pace.min.js"></script>
<script src="/vendor/jquery/dist/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/toastr/toastr.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/jquery.validate.min.js') }}"></script>
<!-- App scripts -->
<script src="scripts/luna.js"></script>
<script>
$(document).ready(function() {
    $('.btn-send').click(function() {
        var frm = $('#frm-default');
        frm.validate({
            rules: {
                "emailaddress": {
                    required: true,
                    email: true
                },
            },
            messages: {
                "emailaddress": {
                    required: "Please enter email address.",
                },
            },
            submitHandler: function(frm) {

            }
        });
        if(frm.valid()) {
            overlay = $('<div></div>').prependTo('body').attr('id', 'overlay');
            $('#frm-default').toggleClass('ld-loading'); //Loading...

            var data_post = frm.serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('api.users.sendnewpassword') }}",
                data:data_post,
                success: function (data, status, jqXHR) {
                    overlay.remove();
                    $('#frm-default').toggleClass('ld-loading'); //Loading...

                    //console.log(data);
                    toastr.success("An instruction has been emailed to " + $('#emailaddress').val() + ".");
                    setTimeout(function(){ location.reload(); }, 3000);
                },
                error: function (jqXHR, status) {
                    overlay.remove();
                    $('#frm-default').toggleClass('ld-loading'); //Loading...

                    //console.log(jqXHR);
                    toastr.error(jqXHR.responseJSON.message);
                }
            });
        }
    });
});
</script>
</body>
</html>
