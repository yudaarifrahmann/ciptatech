<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User untuk Superadmin
        User::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'role'     => 'superadmin',
        ]);

        // User untuk Supervisor
        User::create([
            'name'     => 'Supervisor User',
            'email'    => 'supervisor@example.com',
            'password' => Hash::make('12345678'),
            'role'     => 'supervisor',
        ]);

        // User untuk PIC
        User::create([
            'name'     => 'PIC User',
            'email'    => 'pic@example.com',
            'password' => Hash::make('12345678'),
            'role'     => 'PIC',
        ]);
    }
}