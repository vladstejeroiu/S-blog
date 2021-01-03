<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 
        return [
            //Generates faker data for columns in post table
            // user_id FK is now defined in the UserSeeder  - kept for reference
            // 'user_id' => \App\Models\User::factory(), // Use the id from the current user instance
            'heading' => $this->faker->sentence, // Post heading
            'subheading' => $this->faker->sentence, // Post subheading
            'body' => $this->faker->paragraph // Post body text
        ];
    }
}
