<x-app-layout>
    <x-slot name="styles">
    </x-slot>
    <div class="content-wrapper" style="min-height: 286px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                       
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $dashboardData['students'] }}</h3>
                                <p class="font-semibold">Students</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <a href="{{ route('student.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $dashboardData['teachers'] }}</h3>

                                <p class="font-semibold">Teachers</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <a href="{{ route('teacher.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $dashboardData['users'] }}</h3>

                                <p class="font-semibold">Users</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('user.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $dashboardData['classrooms'] }}</h3>

                                <p class="font-semibold">Classrooms</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                            <a href="{{ route('classroom.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>
                                    @if ($dashboardData['period'] !== null)
                                        {{ $dashboardData['period']->academicSession->name }}
                                    @else
                                        Not Set
                                    @endif
                                </h3>
                                <p class="font-semibold">Academic Session</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <a href="{{ route('academic-session.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>
                                    @if ($dashboardData['period'] !== null)
                                        {{ $dashboardData['period']->term->name }}
                                    @else
                                        Not Set
                                    @endif
                                </h3>
                                <p class="font-semibold">Term</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <a href="{{ route('term.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $dashboardData['subjects'] }}</h3>
                                <p class="font-semibold">Subjects</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <a href="{{ route('subject.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $dashboardData['alumni'] }}</h3>

                                <p class="font-semibold">Alumni</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <a href="{{ route('student.get.alumni') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                </div>
                <div class="row">
                    <section class="col-lg-6">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Classrooms Population
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    {{-- classroom population chart --}}
                                    <div class="chart tab-pane active" id="class-population-chart"
                                        style="position: relative; height: 300px;">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="class-population" height="300"
                                            style="height: 300px; display: block; width: 578px;" width="578"
                                            class="chartjs-render-monitor"></canvas>

                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                    </section>
                    <section class="col-lg-6">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    Gender Distribution
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    {{-- gender distribution chart --}}
                                    <div class="chart tab-pane active" id="gender-distribution-chart"
                                        style="position: relative; height: 300px;">
                                        <div class="chartjs-size-monitor">
                                            <div class="chartjs-size-monitor-expand">
                                                <div class=""></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink">
                                                <div class=""></div>
                                            </div>
                                        </div>
                                        <canvas id="gender-distribution" height="300"
                                            style="height: 300px; display: block; width: 578px;" width="578"
                                            class="chartjs-render-monitor"></canvas>

                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                    </section>
                </div>
                <!-- /.row -->
                <!-- Main row -->

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <x-slot name="scripts">
        <!-- ChartJS -->
        <script src="{{ asset('TAssets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
        <script>
            $(function() {
                generateClassroomPopulationChart()
                generateGenderDistributionChart()
            });

            function generateClassroomPopulationChart() {
                const ctx = document.getElementById('class-population').getContext('2d');
                const data = {
                    labels: @json($dashboardData['classroomPopulationChartData']['classroomNames']),
                    datasets: [{
                        label: 'Classroom Population',
                        data: @json($dashboardData['classroomPopulationChartData']['populations']),
                        backgroundColor: @json($dashboardData['classroomPopulationChartData']['colors']),
                        hoverOffset: 4
                    }]
                };
                const classPopulation = new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                });
            }

            function generateGenderDistributionChart() {
                const ctx = document.getElementById('gender-distribution').getContext('2d');
                const data = {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        label: 'Gender Distribution',
                        data: [@json($dashboardData['genderDistributionChartData']['male']), @json($dashboardData['genderDistributionChartData']['female'])],
                        backgroundColor: ['Blue', 'Pink'],
                        hoverOffset: 4
                    }]
                };

                const genderDistribution = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                });
            }
        </script>
    </x-slot>
</x-app-layout>
