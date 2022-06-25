<?php

namespace Database\Seeders;

use App\Models\PD;
use App\Models\PDType;
use App\Models\Period;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->allRecords();

        foreach ($data['students'] as $student) {
            foreach ($data['pdTypes'] as $pdType) {
                foreach ($data['periods'] as $period) {
                    $record = PD::where('p_d_type_id', $pdType->id)
                        ->where('student_id', $student->id)
                        ->where('period_id', $period->id);

                    if ($record->exists()) {
                        continue;
                    }

                    PD::create([
                        'period_id' => $period->id,
                        'student_id' => $student->id,
                        'value' => mt_rand(1, 5),
                        'p_d_type_id' => $pdType->id,
                    ]);
                }
            }
        }
    }

    private function allRecords()
    {
        $period = Period::first();
        $student = Student::first();
        $pdType = PDType::first();

        //if any of the required values are empty seed their tables
        if (! $period) {
            Artisan::call('db:seed', ['--class' => 'PeriodSeeder']);
        }
        if (! $student) {
            Artisan::call('db:seed', ['--class' => 'StudentSeeder']);
        }
        if (! $pdType) {
            Artisan::call('db:seed', ['--class' => 'PDTypeSeeder']);
        }

        $periods = Period::all();
        $students = Student::where('is_active', true)->get();
        $pdTypes = PDType::all();

        return [
            'periods' => $periods,
            'students' => $students,
            'pdTypes' => $pdTypes,
        ];
    }
}
