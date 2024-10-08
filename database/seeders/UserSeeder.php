<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.ir',
            'password' => bcrypt('123456'),
            'mobile' => 910000000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
