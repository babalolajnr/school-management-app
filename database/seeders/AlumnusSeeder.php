<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Guardian;
use App\Models\Student;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class AlumnusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classroom = Classroom::orderBy('rank', 'desc')->first();

        if (is_null($classroom)) {
            Artisan::call('db:seed', ['--class' => 'ClassroomSeeder']);
            $classroom = Classroom::max('rank');
        }

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $guardian = Guardian::factory()->create();
            $sex = $faker->randomElement(['M', 'F']);
            $firstName = $sex == 'M' ? $faker->firstNameMale : $faker->firstNameFemale;

            Student::create([
                'first_name' => $firstName,
                'last_name' => $guardian->last_name,
                'sex' => $sex,
                'admission_no' => Str::random(6),
                'lg' => $faker->state,
                'state' => $faker->state,
                'country' => $faker->country,
                'date_of_birth' => $faker->dateTimeThisDecade(),
                'classroom_id' => $classroom->id,
                'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
                'place_of_birth' => $faker->address,
                'guardian_id' => $guardian->id,
                'is_active' => false,
                'graduated_at' => $faker->dateTimeBetween('-3 years'),
            ]);
        }
    }
}
