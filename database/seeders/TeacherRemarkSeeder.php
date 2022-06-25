<?php

namespace Database\Seeders;

use App\Models\Period;
use App\Models\Student;
use App\Models\TeacherRemark;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class TeacherRemarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->allRecords();
        $faker = Factory::create();

        foreach ($data['students'] as $student) {
            foreach ($data['periods'] as $period) {
                $record = TeacherRemark::where('student_id', $student->id)
                    ->where('period_id', $period->id);

                if ($record->exists()) {
                    continue;
                }

                TeacherRemark::create([
                    'student_id' => $student->id,
                    'period_id' => $period->id,
                    'teacher_id' => $student->branchClassroom->mainTeacher()->id,
                    'remark' => $faker->realText(),
                ]);
            }
        }
    }

    private function allRecords()
    {
        $period = Period::first();
        $student = Student::first();

        //if any of the required values are empty seed their tables
        if (! $period) {
            Artisan::call('db:seed', ['--class' => 'PeriodSeeder']);
        }
        if (! $student) {
            Artisan::call('db:seed', ['--class' => 'StudentSeeder']);
        }

        $periods = Period::all();
        $students = Student::all();

        return [
            'periods' => $periods,
            'students' => $students,
        ];
    }
}
