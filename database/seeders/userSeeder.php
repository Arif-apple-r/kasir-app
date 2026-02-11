<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('admin12345'),
        ]);

        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@example.com',
            'role' => 'karyawan',
            'password' => Hash::make('karyawan12345'),
        ]);

        User::create([
            'name' => 'Pelanggan',
            'email' => 'pelanggan@example.com',
            'role' => 'pelanggan',
            'password' => Hash::make('pelanggan12345'),
        ]);

    }
}
