<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $categories = ["Clothes", "Electronis", "Appliances", "Bags"];

        foreach ($categories as $key => $value) {
            Category::create([
                'title' => $value,
                'slug'  => strtolower($value),
            ]);
        }
        for ($i = 1; $i <= 10; $i++) {
            $name = $faker->realText(20);
            $product = Product::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'name' => preg_replace('/[^A-Za-z0-9 ]/', '', $name),
                'price' => random_int(40, 100),
                'image' => 'products/default.png',
                'description' => $faker->realTextBetween(100, 200, 2),
                'published_at' => $faker->dateTimeBetween('-1 Month', '+1 Month'),
                'featured' => $faker->boolean(10)
            ]);
            $product->categories()->attach(Category::inRandomOrder()->first()->id,);
        }
    }
}