<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'dosen',
            'email' => 'dosen@gmail.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
            'role' => 'teacher',
        ]);
    }
}
