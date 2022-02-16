<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <x-slot name="styles">

        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Academic Sessions</h1>
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
                                <h3 class="card-title">New Academic Session</h3>
                            </div>
                            <form id="addAcademicSession" method="POST" action="#" wire:submit.prevent="submit">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Academic Session">Academic Session</label>
                                        <input type="text" wire:model="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="academicSession" placeholder="Enter Academic Session">
                                        <small class="text-muted">e.g 2009-2010 </small>
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" wire:model="startDate"
                                            class="form-control @error('startDate') is-invalid @enderror" id="startDate"
                                            placeholder="">
                                        <small class="text-muted">format: YYYY-MM-DD </small>
                                        @error('startDate')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" wire:model="endDate"
                                            class="form-control @error('endDate') is-invalid @enderror" id="endDate"
                                            placeholder="">
                                        <small class="text-muted">format: YYYY-MM-DD </small>
                                        @error('endDate')
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
                                <h3 class="card-title">Academic Sessions</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($academicSessions as $academicSession)
                                            <tr>
                                                <td>
                                                    {{ $academicSession->name }}
                                                </td>
                                                <td>
                                                    {{ $academicSession->start_date }}
                                                </td>
                                                <td>
                                                    {{ $academicSession->end_date }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a
                                                            href="{{ route('academic-session.edit', ['academicSession' => $academicSession]) }}">
                                                            <button type="button" class="btn btn-default btn-flat"
                                                                title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-flat"
                                                            title="Delete"
                                                            onclick="deleteConfirmationModal('{{ $academicSession->name }}')">
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
                                            <th>Start Date</th>
                                            <th>End Date</th>
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
                    <div>
                        <span data-delete-item='' id="deleteItem"></span>
                        <button type="button" class="btn btn-danger" id="confirmDelete">
                            <span wire:loading.remove wire:target="delete">
                                Yes
                            </span>
                            <div class="spinner-border spinner-border text-muted" wire:loading wire:target="delete">
                            </div>
                        </button>
                    </div>
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
        <script src="{{ asset('TAssets/plugins/moment/moment.min.js') }}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ asset('TAssets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
        </script>

        <!-- AdminLTE App -->
        <script>
            function deleteConfirmationModal(name) {

                $('#deleteItemName').html(name)
                $('#deleteConfirmationModal').modal('show')

                // Set data-attribute of delete item
                document.getElementById('deleteItem').dataset.deleteItem = name
            }

            $('#confirmDelete').click(() => {
                // Set deleteItem property on the component
                @this.set('deleteItem', document.getElementById('deleteItem').dataset.deleteItem)
                Livewire.emit('delete')
            })

            Livewire.on('success', _ => {
                $('#deleteConfirmationModal').modal('hide')
            })

            Livewire.on('error', _ => {
                $('#deleteConfirmationModal').modal('hide')
            })

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
</div>
