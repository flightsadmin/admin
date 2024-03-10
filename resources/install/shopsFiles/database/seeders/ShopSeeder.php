<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (["Clothes", "Electronics", "Appliances", "Bags"] as $value) {
            Category::create([
                'title' => $value,
                'slug'  => strtolower($value),
            ]);
        }

        foreach (["OCT23", "NOV23", "DEC23"] as $key => $value) {
            Coupon::create([
                'code' => $value,
                'discount'  => $key+1/100,
                'expiration_date'  => $faker->dateTimeBetween('-1 Day', '+1 Week'),
            ]);
        }

        for ($i = 1; $i <= 15; $i++) {
            $name = $faker->realText(20);
            $product = Product::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'name' => preg_replace('/[^A-Za-z0-9 ]/', '', ucwords($name)),
                'price' => random_int(40, 100),
                'image' => 'products/default.png',
                'description' => $faker->realTextBetween(100, 200, 2),
                'published_at' => $faker->dateTimeBetween('-1 Month', '+1 Day'),
                'featured' => $faker->boolean(10)
            ]);
            $product->categories()->attach(Category::inRandomOrder()->first()->id,);
        }
    }
}