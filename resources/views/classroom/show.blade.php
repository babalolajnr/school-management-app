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
                        <h1>{{ $classroom->name }}</h1>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <a href="{{ route('classroom.promote.or.demote.students', ['classroom' => $classroom]) }}"><button
                                class="
                            btn btn-sm btn-flat btn-outline-primary">Promote/Demote
                                Students</button></a>
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
                            <div class="card-header row">
                                <span class="col-6 d-flex justify-content-start font-semibold">Students</span>
                                @auth('web')
                                    <span class="col-6 d-flex justify-content-end"><button
                                            class="btn btn-sm btn-flat btn-outline-secondary"
                                            onclick="emailClassPerformanceReportConfirmationModal('{{ route('email.class.performance.report', ['classroom' => $classroom]) }}')">Email
                                            Class Performance
                                            Report</button></span>
                                @endauth
                            </div>
                            <div class="card-body">
                                <x-students-table :students="$students" />
                            </div>
                        </div>
                        @auth('web')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <span class="font-semibold">Branches</span>
                                                <span>
                                                    <button class="btn btn-primary" onclick="showEditBranchesModal()">Edit
                                                        Branches</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="btn-group">
                                                @foreach ($classroom->branches as $branch)
                                                    <a
                                                        href="{{ route('classroom.show.branch', ['classroom' => $classroom, 'branch' => $branch]) }}">
                                                        <button type="button" class="btn btn-default btn-flat">
                                                            {{ $branch->name }}
                                                        </button>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-lg-6">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <span class="font-semibold">Subjects</span>
                                            <span>
                                                <a
                                                    href="{{ route('classroom.set.subjects', ['classroom' => $classroom]) }}"><button
                                                        class="btn btn-primary">Set Subjects</button>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($subjects as $subject)
                                            <div class="callout callout-info">
                                                <span>{{ $subject->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endauth
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

    {{-- Send email confirmation modal --}}
    <div class="modal fade" id="email-class-performance-report-confirmation-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to email entire class performance reports
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="" id="yesSendEmailConfirmation">
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit branches modal --}}
    <div class="modal fade" id="edit-branches-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Branches</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('classroom.update.branches', ['classroom' => $classroom]) }}" method="POST"
                    id="edit-branches-form">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Branches">Branches</label>
                            <div class="form-group">
                                @foreach (App\Models\Branch::all() as $branch)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="branches[]"
                                            id="{{ $branch->name }}" value="{{ $branch->name }}"
                                            @if ($classroom->branches->contains($branch)) checked=""@endif>
                                        <label for="{{ $branch->name }}"
                                            class="custom-control-label">{{ $branch->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
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
            function deleteConfirmationModal(url, data) {
                let name = data.first_name + ' ' + data.last_name

                $('#yesDeleteConfirmation').attr("action", url)
                $('#deleteItemName').html(name)
                $('#deleteConfirmationModal').modal('show')
            }

            function emailClassPerformanceReportConfirmationModal(url) {
                $('#yesSendEmailConfirmation').attr("href", url)
                $('#email-class-performance-report-confirmation-modal').modal('show')
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

            function showEditBranchesModal() {
                $('#edit-branches-modal').modal('show');
            }
        </script>
    </x-slot>
</x-app-layout>
