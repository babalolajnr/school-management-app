<x-app-layout>
    <x-slot name="styles">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pyschomotor Domain Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            
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
                        {{-- Teacher --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $student->first_name . ' ' . $student->last_name }}</h3>
                            </div>
                            {{-- PD --}}

                            <form action="@if (!$period->isActive()) {{ route('pd.storeOrUpdate', ['student' => $student, 'periodSlug' => $period->slug]) }}
                            @else {{ route('pd.storeOrUpdate', ['student' => $student]) }} @endif"
                                method="POST">
                                @csrf
                                <div class="card-body">
                                    <!-- radio -->
                                    @if (!is_null($pdTypesValues))
                                        {{-- if the fields already have values they should be automaically filled --}}
                                        @foreach ($pdTypes as $pdType)
                                            <div class="form-group">
                                                <label for="customRange1">{{ $pdType->name }}<span
                                                        class="font-light pl-4">range(1-5)</span></label>
                                                <input type="range" class="custom-range" min="1" max="5"
                                                    name="pdTypes[{{ $pdType->slug }}]" id="{{ $pdType->slug }}" @if (array_key_exists($pdType->id, $pdTypesValues)) value="{{ $pdTypesValues[$pdType->id] }}" @endif>
                                            </div>
                                        @endforeach
                                    @else
                                        {{-- if the fields have not been previously filled --}}
                                        @foreach ($pdTypes as $pdType)
                                            <div class="form-group">
                                                <label for="customRange1">{{ $pdType->name }}<span
                                                        class="font-light pl-4">range(1-5)</span></label>
                                                <input type="range" class="custom-range" min="1" max="5"
                                                    name="pdTypes[{{ $pdType->slug }}]" id="{{ $pdType->slug }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                            {{-- /PD --}}
                        </div>

                    </div>
                </div>
        </section>
        <!-- /.content -->

    </div>

    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
