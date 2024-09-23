<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;
use \App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            StateSeeder::class
        ]);

        // $stories = \App\Models\Story::factory(50)->create();

        // $tags = \App\Models\Tag::all();

        // $stories->each(function($story) use ($tags) {
        //     $story->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        // });
    }
}
