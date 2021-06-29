<x-app-layout>
    <x-slot name="styles">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Set Subjects for {{ $classroom->name }}</h1>
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
                    <div class="col-lg-6">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Select Subjects</h3>
                            </div>
                            @if (!$relations->isEmpty())
                                <form method="POST"
                                    action="{{ route('classroom.update.subjects', ['classroom' => $classroom]) }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach ($relations as $subject => $relation)
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                        id="{{ $subject }}" name="subjects[]" value="{{ $subject }}" @if ($relation) checked @endif>
                                                    <label for="{{ $subject }}" class="custom-control-label">
                                                        {{ $subject }}</label>
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
                                    <h5 class="text-center">No subjects available.</h5>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
        </section>
        <!-- /.content -->
    </div>
    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
