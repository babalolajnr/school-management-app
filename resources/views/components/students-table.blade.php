<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Admission No</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Sex</th>
                <th>Guardian</th>
                <th>Status</th>
                @if (Route::currentRouteName() == 'student.get.alumni')
                    <th>
                        Graduation date
                    </th>
                @endif
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach ($students as $student)
                <tr>
                    <td>
                        <?php
                        echo $no;
                        $no++;
                        ?>
                    </td>
                    <td>{{ $student->admission_no }}</td>
                    <td>
                        {{ $student->first_name }}
                    </td>
                    <td>
                        {{ $student->last_name }}
                    </td>
                    <td>
                        {{ $student->sex }}
                    </td>
                    <td>
                        {{ $student->guardian->title . ' ' . $student->guardian->first_name . ' ' . $student->guardian->last_name }}
                    </td>
                    <td>
                        @if ($student->isActive())
                            active
                        @else
                            inactive
                        @endif
                    </td>
                    @if (Route::currentRouteName() == 'student.get.alumni')
                        <th>
                            {{ $student->graduated_at }}
                        </th>
                    @endif
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('student.show', ['student' => $student]) }}">
                                <button type="button" id="" class="btn btn-default btn-flat"
                                    title="Student detailed view">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </a>

                            @auth('web')
                                {{-- render if user is authorized to delete --}}
                                @can('delete', $student)
                                    <button type="submit" class="btn btn-default btn-flat" title="Delete"
                                        onclick="deleteConfirmationModal('{{ route('student.destroy', ['student' => $student]) }}', {{ $student }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endcan

                                @can('changeBranch', $student)
                                    <button type="submit" class="btn btn-default btn-flat" title="Change Branch"
                                        onclick="changeBranchModal({{ $student }}, {{ $student->classroom->branches }})">
                                        <i class="fas fa-code-branch"></i>
                                    </button>
                                @endcan

                                {{-- render if user is not authorized to delete --}}
                                @cannot('delete', $student)
                                    <button type="submit" class="btn btn-default btn-flat" title="Delete" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endcannot
                            @endauth

                            @if (auth('web')->user() || auth('teacher')->user())
                                <a href="{{ route('student.show.student.settingsView', ['student' => $student]) }}">
                                    <button type="button" class="btn btn-default btn-flat">
                                        <i class="fas fa-cogs"></i>
                                    </button>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>S/N</th>
                <th>Admission No</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Sex</th>
                <th>Guardian</th>
                <th>Status</th>
                @if (Route::currentRouteName() == 'student.get.alumni')
                    <th>
                        Graduation date
                    </th>
                @endif
                <th>Action</th>
            </tr>
        </tfoot>
    </table>

    {{-- Change branch modal --}}
    <div class="modal fade" id="changeBranchModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select Branch</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Branches go here --}}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
