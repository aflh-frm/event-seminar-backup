<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Akun EO (Event Organizer)
        User::create([
            'name' => 'Panitia Event',
            'email' => 'eo@gmail.com',
            'role' => 'eo',
            'password' => Hash::make('password'),
        ]);

        // 3. Akun Peserta (User)
        User::create([
            'name' => 'Peserta Seminar',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            CategorySeeder::class,
        ]);
    }
}