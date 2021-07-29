<x-app-layout>
    <x-slot name="styles">
    </x-slot>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Classrooms</h1>
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
                                <h3 class="card-title">Edit Classroom <span class="font-semibold">{{ $classroom->name }}</span></h3>
                            </div>
                            <form id="editClassroom" method="POST" action="{{ route('classroom.update', ['classroom' => $classroom]) }}">
                                @csrf
                                @method('PATCH')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Classroom">Classroom</label>
                                        <input type="text" name="name" value="{{ old('name', $classroom->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            id="classroom" placeholder="Enter Classroom">
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="rank">Rank</label>
                                        <input type="number" name="rank" value="{{ old('rank', $classroom->rank) }}"
                                            class="form-control @error('rank') is-invalid @enderror"
                                            id="rank" placeholder="Enter Rank">
                                        @error('rank')
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
    <x-slot name="scripts"></script>
</x-app-layout>
