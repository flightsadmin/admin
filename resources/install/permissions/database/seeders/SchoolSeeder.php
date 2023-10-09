<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassModel;
use Faker\Factory as Faker;
use App\Models\StudentParent;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Seed Parents
        for ($i = 1; $i <= 5; $i++) {
            StudentParent::create([
                'name' => $faker->name(),
                'email' => $faker->safeEmail(),
                'phone' => '+25472000000'.$i,
            ]);
        }

        // Seed Classes
        for ($i = 1; $i <= 5; $i++) {
            ClassModel::create([
                'name' => "Class $i",
                'description' => "Description for Class $i",
            ]);
        }

        // Seed Students
        for ($i = 1; $i <= 20; $i++) {
            $randomParent = StudentParent::inRandomOrder()->first()->id;
            $randomClass = ClassModel::inRandomOrder()->first()->id;

            Student::create([
                'name' => $faker->name(), //"Student $i",
                'student_parent_id' => $randomParent,
                'class_id' => $randomClass,
                'roll_number' => "S".str_pad($i, 4, '0', STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
        }
    }
}