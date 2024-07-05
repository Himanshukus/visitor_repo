<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- preloader css -->

    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <title>Login</title>
    <style>
        body {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
        }
        .card {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="auth-page">
        <div class="container-fluid p-0 d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="row g-0 w-100">
                <div class="col-xxl-3 col-lg-4 col-md-5 mx-auto">
                    <div class="card shadow-lg p-sm-5 p-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5 text-center">
                                    <img src="{{ url('assets/images/logo/Seser_logo_horizontal_purple.png') }}" alt="" height="40">
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">Welcome Back !</h5>
                                        <p class="text-muted mt-2">Sign in to continue to .</p>
                                    </div>
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form class="mt-4 pt-2" action="{{ route('pwreset') }}" method="post">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Enter email" name="email" value="">
                                            @error('email')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 mt-4">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type='submit' name='submit' value='Submit'>Reset</button>
                                        </div>
                                    </form>

                                    <div class="mt-5 text-center">
                                        <p class="text-muted mb-0">Remember It ? <a href="{{ route('login') }}"
                                                class="text-primary fw-semibold"> Sign In </a> </p>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> with <i class="mdi mdi-heart text-danger"></i> by BeaconCoders
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
    </div>

    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/libs/pace-js/pace.min.js"></script>

    <script src="assets/js/pages/pass-addon.init.js"></script>



</body>

</html>
