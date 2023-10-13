<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Guardian;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        foreach (["Math", "English", "Kiswahili", "Chemistry", "Biology"] as $key => $value) {
           Subject::create([
            'name'          => $value,
            'description'   => $faker->realText(100, 2)
           ]);
        }

        // Seed Parents
        for ($i = 1; $i <= 5; $i++) {
            Guardian::create([
                'name' => $faker->name(),
                'email' => $faker->safeEmail(),
                'phone' => '+25472000000'.$i,
            ]);
        }

        // Seed Grades
        for ($i = 1; $i <= 5; $i++) {
            Grade::create([
                'name' => "Class $i",
                'subject_id' => Subject::inRandomOrder()->first()->id,
                'description' => "Description for Class $i",
            ]);
        }

        // Seed Students
        for ($i = 1; $i <= 20; $i++) {
            $randomParent = Guardian::inRandomOrder()->first()->id;
            $randomClass = Grade::inRandomOrder()->first()->id;

            Student::create([
                'name' => $faker->name(),
                'guardian_id' => $randomParent,
                'class_id' => $randomClass,
                'roll_number' => "S".str_pad($i, 5, '0', STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
        }

        // Seed Teachers
        for ($i = 1; $i <= 10; $i++) {
            $randomSubject  = Subject::inRandomOrder()->first()->id;
            $randomClass    = Grade::inRandomOrder()->first()->id;

            Teacher::create([
                'name' => $faker->name(),
                'subject_id' => $randomSubject,
                'class_id' => $randomClass,
                'staff_number' => "T".str_pad($i, 5, '0', STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
        }
    }
}