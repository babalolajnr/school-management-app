<x-app-layout>
    <x-slot name="styles">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         
        <span id="error" {{ session('error') ? 'data-error = true' : false }}
            data-error-message='{{ json_encode(session('error')) }}'></span>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Affective Domain Form</h1>
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
                            {{-- AD --}}

                            <form action="@if (!$period->isActive()) {{ route('ad.storeOrUpdate', ['student' => $student, 'periodSlug' => $period->slug]) }}
                            @else
                                {{ route('ad.storeOrUpdate', ['student' => $student]) }} @endif" method="POST">
                                @csrf
                                <div class="card-body">
                                    <!-- radio -->
                                    @if (!is_null($adTypesValues))
                                        @foreach ($adTypes as $adType)
                                            <div class="form-group">
                                                <label for="customRange1">{{ $adType->name }}<span
                                                        class="font-light pl-4">range(1-5)</span></label>
                                                <input type="range" class="custom-range" min="1" max="5"
                                                    name="adTypes[{{ $adType->slug }}]" id="{{ $adType->slug }}"
                                                    @if (array_key_exists($adType->id, $adTypesValues)) value="{{ $adTypesValues[$adType->id] }}" @endif>
                                            </div>
                                        @endforeach
                                    @else
                                        @foreach ($adTypes as $adType)
                                            <div class="form-group">
                                                <label for="customRange1">{{ $adType->name }}<span
                                                        class="font-light pl-4">range(1-5)</span></label>
                                                <input type="range" class="custom-range" min="1" max="5"
                                                    name="adTypes[{{ $adType->slug }}]" id="{{ $adType->slug }}">
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
                            {{-- /AD --}}
                        </div>

                    </div>
                </div>
        </section>
        <!-- /.content -->

    </div>

    <x-slot name="scripts">
    </x-slot>
</x-app-layout>
