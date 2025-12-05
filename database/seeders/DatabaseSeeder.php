<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@chaloo.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Transporter User
        User::factory()->create([
            'name' => 'Transporter User',
            'email' => 'transporter@chaloo.com',
            'password' => bcrypt('password'),
            'role' => 'transporter',
            'status' => 'active',
        ]);

        // Agent User
        User::factory()->create([
            'name' => 'Agent User',
            'email' => 'agent@chaloo.com',
            'password' => bcrypt('password'),
            'role' => 'agent',
            'status' => 'active',
        ]);
    }
}
