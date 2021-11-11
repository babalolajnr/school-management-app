<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class BranchClassroomSeeder extends Seeder
{

    /**
     * Run database seeds
     *
     * @return void
     */
    public function run()
    {
        $branches = Branch::count();
        $classrooms = Classroom::count();

        $branches < 1 ? Artisan::call('db:seed', ['--class' => 'BranchSeeder']) : null;
        $classrooms < 1 ? Artisan::call('db:seed', ['--class' => 'ClassroomSeeder']) : null;

        $branches = Branch::all();
        $classrooms = Classroom::all();

        $classrooms->map(function ($classroom) use ($branches) {
            $classroom->branches()->sync($branches);
            $classroom->touch();
        });

    }
}
