<x-app-layout>
    <x-slot name="styles">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Promote or demote students from {{ $classroom->name }}</h1>
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
                    <div class="col-lg-6">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Select Students to Promote</h3>
                            </div>
                            @if (!$students->isEmpty())
                            <button class="btn btn-outline-success btn-flat" id="selectAllPromote">Select all</button>
                                <form method="POST"
                                    action="{{ route('classroom.promote.students', ['classroom' => $classroom]) }}" id="promoteForm">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($students as $student)
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input custom-control-input-success" type="checkbox"
                                                        id="{{ $student->first_name }}-{{ $student->last_name }}-{{ $student->id }}-promote"
                                                        name="students[]" value="{{ $student->id }}">
                                                    <label
                                                        for="{{ $student->first_name }}-{{ $student->last_name }}-{{ $student->id }}-promote"
                                                        class="custom-control-label">
                                                        {{ $student->first_name }}
                                                        {{ $student->last_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            @else
                                <div class="card-body">
                                    <h5 class="text-center">No students available.</h5>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Select Students to Demote</h3>
                            </div>
                            @if (!$students->isEmpty())
                            <button class="btn btn-outline-danger btn-flat" id="selectAllDemote">Select all</button>
                                <form method="POST"
                                    action="{{ route('classroom.demote.students', ['classroom' => $classroom]) }}" id="demoteForm">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($students as $student)
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input custom-control-input-danger" type="checkbox"
                                                        id="{{ $student->first_name }}-{{ $student->last_name }}-{{ $student->id }}-demote"
                                                        name="students[]" value="{{ $student->id }}">
                                                    <label
                                                        for="{{ $student->first_name }}-{{ $student->last_name }}-{{ $student->id }}-demote"
                                                        class="custom-control-label">
                                                        {{ $student->first_name }}
                                                        {{ $student->last_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            @else
                                <div class="card-body">
                                    <h5 class="text-center">No students available.</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>
    <x-slot name="scripts">
        <script>
            $(function() {

                $("#selectAllPromote").on("click", function() {
                    const checkboxes = $("#promoteForm").find(':checkbox')
                    checkboxes.prop('checked', true);
                })

                $("#selectAllDemote").on("click", function() {
                    const checkboxes = $("#demoteForm").find(':checkbox')
                    checkboxes.prop('checked', true);
                })
            })
        </script>
    </x-slot>
</x-app-layout>
