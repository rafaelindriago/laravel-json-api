<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()
            ->where('type', 'reader')
            ->get();

        $posts = Post::query()
            ->where('published_at', null)
            ->get();

        foreach ($posts as $post) {
            Comment::factory()
                ->count(3)
                ->for($post)
                ->for($users->random(), 'writer')
                ->create();

            Comment::factory()
                ->for($post)
                ->create();

            Comment::factory()
                ->hidden()
                ->for($post)
                ->create();
        }
    }
}
