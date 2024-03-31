<?php

namespace Database\Seeders;

use App\Models\StaffOffDay;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\{Roster, User, Employee, Leave};
use Illuminate\Database\Seeder;

class RosterSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        // Create Employees
        for ($i=1; $i <= 10; $i++) { 
            Employee::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
            ]);
        }

        // Seed Roster
        $start_date = Carbon::now('Asia/Qatar');
        $end_date = $start_date->copy()->addDays(30);
        $employees = Employee::all();
        while ($start_date <= $end_date) {
            foreach ($employees as $key => $value) {
                $roster = new Roster;
                $roster->date = $start_date->copy()->format('Y-m-d');
                $roster->employee_id = $value->id;
                $roster->shift_start = $start_date->copy()->startOfHour()->toDateTimeString();
                $roster->shift_hours = rand(8, 12);
                $roster->shift_end = Carbon::parse($roster->shift_start)->copy()->addHours($roster->shift_hours)->toDateTimeString();
                $roster->save();
            }
            $start_date->addDay();
        }

        // Create Leaves
        for ($i=1; $i <= 5; $i++) { 
            Leave::create([
                'leave_start' => now()->startOfDay(),
                'leave_end' => now()->addDays(rand(6, 20))->endOfDay(),
                'employee_id' => \App\Models\Employee::inRandomOrder()->first()->id,
            ]);
        }

       // Create Off Duties
        for ($i=1; $i <= 5; $i++) { 
            StaffOffDay::create([
                'off_day' => 'Monday',
                'employee_id' => \App\Models\Employee::inRandomOrder()->first()->id,
            ]);
        }
    }
}