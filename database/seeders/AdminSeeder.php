<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@store.com',
            'password' => Hash::make('1234567890'), // Use a secure password
            'role' => 'admin',
        ]);
    }
}
