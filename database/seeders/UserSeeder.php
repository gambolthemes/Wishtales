<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Demo User',
            'email' => 'demo@wishtales.com',
            'password' => Hash::make('password'),
            'is_premium' => false,
        ]);

        User::create([
            'name' => 'Premium User',
            'email' => 'premium@wishtales.com',
            'password' => Hash::make('password'),
            'is_premium' => true,
        ]);
    }
}
