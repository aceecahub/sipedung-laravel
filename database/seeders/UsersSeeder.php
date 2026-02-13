<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// model
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'RT',
                'email' => 'rt@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'rt',
            ],
            [
                'name' => 'KK',
                'email' => 'kk@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'kk',
            ],
            [
                'name' => 'warga',
                'email' => 'warga@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'warga',
            ],
        ])->each(function ($data) {
            User::create($data);
        });
    }
}
