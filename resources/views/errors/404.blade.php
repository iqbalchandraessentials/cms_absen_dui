<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Finish Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

</head>

<body class="authentication-bg">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Finish Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('style/dist/assets/images/icon.png') }}">

        <!-- App css -->
        <link href="{{ asset('style/dist/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="{{ asset('style/dist/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />

    </head>

    <body class="authentication-bg">
        <div class="account-pages pt-5 my-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-8 col-xl-8">
                        <div class="account-card-box">
                            <div class="card mb-0">
                                <div class="card-body text-center">
                                    <h3 style="color: #519fe3">{{ $code }}</h3>
                                    <p class="card-text">{{ $message }}</p>
                                    <p style="color: red">-- Please contact administrator! --</p>
                                    <a class="btn btn-sm btn-secondary btn-round text-white" onclick="history.back()" style="cursor: pointer;">
                                        Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('style/dist/assets/js/vendor.min.js') }}"></script>
    </body>

    </html>




</html>
