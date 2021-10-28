<x-app-layout>
    <x-slot name="styles">

        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/summernote/summernote-bs4.min.css') }}">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Notifications</h1>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form action="">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        Create Notification
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Title">Title</label>
                                        <input type="text" class="form-control" placeholder="Enter title" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label for="Message">Message</label>
                                        <textarea id="summernote" name="message">
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Notification type">Notification Type</label>
                                        <select class="form-control" name="notification-type">
                                            <option>App Notification</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="To">To:</label>
                                        <select class="form-control" name="to">
                                            <option>Admins</option>
                                            <option>Master Users</option>
                                            <option>Teachers</option>
                                            <option>All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>


    <x-slot name="scripts">

        <!-- DataTables  & Plugins -->
        <script src="{{ asset('TAssets/plugins/datatables/jquery.dataTables.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.html5.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.print.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script>
            $(document).ready(function() {
                $('#summernote').summernote();
            });
        </script>
    </x-slot>
</x-app-layout>
