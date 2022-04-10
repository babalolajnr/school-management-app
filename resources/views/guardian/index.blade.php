<x-app-layout>
    <x-slot name="styles">

        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Guardians</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="flex flex-row-reverse">
                            <a href="{{ route('guardian.create') }}">
                                <button class="btn btn-success">Add Guardian</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">Guardians</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div>
                                    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Title</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Children</th>
                                                <th>Email</th>
                                                <th>Phone number</th>
                                                <th>Occupation</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @foreach ($guardians as $guardian)
                                                <tr>
                                                    <td>
                                                        <?php
                                                        echo $no;
                                                        $no++;
                                                        ?>
                                                    </td>
                                                    <td>{{ $guardian->title }}</td>
                                                    <td>
                                                        {{ $guardian->first_name }}
                                                    </td>
                                                    <td>
                                                        {{ $guardian->last_name }}
                                                    </td>
                                                    <td>
                                                        {{ $guardian->children()->count() }}
                                                    </td>
                                                    <td>
                                                        {{ $guardian->email }}
                                                    </td>
                                                    <td>
                                                        {{ $guardian->phone }}
                                                    </td>
                                                    <td>
                                                        {{ $guardian->occupation }}
                                                    </td>
                                                    <td>
                                                        {{ $guardian->address }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a
                                                                href="{{ route('guardian.show', ['guardian' => $guardian]) }}">
                                                                <button type="button" id=""
                                                                    class="btn btn-default btn-flat"
                                                                    title="Guardian detailed view">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </a>
                                                            <button type="submit" class="btn btn-default btn-flat"
                                                                title="Delete"
                                                                onclick="deleteConfirmationModal('{{ route('guardian.destroy', ['guardian' => $guardian]) }}', {{ $guardian }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Title</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Children</th>
                                                <th>Email</th>
                                                <th>Phone number</th>
                                                <th>Occupation</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->

        {{-- Delete confirmation modal --}}
        <div class="modal fade" id="deleteConfirmationModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete <span id="deleteItemName" class="font-bold"></span>?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <form action="" method="POST" id="yesDeleteConfirmation">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Yes</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

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
        <!-- AdminLTE App -->
        <script>
            function deleteConfirmationModal(url, data) {
                let name = data.first_name + ' ' + data.last_name

                $('#yesDeleteConfirmation').attr("action", url)
                $('#deleteItemName').html(name)
                $('#deleteConfirmationModal').modal('show')
            }

            //datatables
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });
        </script>
    </x-slot>
</x-app-layout>
