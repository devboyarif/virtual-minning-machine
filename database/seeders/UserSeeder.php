<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an user
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => bcrypt('password'),
            'role' => UserRole::User,
            'vmm_coins' => 500,
            'balance' => 1000,
        ]);

        User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@mail.com',
            'password' => bcrypt('password'),
            'role' => UserRole::User,
            'vmm_coins' => 500,
            'balance' => 1000,
        ]);

        User::factory()->create([
            'name' => 'User 3',
            'email' => 'user3@mail.com',
            'password' => bcrypt('password'),
            'role' => UserRole::User,
            'vmm_coins' => 500,
            'balance' => 1000,
        ]);

        // Create an admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role' => UserRole::Admin,
        ]);

        User::factory(10)->create();
    }
}
