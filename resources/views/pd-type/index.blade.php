<x-app-layout>
    <x-slot name="styles">

        <!-- DataTables -->
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
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
                        <h1>Psychomotor domains</h1>
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
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">New Psychomotor Domain</h3>
                            </div>
                            <form id="addPDType" method="POST" action="{{ route('pd-type.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="PDType">Psychomotor Domain</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" id="pdType"
                                            placeholder="Enter Psychomotor Domain">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pyschomotor Domains</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pdTypes as $pdType)
                                        <tr>

                                            <td>
                                                {{ $pdType->name }}
                                            </td>
                                            <td>
                                                <div class="btn-group">

                                                    <a href="{{ route('pd-type.edit', ['pdType' => $pdType]) }}">
                                                        <button type="button" class="btn btn-default btn-flat"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>

                                                    <button type="button" class="btn btn-danger btn-flat" title="Delete"
                                                        onclick="deleteConfirmationModal('{{ route('pd-type.destroy', ['pdType' => $pdType]) }}', '{{ $pdType->name }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>
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
            function deleteConfirmationModal(url, name) {

                $('#yesDeleteConfirmation').attr("action", url)
                $('#deleteItemName').html(name)
                $('#deleteConfirmationModal').modal('show')
            }

            $(function () {
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
