<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class TestingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //not running on production
        if (env('APP_ENV') === 'production') {
            return;
        }

        //in case the production env has different name
        if ((env('APP_ENV') === 'local') || env('APP_ENV') === 'testing') {
            Order::factory(5)->create([
                'amount' => rand(100_000, 1_000_000),
            ]);

            Order::factory(5)->create([
                'amount' => rand(2_000, 50_000),
            ]);

            Order::factory(5)->create([
                'amount' => rand(5_000, 100_000),
            ]);
        }
    }
}
