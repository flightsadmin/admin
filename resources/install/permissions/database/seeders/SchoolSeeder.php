<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Board;
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
            'description'   => $faker->realText(50, 2)
           ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            // Seed Parents
            Guardian::create([
                'name' => $faker->name(),
                'email' => $faker->safeEmail(),
                'phone' => '+25472000000'.$i,
            ]);

            // Seed Grades
            Grade::create([
                'name' => "Class $i",
                'description' => "Description for Class $i",
            ]);

            // Seed Boards
            Board::create([
                'title' => $faker->realText(20),
                'body'  => $faker->realText(1000),
                'user_id'=> User::inRandomOrder()->first()->id,
            ]);

            // Seed Teachers
            $teacher = Teacher::create([
                'name' => $faker->name(),
                'staff_number' => "T".str_pad($i, 5, '0', STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
            $teacher->classes()->attach($i);
            $teacher->subjects()->attach($i);
        }

        // Seed Students
        for ($i = 1; $i <= 20; $i++) {
            Student::create([
                'name' => $faker->name(),
                'guardian_id' => Guardian::inRandomOrder()->first()->id,
                'grade_id' => Grade::inRandomOrder()->first()->id,
                'roll_number' => "S".str_pad($i, 5, '0', STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
        }
    }
}