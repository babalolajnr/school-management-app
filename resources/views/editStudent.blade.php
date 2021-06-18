<x-app-layout>
    <x-slot name="styles">

        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    </x-slot>
    <div class=" content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Student ({{ $student->first_name . ' ' . $student->last_name }})</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Back</a></li>
                        </ol>
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
                                <h3 class="card-title">Edit Student</h3>
                            </div>
                            <form id="updateStudent" method="POST"
                                action="{{ route('student.update', ['student' => $student]) }}">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>First name</label>
                                        <input type="text" name="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name', $student->first_name) }}">
                                        @error('first_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input type="text" name="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name', $student->last_name) }}">
                                        @error('last_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Sex</label>
                                        <select class="custom-select @error('sex') is-invalid @enderror" name="sex">
                                            <option @if (old('sex', $student->sex) == 'M') SELECTED @endif>M</option>
                                            <option @if (old('sex', $student->sex) == 'F') SELECTED @endif>F</option>
                                        </select>
                                        @error('sex')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Admission Number</label>
                                        <input type="text" name="admission_no"
                                            class="form-control @error('admission_no') is-invalid @enderror"
                                            value="{{ old('admission_no', $student->admission_no) }}">
                                        @error('admission_no')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control select2 @error('state') is-invalid @enderror"
                                            name="state" id="state" style="width: 100%;" required>
                                        </select>
                                        @error('state')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Local government</label>
                                        <select class="form-control select2 @error('lg') is-invalid @enderror" name="lg"
                                            id="lg" style="width: 100%;" required>
                                        </select>
                                        @error('lg')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Blood group</label>
                                        <select class="form-control select2" name="blood_group" style="width: 100%;">
                                            <option @if (old('blood_group', $student->blood_group) == 'A+') SELECTED @endif>A+</option>
                                            <option @if (old('blood_group', $student->blood_group) == 'A-') SELECTED @endif>A-</option>
                                            <option @if (old('blood_group', $student->blood_group) == 'B+') SELECTED @endif>B+</option>
                                            <option @if (old('blood_group', $student->blood_group) == 'B-') SELECTED @endif>B-</option>
                                            <option @if (old('blood_group', $student->blood_group) == 'O+') SELECTED @endif>O+</option>
                                            <option @if (old('blood_group', $student->blood_group) == 'O-') SELECTED @endif>O-</option>
                                            <option @if (old('blood_group', $student->blood_group) == 'AB+') SELECTED @endif>AB+</option>
                                            <option @if (old('blood_group', $student->blood_group) == 'AB-') SELECTED @endif>AB-</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of birth</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text"
                                                class="form-control @error('date_of_birth') is-invalid @enderror"
                                                data-inputmask-alias="datetime" name="date_of_birth"
                                                data-inputmask-inputformat="yyyy-mm-dd" data-mask
                                                value="{{ old('date_of_birth', $student->date_of_birth) }}">
                                            @error('date_of_birth')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                        <label>Place of birth</label>
                                        <input type="text" name="place_of_birth"
                                            class="form-control @error('place_of_birth') is-invalid @enderror"
                                            value="{{ old('place_of_birth', $student->place_of_birth) }}">
                                        @error('place_of_birth')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select class="form-control select2" name="classroom" style="width: 100%;">
                                            @foreach ($classrooms as $classroom)
                                                <option @if (old('classroom', $student->classroom->name) == $classroom) SELECTED @endif>{{ $classroom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>
    <x-slot name="scripts">
        <!-- Select2 -->
        <script src="{{ asset('TAssets/plugins/select2/js/select2.full.min.js') }}"></script>
        <!-- InputMask -->
        <script src="{{ asset('TAssets/plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
        <script>
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()
                $('#datemask').inputmask('yyyy-mm-dd', {
                    'placeholder': 'yyyy-mm-dd'
                })
                //Money Euro
                $('[data-mask]').inputmask()

                $.getJSON("{{ asset('js/nigerian-states.json') }}", function(json) {

                    let data = json
                    let states = data[0]
                    let currentState = @json($student->state).toString()
                    let currentLg = @json($student->lg).toString()

                    for (const [state, lgs] of Object.entries(states)) {

                        let stateOption = $(document.createElement('option')).prop({
                            value: state,
                            text: state
                        })

                        $('#state').append(stateOption)

                        if (state == currentState) {
                            stateOption.attr("selected", "selected")
                        }
                    }

                    for (const lg of states[currentState]) {

                        let lgOption = $(document.createElement('option')).prop({
                            value: lg,
                            text: lg
                        })

                        $('#lg').append(lgOption)

                        if (lg == currentLg) {
                            lgOption.attr("selected", "selected")
                        }
                    }

                    $('#state').change(function() {

                        let selectedState = $(this).val();
                        $('#lg').children().remove()

                        for (const lg of states[selectedState]) {
                            $('#lg').append($(document.createElement('option')).prop({
                                value: lg,
                                text: lg
                            }))
                        }

                    });

                });

            })

        </script>
    </x-slot>
</x-app-layout>
