<?php

declare(strict_types=1);

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentResourceTest extends TestCase
{
    /**
     * Test if resource can be stored.
     */
    public function test_store_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'comments',

                'attributes' => [
                    'content'   => 'Added a new comment.',
                ],

                'relationships' => [
                    'post' => [
                        'data' => [
                            'type' => 'posts', 'id' => '1',
                        ],
                    ],

                    'writer' => [
                        'data' => [
                            'type' => 'users', 'id' => '1',
                        ],
                    ],
                ],
            ],
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
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

        $response = $this->json('POST', 'api/comments', $data, $headers);

        $response->assertStatus(201);
        $response->assertJson($data);

        $this->assertDatabaseHas('comments', $data['data']['attributes']);
    }

    /**
     * Test if the resource can be showed.
     */
    public function test_show_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'comments',

                'attributes' => [
                    'content'   => 'Added a new comment.',
                ],

                'relationships' => [
                    'post' => [
                        'data' => [
                            'type' => 'posts', 'id' => '1',
                        ],
                    ],

                    'writer' => [
                        'data' => [
                            'type' => 'users', 'id' => '1',
                        ],
                    ],
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

        $comment->fill($data['data']['attributes']);

        $comment->post()
            ->associate($post);
        $comment->writer()
            ->associate($user);

        $comment->save();

        $response = $this->json('GET', 'api/comments/1', [], $headers);

        $response->assertStatus(200);
        $response->assertJson($data);
    }

    /**
     * Test if the resource can be updated.
     */
    public function test_update_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'comments',

                'attributes' => [
                    'content'   => 'Added a new comment.',
                ],

                'relationships' => [
                    'post' => [
                        'data' => [
                            'type' => 'posts', 'id' => '1',
                        ],
                    ],

                    'writer' => [
                        'data' => [
                            'type' => 'users', 'id' => '1',
                        ],
                    ],
                ],
            ],
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
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

        $comment->fill($data['data']['attributes']);

        $comment->post()
            ->associate($post);
        $comment->writer()
            ->associate($user);

        $comment->save();

        $data['data']['attributes']['content'] = 'Updated comment.';
        $data['data']['relationships']['writer']['data'] = null;

        $response = $this->json('PATCH', 'api/comments/1', $data, $headers);

        $response->assertStatus(200);
        $response->assertJson($data);

        $this->assertDatabaseHas('comments', $data['data']['attributes']);
    }

    /**
     * Test if the resource cen be destroyed.
     */
    public function test_destroy_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'comments',

                'attributes' => [
                    'content'   => 'Added a new comment.',
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

        $comment->fill($data['data']['attributes']);

        $comment->post()
            ->associate($post);
        $comment->writer()
            ->associate($user);

        $comment->save();

        $response = $this->json('DELETE', 'api/comments/1', [], $headers);

        $response->assertStatus(200);
        $response->assertJson([]);

        $this->assertDatabaseMissing('comments', $data['data']['attributes']);
    }
}
