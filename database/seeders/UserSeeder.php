<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario ADMIN
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Usuarios normales
        User::create([
            'name' => 'Usuario 1',
            'email' => 'user1@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Usuario 2',
            'email' => 'user2@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Usuario 3',
            'email' => 'user3@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
