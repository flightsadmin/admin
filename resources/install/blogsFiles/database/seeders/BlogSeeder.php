<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\{Post, User, Route, Flight, Airline, ServiceList, Registration, AirlineDelayCode, Category};

class BlogSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Seed Posts
        $users = User::all();
        foreach ($users as $user) {
            for ($i = 0; $i < 2; $i++) {
                $title = $faker->realText(20);
                $post = Post::create([
                    'user_id' => $user->id,
                    'title' => preg_replace('/[^A-Za-z0-9 ]/', '', $title),
                    'slug' => strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9 ]/', '', $title))),
                    'image' => 'posts/default.png',
                    'body' => $faker->realTextBetween(2000, 5000, 2),
                    'published_at' => $faker->dateTimeBetween('-1 Month', '+1 Month'),
                    'featured' => $faker->boolean(10)
                ]);
                $title = $faker->realText(20);
                $post->categories()->create([
                    'title' => preg_replace('/[^A-Za-z0-9 ]/', '', $title),
                    'slug' => strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9 ]/', '', $title))),
                ]);
            }
        }
    }
}