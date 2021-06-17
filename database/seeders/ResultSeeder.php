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
        $this->command->getOutput()->progressStart(10);

        $data = $this->allRecords();


        $data['classrooms']->map(function ($classroom, $key) use ($data) {

            $academicSessionIndex = 0;

            $academicSession = $data['academicSessions'][$academicSessionIndex];

            if (count($data['academicSessions']) < $academicSessionIndex) {
                $academicSessionIndex++;
            }

            foreach ($data['students'] as $student) {

                $periods = Period::where('academic_session_id', $academicSession->id)->get();

                $periods->map(function ($period) use ($data, $student, $classroom) {

                    foreach ($data['subjects'] as $subject) {

                        $record = Result::where('subject_id', $subject->id)
                            ->where('student_id', $student->id)
                            ->where('period_id', $period->id);

                        if ($record->exists()) {
                            continue;
                        }

                        $ca = mt_rand(0, 40);
                        $exam = mt_rand(0, 60);
                        Result::create([
                            'period_id' => $period->id,
                            'subject_id' => $subject->id,
                            'student_id' => $student->id,
                            'ca' => $ca,
                            'exam' => $exam,
                            'total' => $exam + $ca,
                            'classroom_id' => $classroom->id
                        ]);
                    }
                });
            }
            $this->command->getOutput()->progressAdvance();
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
        $students = Student::all();
        $subjects = Subject::all();
        $academicSessions = AcademicSession::all();

        return [
            'students' => $students,
            'subjects' => $subjects,
            'classrooms' => $classrooms,
            'academicSessions' => $academicSessions
        ];
    }
}
