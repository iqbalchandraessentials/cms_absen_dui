<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In</title>
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
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="account-card-box">
                        <div class="card mb-0">
                            <div class="card-body p-4">
                                <form action="{{ route('up.login') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="text-center">
                                        <div class="my-3">
                                            <a href="/">
                                                <span><img src="{{ asset('style/dist/assets/images/dieselone-logo.png') }}" alt="" height="50" width="150"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input class="form-control" type="text" required="" placeholder="NIK" name="nik">
                                    </div>
                                    <div class="form-group mb-3">
                                        <input class="form-control" type="date" required="" id="tanggal_lahir" placeholder="Tanggal Lahir" name="tanggal_lahir">
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-block waves-effect waves-light" type="submit" style="background-color: #2B3D51"> Log In </button>
                                    </div>
                                </form>
                                <div class="col-12">
                                    @if (Session::has('error'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Oopss!</strong> {{ Session::get('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
        <!-- end container -->
    </div>
    <!-- Vendor js -->
    <script src="{{ asset('style/dist/assets/js/vendor.min.js') }}"></script>
</body>

</html>
