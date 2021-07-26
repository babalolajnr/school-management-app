<x-app-layout>
    <x-slot name="styles">

        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('TAssets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('TAssets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    </x-slot>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Results {{ $academicSession->name }}</h1>
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
                        @if (!empty($results))

                            @foreach ($results as $key => $termResult)
                                <!-- Default box -->
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="card-title text-bold">{{ $key }}</h2>
                                    </div>
                                    <div class="card-body">
                                        {{-- The table id is gotten by first getting the associative array index then using it to get the numeric index --}}
                                        <table id="{{ str_replace(' ', '-', $key) }}"
                                            class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>C.A.<span class="text-red-500 pl-1">40</span></th>
                                                    <th>Exam<span class="text-red-500 pl-1">60</span></th>
                                                    <th>Total<span class="text-red-500 pl-1">100</span></th>
                                                    <th>Highest Score</th>
                                                    <th>Lowest Score</th>
                                                    <th>Class Average</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($termResult as $itemKey => $item)
                                                    <tr>
                                                        <td>{{ $item->subject->name }}</td>
                                                        <td>{{ $item->ca }}</td>
                                                        <td>{{ $item->exam }}</td>
                                                        <td>{{ $item->total }}</td>
                                                        <td>{{ $maxScores[$item->subject->name . '-' . array_search($termResult, $results)] }}
                                                        <td>{{ $minScores[$item->subject->name . '-' . array_search($termResult, $results)] }}
                                                        </td>
                                                        <td>{{ round($averageScores[$item->subject->name . '-' . array_search($termResult, $results)], 2) }}
                                                        </td>
                                                        <td>
                                                            @if (round($item->total) <= 39)
                                                                F
                                                            @elseif(round($item->total) > 39 &&
                                                                round($item->total)
                                                            <= 49) D @elseif(round($item->total) > 49 &&
                                                                round($item->total) <= 59) C @elseif(round($item->
                                                                        total) > 59 && round($item->total) <= 69) B
                                                                        @elseif(round($item->total) > 69 &&
                                                                        round($item->total) <= 100) A @else
                                                                                @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>C.A.<span class="text-red-500 pl-1">40</span></th>
                                                    <th>Exam<span class="text-red-500 pl-1">60</span></th>
                                                    <th>Total<span class="text-red-500 pl-1">100</span></th>
                                                    <th>Highest Score</th>
                                                    <th>Lowest Score</th>
                                                    <th>Class Average</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            No results for this academic session 😢
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <x-slot name="scripts">

        <!-- DataTables  & Plugins -->
        <script src="{{ asset('TAssets/plugins/datatables/jquery.dataTables.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.html5.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.print.min.js') }}">
        </script>
        <script src="{{ asset('TAssets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}">
        </script>
        <!-- AdminLTE App -->
        <script>
            //datatables
            $(function() {
                // looping through all the tables to assign dynamic numeric id to the datatables initialization
                $('table').each(function() {

                    const tableID = $(this).attr('id')

                    $("#" + tableID).DataTable({
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                        "buttons": ["copy", "csv", "excel", "pdf", "print"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                })
            });
        </script>
    </x-slot>
</x-app-layout>
