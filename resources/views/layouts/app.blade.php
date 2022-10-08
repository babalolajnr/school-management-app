<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Radiant Minds School</title>
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
    <link rel="stylesheet" href="{{ asset('TAssets/dist/css/adminlte.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,400;0,700;1,200;1,400;1,700&display=swap"
        rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        * {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed layout-footer-fixed">
    <span id="route" data-route="{{ json_encode(Route::currentRouteName()) }}"></span>
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

        {{-- Notification modal --}}
        <div class="modal fade" id="notification-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body" id="body">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
    @livewireScripts

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
        function showNotification(url, notification) {
            $('#notification-modal #title').html(notification.data.title)
            $('#notification-modal #body').html(notification.data.message)
            $('#notification-modal').modal('show')

            if (notification.read_at == null) {
                // Mark notification as read
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        if (data == 'Success') {
                            $("#" + notification.id).remove()

                            if ($("#notifications-badge-count").text() > 0) {
                                $("#notifications-badge-count").text(parseInt($("#notifications-badge-count")
                                    .text()) - 1)
                            }
                            if ($("#notifications-header-count").text() > 0) {
                                $("#notifications-header-count").text(parseInt($("#notifications-header-count")
                                    .text()) - 1)
                            }
                        }
                    }
                })
            }
        }

        function changeBranchModal(student, branches) {
            const buttons = [];

            // Delete all previously appended branches
            $('#changeBranchModal .modal-body').empty().append("<div class='btn-group'></div>");

            const buttonGroup = $('#changeBranchModal .modal-body .btn-group');
            console.log(student.branch_classroom_id)

            for (const branch of branches) {
                const buttonHTML = `<a href='/students/set-classroom-branch/${student.id}/${branch.id}'>` +
                    "<button type='button' id='' class='btn btn-default btn-flat'" +
                    `title='Change to ${branch.name}'>` +
                    `${branch.name}` +
                    "</button>" +
                    "</a>";

                buttonGroup.append(buttonHTML);
            }

            $('#changeBranchModal').modal('show');
        }

        Livewire.on('success', message => {
            Toast.fire({
                icon: 'success',
                title: message
            })
        })

        Livewire.on('error', message => {
            Toast.fire({
                icon: 'error',
                title: message
            })
        })
    </script>
</body>

</html>
