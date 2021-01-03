<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an array of tags
        $tags = [
            'Sports',
            'Outdoor',
            'Cooking',
            'Computing',
            'Reading',
            'Internet',
            'Comedy',
            'News',
            'Education',
            'Politics'
        ];

        // Loop through each tag assigning the name
        foreach ($tags as $name) {
            $tag = new Tag([
                'name' => $name
            ]);

            $tag->save(); // Save the tags
        }
    }
}
