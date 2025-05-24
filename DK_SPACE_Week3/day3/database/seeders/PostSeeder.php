<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Database\Factories\PostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Author::all() as $author) {
            Post::factory()
                ->count(rand(3, 7))
                ->create([
                    'author_id' => $author->id, 
                ]);
        }
    }
}
