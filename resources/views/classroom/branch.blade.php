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
                        <h1>{{ $branchClassroom->classroom->name }} ({{ $branchClassroom->branch->name }})</h1>
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
                                            onclick="emailClassPerformanceReportConfirmationModal('{{ route('email.class.performace.report', ['classroom' => $classroom]) }}')">Email
                                            Class Performance
                                            Report</button></span>
                                @endauth
                            </div>
                            <div class="card-body">
                                <x-students-table :students="$branchClassroom->activeStudents()" />
                            </div>
                        </div>
                        @auth('web')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <span class="font-semibold">Class Teachers</span>
                                                <span>
                                                    <button class="btn btn-primary"
                                                        onclick="showAssignTeachersModal()">Assign Teachers</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($branchClassroom->teachers as $teacher)
                                                <div class="row pb-2">
                                                    <div class="col">
                                                        <a href="{{ route('teacher.show', ['teacher' => $teacher]) }}">
                                                            {{ "$teacher->first_name $teacher->last_name" }}
                                                        </a>
                                                        <a
                                                            href="{{ route('branch.assign.main.teacher', ['branchClassroom' => $branchClassroom, 'teacher' => $teacher]) }}">
                                                            @if ($teacher->id == $branchClassroom->mainTeacher()?->id)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
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
    <div class="modal fade" id="emailClassPerformanceReportConfirmationModal">
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

    {{-- Assign Teachers modal --}}
    <div class="modal fade" id="assignTeachersModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Teachers</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('branch.assign.teachers', ['branchClassroom' => $branchClassroom]) }}"
                    method="POST" id="assign-teachers-form">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Teacher">Teacher</label>
                            <div class="form-group">
                                @foreach (App\Models\Teacher::all() as $teacher)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="teachers[]"
                                            id="{{ $teacher->slug }}" @if ($branchClassroom->teachers->contains($teacher)) checked="" @endif
                                            value="{{ $teacher->slug }}">
                                        <label for="{{ $teacher->slug }}"
                                            class="custom-control-label">{{ "$teacher->first_name $teacher->last_name" }}</label>
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
                $('#emailClassPerformanceReportConfirmationModal').modal('show')
            }

            function showAssignTeachersModal() {
                $('#assignTeachersModal').modal('show')
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
