<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="{{url('assets/libs/choices.js/public/assets/styles/choices.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{url('assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- color picker css -->
    <link rel="stylesheet" href="{{url('assets/libs/@simonwep/pickr/themes/classic.min.css')}}" /> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{url('assets/libs/@simonwep/pickr/themes/monolith.min.css')}}" /> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{url('assets/libs/@simonwep/pickr/themes/nano.min.css')}}" /> <!-- 'nano' theme -->

    <!-- datepicker css -->
    <link rel="stylesheet" href="{{url('assets/libs/flatpickr/flatpickr.min.css')}}">
    <!-- preloader css -->
    <link href="{{ url('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="{{ url('assets/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <section class="layout-wrapper">
        <!-- NAVBAR -->
        @include('layouts.nav')
        <!-- NAVBAR -->
        <!-- SIDEBAR -->
        @include('layouts.sidebar')
        <!-- SIDEBAR -->

        <!-- CONTENT -->
        <section class="main-content">
            <!-- MAIN -->

            <section class="page-content">
                @yield('content')
            </section>

            <!-- MAIN -->
        </section>
        <!-- CONTENT -->

    </section>
    <script src="{{ url('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ url('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ url('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ url('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ url('assets/libs/pace-js/pace.min.js') }}"></script>
    
    
    {{-- <script src="{{url('assets/libs/dropzone/min/dropzone.min.js')}}"></script> --}}


    <script src="{{url('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>

    <!-- color picker js -->
    <script src="{{url('assets/libs/@simonwep/pickr/pickr.min.js')}}"></script>
    <script src="{{url('assets/libs/@simonwep/pickr/pickr.es5.min.js')}}"></script>

    <!-- datepicker js -->
    <script src="{{url('assets/libs/flatpickr/flatpickr.min.js')}}"></script>

    <!-- init js -->
    <script src="{{url('assets/js/pages/form-advanced.init.js')}}"></script>
    <!-- Plugins js-->
    <script src="{{ url('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ url('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>

    <!-- dashboard init -->
    <script src="{{ url('assets/js/pages/dashboard.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ url('assets/js/app.js') }}"></script>

</body>

</html>
