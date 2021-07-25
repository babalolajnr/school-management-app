<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use App\Models\Classroom;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Period;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->allRecords();

        $periods = collect($data['periods']);
        $academicSessions = $periods->groupBy(function ($item) {
            return $item->academic_session_id;
        });
        $classroomPeriods = [];
        $classroom_id = 1;
        foreach ($academicSessions as $academicSession) {
            foreach ($academicSession as $period) {
                $classroomPeriod = ['period_id' => $period->id, 'classroom_id' => $classroom_id];
                array_push($classroomPeriods, $classroomPeriod);
            }
            $classroom_id++;
        }

        $classroomPeriods = collect($classroomPeriods);

        $data['students']->map(function ($student) use ($data, $classroomPeriods) {

            $data['subjects']->map(function ($subject) use ($student, $classroomPeriods) {

                $classroomPeriods->map(function ($classroomPeriod) use ($student, $subject) {

                    $record = Result::where('subject_id', $subject->id)
                        ->where('student_id', $student->id)
                        ->where('period_id', $classroomPeriod['period_id']);

                    if (!$record->exists()) {
                        $ca = mt_rand(0, 40);
                        $exam = mt_rand(0, 60);
                        Result::create([
                            'period_id' => $classroomPeriod['period_id'],
                            'subject_id' => $subject->id,
                            'student_id' => $student->id,
                            'ca' => $ca,
                            'exam' => $exam,
                            'total' => $exam + $ca,
                            'classroom_id' => $classroomPeriod['classroom_id']
                        ]);
                    }
                });
            });
        });
    }

    /**
     * Query Periods, Students and subjects data
     *
     * @return array
     */
    private function allRecords()
    {
        $period = Period::first();
        $student = Student::first();
        $subject = Subject::first();
        $classroom = Classroom::first();
        $academicSession = AcademicSession::first();
        $classroomSubject = DB::table('classroom_subject')->first();

        //if any of the required values are empty seed their tables
        if (is_null($classroomSubject)) Artisan::call('db:seed', ['--class' => 'ClassroomSubjectSeeder']);
        if (is_null($student)) Artisan::call('db:seed', ['--class' => 'StudentSeeder']);
        if (is_null($period)) Artisan::call('db:seed', ['--class' => 'PeriodSeeder']);
        if (is_null($subject)) Artisan::call('db:seed', ['--class' => 'SubjectSeeder']);
        if (is_null($classroom)) Artisan::call('db:seed', ['--class' => 'ClassroomSeeder']);
        if (is_null($academicSession)) Artisan::call('db:seed', ['--class' => 'AcademicSessionSeeder']);


        $classrooms = Classroom::all();
        $students = Student::where('is_active', true)->get();
        $subjects = Subject::all();
        $academicSessions = AcademicSession::all();
        $periods = Period::all();

        return [
            'students' => $students,
            'subjects' => $subjects,
            'classrooms' => $classrooms,
            'academicSessions' => $academicSessions,
            'periods' => $periods
        ];
    }
}
