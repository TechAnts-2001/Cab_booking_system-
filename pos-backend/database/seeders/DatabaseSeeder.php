<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'is_super_admin' => true,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        \App\Models\User::factory()->create([
            'is_super_admin' => false,
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
