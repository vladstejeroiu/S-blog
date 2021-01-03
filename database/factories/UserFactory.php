<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10)
        ];
    }

    // This function creates a user_id FK for a post, based on the current user's id
    // This is now taken care of by the UserSeeder - kept for reference
    // public function configure()
    // {
    //     // Function occurs after the post is created
    //     return $this->afterCreating(function (User $user) {
    //         \App\Models\Post::factory()->create(['user_id' => $user->id]);
    //     });
    // }
}
