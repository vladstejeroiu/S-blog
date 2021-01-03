<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Runs Tag, Admin then User Seeders
        $this->call(TagSeeder::class); // Creates 10 tags in the tags table
        $this->call(AdminSeeder::class); // Creates 1 admin user
        $this->call(UserSeeder::class); // Creates 20 users, each with 3 posts - each post having between 1-6 tags
    }
}
