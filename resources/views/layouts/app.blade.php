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

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed layout-footer-fixed">
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
        @auth('web')
            <span id="darkmode-status" data-darkmode-status="{{ auth('web')->user()->darkMode() }}"></span>
        @else
            <span id="darkmode-status" data-darkmode-status="{{ auth('teacher')->user()->darkMode() }}"></span>
        @endauth
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
    <!-- Bootstrap Switch -->
    <script src="{{ asset('TAssets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
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
            timer: 5000
        });


        $(function() {
            toastrAlert()
            darkMode()
        });

        function toastrAlert() {
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
        }

        function darkMode() {
            //get darkmode status
            let darkmodeStatus = $("#darkmode-status").attr('data-darkmode-status')

            if (darkmodeStatus == 'true') {
                darkmodeStatus = true
                $('body').addClass('dark-mode')
            } else {
                darkmodeStatus = false
            }

            //set dark mode button toggle
            $("#dark-mode").bootstrapSwitch({
                size: "mini",
                state: darkmodeStatus,
                onText: '🌆',
                offText: '☀',
                onColor: 'dark'
            })

            //on dark mode switch click
            $("#dark-mode").bootstrapSwitch('onSwitchChange', function(e, state) {
                e.preventDefault();
                $(this).bootstrapSwitch('state', !state, true)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: $("#dark-mode-form").attr('action'),
                    data: {
                        darkmode: state
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            //toggle switch
                            if (response.darkmode == true) {
                                $("#dark-mode").bootstrapSwitch('toggleState', true, true)
                                $('body').addClass('dark-mode')
                            } else {
                                $("#dark-mode").bootstrapSwitch('toggleState', true, false)
                                $('body').removeClass('dark-mode')
                            }
                        }
                    },
                    error: function(data) {
                        Toast.fire({
                            icon: 'error',
                            title: "Unable to toggle dark mode. Try again!"
                        })
                    }

                })
            });
        }
    </script>
</body>

</html>
