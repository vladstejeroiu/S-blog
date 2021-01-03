<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use the user factory, make 20 users
        \App\Models\User::factory()->count(20)->create()
            ->each(function ($user) { // For each user, create 3 new posts
                \App\Models\Post::factory()->count(3)->create(
                    [
                        'user_id' => $user->id // Set the user_id FK as the current user's id
                    ]
                )
                    ->each(function ($post) { // Add tags to each post
                        $tag_ids = range(1, 10); // Initialise an array ranging from 1-10
                        shuffle($tag_ids); // Shuffle the numbers in the array
                        $tagstobeused = array_slice($tag_ids, 0, rand(1, 6)); // Each post will have at least 1 tag and up to 6 tags
                        // Loop through the tags that will be used, creating a row in the table for each
                        foreach ($tagstobeused as $tag_id) {
                            DB::table('post_tag')
                                ->insert(
                                    [
                                        'post_id' => $post->id, // id of the current post
                                        'tag_id' => $tag_id, // id of the current tag (as faked above)
                                        'created_at' => Now(), // Fill timestamps
                                        'updated_at' => Now()
                                    ]
                                );
                        }
                    });
            });
    }
}
