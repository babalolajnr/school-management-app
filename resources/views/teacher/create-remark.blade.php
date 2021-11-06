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
                        <h1>Teacher's Remark</h1>
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
                                <h3 class="card-title">Create/Update Teacher's Remark</span></h3>
                            </div>
                            <form method="POST"
                                action="{{ route('remark.teacher.storeOrUpdate', ['student' => $student]) }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Class Teacher TeacherRemark">Class Teacher's Remark</label>
                                        <textarea class='form-control @error('remark') is-invalid
                                            @enderror' name='remark' rows="4">
                                                @if (!is_null($remark))
                                                    {{ old('remark', $remark->remark) }}
                                                @else 
                                                    {{ old('remark') }}
                                                @endif
                                            </textarea>

                                        @error('remark')
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
