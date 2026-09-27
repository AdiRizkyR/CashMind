<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin System
        User::updateOrCreate(
            ['email' => 'admin@cashmind.id'],
            [
                'name' => 'Administrator System',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun User Personal Utama (Aditya Personal)
        User::updateOrCreate(
            ['email' => 'user@cashmind.id'],
            [
                'name' => 'Aditya Personal',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        // 3. Akun Demo User Tambahan (Rizky Finance)
        User::updateOrCreate(
            ['email' => 'demouser@cashmind.id'],
            [
                'name' => 'Rizky Finance User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
