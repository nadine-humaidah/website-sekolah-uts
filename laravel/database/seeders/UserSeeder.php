<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru PKN',
            'email' => 'guru@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Siswa XII RPL',
            'email' => 'siswa@sekolah.sch.id',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);
    }
}