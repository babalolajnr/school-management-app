<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'APP') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/radiant_logo-removebg-preview.png') }}" type="image/x-icon">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('TAssets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('TAssets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('TAssets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    {{ $styles }}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('TAssets/dist/css/adminlte.min.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <x-navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <x-sidebar />
        {{-- Alerts --}}
        <span id="success" {{ session('success') ? 'data-success = true' : false }}
            data-success-message='{{ json_encode(session('success')) }}'></span>
        <span id="error" {{ session('error') ? 'data-error = true' : false }}
            data-error-message='{{ json_encode(session('error')) }}'></span>
        <!-- Content Wrapper. Contains page content -->
        {{ $slot }}
        <!-- /.content-wrapper -->

        <!-- footer -->
        <x-footer />

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('TAssets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('TAssets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('TAssets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('TAssets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('TAssets/dist/js/adminlte.min.js') }}"></script>
    {{ $scripts }}

    <script>
        const date = new Date().getFullYear();
        document.getElementById('footerDate').innerHTML = date;

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(function() {
            let Success = document.getElementById('success')
            let Error = document.getElementById('error')

            // if data-success = 'true' display alert
            if (Success.dataset.success == 'true')
                Toast.fire({
                    icon: 'success',
                    title: JSON.parse(Success.dataset.successMessage)
                })

            if (Error.dataset.error == 'true')
                Toast.fire({
                    icon: 'error',
                    title: JSON.parse(Error.dataset.errorMessage)
                })
        });

    </script>
</body>

</html>
