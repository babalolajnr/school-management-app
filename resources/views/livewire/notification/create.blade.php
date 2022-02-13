<div>
    <x-slot name="styles">
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/summernote/summernote-bs4.min.css') }}">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Notifications</h1>
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
                        <form action="#" method="POST" wire:submit.prevent="submit">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        Create Notification
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="Title">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Enter title" wire:model="title">
                                        @error('title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="Message">Content</label>
                                        <div wire:ignore>
                                            <textarea id="summernote">
                                                {{ $content }}
                                            </textarea>
                                        </div>
                                        @error('content')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="Notification type">Notification Type</label>
                                        <select class="form-control @error('notificationType') is-invalid @enderror"
                                            name="notificationType" wire:model="notificationType">
                                            <option></option>
                                            <option>App Notification</option>
                                        </select>
                                        @error('notificationType')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="To">To:</label>
                                        <select class="form-control @error('to') is-invalid @enderror" name="to"
                                            wire:model="to">
                                            <option></option>
                                            <option>Admins</option>
                                            <option>Master Users</option>
                                            <option>Teachers</option>
                                            <option>All</option>
                                        </select>
                                        @error('to')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary">
                                        <span wire:loading.remove wire:target="submit">Submit</span>
                                        <div class="spinner-border spinner-border text-muted" wire:loading
                                            wire:target="submit">
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>


    <x-slot name="scripts">

        <script src="{{ asset('TAssets/plugins/summernote/summernote-bs4.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    // This is just to ensure the summernote textarea content is updated
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.set('content', contents)
                        }
                    }
                });
            });

            Livewire.on('success', _ => {
                $('#summernote').summernote('reset');
            })
        </script>
    </x-slot>
</div>
