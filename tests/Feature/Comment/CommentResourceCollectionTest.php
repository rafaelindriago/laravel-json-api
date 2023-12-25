<?php

declare(strict_types=1);

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentResourceCollectionTest extends TestCase
{
    /**
     * Test if the resource can be indexed.
     */
    public function test_index_resource_collection(): void
    {
        $data = [
            'data' => [
                [
                    'type'  => 'comments',

                    'attributes' => [
                        'content'   => 'Added a new comment.',
                    ],

                    'relationships' => [],
                ],
            ],
        ];

        $headers = [
            'Accept'    => 'application/json',
        ];

        $user = new User();

        $user->fill([
            'name'  => 'Rafael Indriago',
            'email' => 'rafael.indriago93@gmail.com',
            'type'  => 'writer',
        ]);

        $user->password = Str::random();

        $user->save();

        $post = new Post();

        $post->fill([
            'title'     => 'New post!',
            'content'   => 'New post content.',
        ]);

        $post->writer()
            ->associate($user);

        $post->save();

        $comment = new Comment();

        $comment->fill($data['data'][0]['attributes']);

        $comment->post()
            ->associate($post);
        $comment->writer()
            ->associate($user);

        $comment->save();

        $response = $this->json('GET', 'api/comments', [], $headers);

        $response->assertStatus(200);
        $response->assertJson($data);
    }
}
