<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\{Schedule, User};

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Seed Schedule
        $start_date = Carbon::now('Asia/Qatar');
        $end_date = $start_date->copy()->addDays(30);
        $users = User::all();
        while ($start_date <= $end_date) {
            foreach ($users as $key => $value) {
                $roster = new Schedule;
                $roster->date = $start_date->copy()->format('Y-m-d');
                $roster->user_id = $value->id;
                $roster->shift_start = $start_date->copy()->toDateTimeString();
                $roster->shift_hours = rand(8, 12);
                $roster->shift_end = Carbon::parse($roster->shift_start)->copy()->addHours($roster->shift_hours)->toDateTimeString();
                $roster->save();
            }
            $start_date->addDay();
        }
    }
}