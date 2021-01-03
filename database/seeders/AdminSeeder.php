<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        $admin = new User([
            'name' => 'Admin',
            'email' => 'admin@123.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Hashed version of admin123
            'remember_token' => Str::random(10),
            'role' => 'admin' // Set role as admin
        ]);

        $admin->save();
    }
}
