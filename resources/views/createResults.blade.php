<x-app-layout>
    <x-slot name="styles">

        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Results</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Back</a></li>
                            <li class="breadcrumb-item active">New Result</li>
                        </ol>
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
                                <h3 class="card-title">New Result<span class="text-sm text-muted"> for active period
                                        ({{ $activePeriod->term->name }}
                                        {{ $activePeriod->academicSession->name }})</span></h3>
                            </div>
                            <form method="POST" action="{{ route('result.store', ['student' => $student]) }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Subject">Subject</label>
                                        <select class="form-control select2" name="subject" style="width: 100%;">
                                            @foreach ($subjects as $subject)
                                                @if (!is_null($subject))
                                                    <option @if (old('subject') == $subject) SELECTED @endif>{{ $subject->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('subject')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="C.A">C.A</label>
                                        <input type="number" name="ca"
                                            class="form-control @error('ca') is-invalid @enderror"
                                            value="{{ old('ca') }}">
                                        @error('ca')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="Exam">Exam</label>
                                        <input type="number" name="exam"
                                            class="form-control @error('exam') is-invalid @enderror"
                                            value="{{ old('exam') }}">
                                        @error('exam')
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
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>
    <x-slot name="scripts">

        <!-- Select2 -->
        <script src="{{ asset('TAssets/plugins/select2/js/select2.full.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script>
            $(function() {

                //Initialize Select2 Elements
                $('.select2').select2()
            })
        </script>
    </x-slot>
</x-app-layout>
