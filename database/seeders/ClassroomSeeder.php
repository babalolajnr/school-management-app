<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchClassroom;
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
        $teachers = Teacher::all();

        if ($branches->count() < 1) {
            Artisan::call('db:seed', ['--class' => 'BranchSeeder']);
            $branches = Branch::all()->pluck('id');
        }

        if ($teachers->count() < (count($classrooms) * $branches->count())) {
            Teacher::factory()->times((count($classrooms) * $branches->count()) - $teachers->count())->create();
        }

        $teachers = Teacher::all();
        $teacherIndex = 0;

        foreach ($classrooms as $classroom) {
            foreach ($branches as $branch) {
                $teacher = $teachers[$teacherIndex++];
                $row = Classroom::where('name', $classroom['name']);

                if (! $row->exists()) {
                    $classroom = Classroom::create([
                        'name' => $classroom['name'],
                        'rank' => $classroom['rank'],
                        'slug' => Str::of($classroom['name'])->slug('-'),
                    ]);
                } else {
                    $classroom = $row->first();
                }

                $classroom->branches()->where('branch_id', $branch)->exists()
                    ? null : $classroom->branches()->attach($branch, ['teacher_id' => $teacher->id]);

                $teacher->update(['branch_classroom_id' => BranchClassroom::where('teacher_id', $teacher->id)->first()->id]);
            }
        }
    }
}
