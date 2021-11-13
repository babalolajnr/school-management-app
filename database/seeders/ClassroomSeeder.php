<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Classroom;
use App\Models\Teacher;
use Database\Factories\ClassroomFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classrooms = ClassroomFactory::$classes;
        $branches = Branch::all()->pluck('id');

        if ($branches->count() < 1) {
            Artisan::call('db:seed', ['--class' => 'BranchSeeder']);
            $branches = Branch::all()->pluck('id');
        }


        foreach ($classrooms as $classroom) {

            $row = Classroom::where('name', $classroom['name']);
            if ($row->exists()) continue;

            Classroom::create(
                [
                    'name' => $classroom['name'],
                    'rank' => $classroom['rank'],
                    'slug' => Str::of($classroom['name'])->slug('-'),
                ]
            )->branches()->attach($branches);
        }
    }
}
