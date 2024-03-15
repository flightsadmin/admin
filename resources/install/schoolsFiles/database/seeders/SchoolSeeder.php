<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\{User, Board, Grade, Student, Subject, Teacher, Guardian, Timetable};

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $roles = [
            [
                'name' => 'principal',
                'permissions' => Permission::pluck('name')->toArray(),
            ],
            [
                'name' => 'teacher',
                'permissions' => [],
            ],
            [
                'name' => 'parent',
                'permissions' => [],
            ],
            [
                'name' => 'student',
                'permissions' => [],
            ],
        ];

        foreach ($roles as $key => $roleData) {
            $role = Role::create(['name' => $roleData['name']]);
            $role->givePermissionTo($roleData['permissions']);
            User::create([
                'name' => ucwords(explode('-', $roleData['name'])[0]) . ' User',
                'email' => $roleData['name'] . '@flightadmin.info',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(30),
                'phone' => '+2547000000' . $key,
                'title' => ucwords($roleData['name']),
                'photo' => 'users/noimage.jpg',
            ])->assignRole($role);
        }

        // Seed Subjects
        $subjects = ["Math", "English", "Kiswahili", "Chemistry", "Biology"];
        foreach ($subjects as $value) {
            Subject::create([
                'name' => $value,
                'description' => $faker->realText(50, 2)
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            // Seed Grades
            Grade::create([
                'name' => "Class $i",
                'description' => "Description for Class $i",
            ]);

            // Seed Boards
            Board::create([
                'title' => $faker->realText(20),
                'body' => $faker->realText(1500),
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        }
        // Seed Parents
        $guardians = User::where('title', 'Parent')->count();
        for ($i = 1; $i <= $guardians; $i++) {
            $teacher = Guardian::create([
                'user_id' => User::where('title', 'Parent')->inRandomOrder()->first()->id,
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'address' => $faker->address(),
            ]);
        }

        // Seed Teachers
        $teachers = User::where('title', 'Teacher')->count();
        for ($i = 1; $i <= $teachers; $i++) {
            $teacher = Teacher::create([
                'user_id' => User::where('title', 'Teacher')->inRandomOrder()->first()->id,
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
            $teacher->classes()->attach($i);
            $teacher->subjects()->attach($i);
        }

        // Seed Students
        $students = User::where('title', 'Student')->count();
        for ($i = 1; $i <= $students; $i++) {
            Student::create([
                'user_id' => User::where('title', 'Student')->inRandomOrder()->first()->id,
                'guardian_id' => Guardian::inRandomOrder()->first()->id,
                'grade_id' => Grade::inRandomOrder()->first()->id,
                'gender' => ($i % 2 == 0) ? 'female' : 'male',
                'date_of_birth' => "2000-01-0$i",
                'address' => $faker->address(),
            ]);
        }

        foreach ($subjects as $value) {
            for ($i = 1; $i <= now()->endOfMonth()->format('d'); $i++) {
                Timetable::create([
                    'name' => $value,
                    'start_time' => now()->startOfMonth()->addDays($i),
                    'end_time' => now()->startOfMonth()->addDays($i)->addMinutes(40),
                    'grade_id' => Grade::inRandomOrder()->first()->id,
                ]);
            }
        }
    }
}