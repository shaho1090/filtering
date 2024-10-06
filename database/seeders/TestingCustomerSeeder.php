<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class TestingCustomerSeeder extends Seeder
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
            Customer::factory(100)->create();
        }
    }
}
