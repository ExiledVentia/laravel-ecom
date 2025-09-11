<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();
        foreach (range(1, 50) as $index) {
            Product::create([
                'image' => 'https://picsum.photos/640/480?random='. $index,
                'name' => $faker->words(3, true),
                'price' => $faker->numberBetween(10000, 1000000),
                'stock' => $faker->numberBetween(0, 100),
            ]);
        }
    }
}
