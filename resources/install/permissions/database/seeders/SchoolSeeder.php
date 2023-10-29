<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\{User, Board, Grade, Student, Subject, Teacher, Guardian};

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        foreach (["Math", "English", "Kiswahili", "Chemistry", "Biology"] as $value) {
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
                'body'  => $faker->realText(1500),
                'user_id'=> User::inRandomOrder()->first()->id,
            ]);

            // Seed Teachers
            $teacher = Teacher::create([
                'name' => $faker->name(),
                'email'=> $faker->email(),
                'phone' => '+25472000000'.$i,
                'staff_number' => setting('site_short_code').'/'.date('Y').'/'. str_pad(Teacher::max('id') + 1, 5, 0, STR_PAD_LEFT),
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
                'roll_number' => setting('site_short_code').'/'.date('Y').'/'. str_pad(Student::max('id') + 1, 5, 0, STR_PAD_LEFT),
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
        }
    }
}