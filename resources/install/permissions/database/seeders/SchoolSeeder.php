<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\Grade;
use Faker\Factory as Faker;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Seed Parents
        for ($i = 1; $i <= 5; $i++) {
            Guardian::create([
                'name' => $faker->name(),
                'email' => $faker->safeEmail(),
                'phone' => '+25472000000'.$i,
            ]);
        }

        // Seed Classes
        for ($i = 1; $i <= 5; $i++) {
            Grade::create([
                'name' => "Class $i",
                'description' => "Description for Class $i",
            ]);
        }

        // Seed Students
        for ($i = 1; $i <= 20; $i++) {
            $randomParent = Guardian::inRandomOrder()->first()->id;
            $randomClass = Grade::inRandomOrder()->first()->id;

            Student::create([
                'name' => $faker->name(), //"Student $i",
                'guardian_id' => $randomParent,
                'class_id' => $randomClass,
                'roll_number' => "S".str_pad($i, 4, '0', STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
        }
    }
}