<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Period;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Faker\Provider\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache as FacadesCache;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $dashboardData = FacadesCache::remember('dashboardData', 60, function () {
            $students = Student::activeStudents();
            $studentsNo = count($students);
            $alumni = Student::whereNotNull('graduated_at')->count();
            $teachers = Teacher::count();
            $users = User::count();
            $classrooms = Classroom::count();
            $period = Period::activePeriod();
            $subjects = Subject::count();
            $classroomPopulationChartData = $this->generateClassroomsPopulationChart();
            $genderDistributionChartData = $this->generateGenderDistributionChart($students);

            $dashboardData = [
                'students' => $studentsNo,
                'alumni' => $alumni,
                'teachers' => $teachers,
                'users' => $users,
                'classrooms' => $classrooms,
                'period' => $period,
                'subjects' => $subjects,
                'classroomPopulationChartData' => $classroomPopulationChartData,
                'genderDistributionChartData' => $genderDistributionChartData,
            ];

            return $dashboardData;
        });

        return view(
            'dashboard',
            compact(
                'dashboardData',
            )
        );
    }

    /** Generates data for the classrooms population chart
     * @return array
     */
    private function generateClassroomsPopulationChart()
    {
        $classrooms = Classroom::with('students')->get();
        $classroomNames = [];
        $populations = [];
        $colors = [];

        foreach ($classrooms as $classroom) {
            array_push($classroomNames, $classroom->name);

            //get students that have not graduated for each class and count them
            array_push($populations, $classroom->countActiveStudents());

            //push random colors into array
            array_push($colors, Color::hexcolor());
        }

        return [
            'classroomNames' => $classroomNames,
            'populations' => $populations,
            'colors' => $colors,
        ];
    }

    /**
     * Generates gender distribution chart data
     *
     * @param  mixed  $students
     * @return array
     */
    private function generateGenderDistributionChart($students)
    {
        $male = $students->filter(function ($student) {
            return $student->sex == 'M';
        });

        $female = $students->filter(function ($student) {
            return $student->sex == 'F';
        });

        return [
            'male' => count($male),
            'female' => count($female),
        ];
    }
}
