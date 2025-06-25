<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => Role::ADMIN->value,
        ]);
        User::create([
            'name' => 'Regular User',
            'email' => 'user@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'role' => Role::USER->value,
        ]);
        User::factory(10)->create();
    }
}
