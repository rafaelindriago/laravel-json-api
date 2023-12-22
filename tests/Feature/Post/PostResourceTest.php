<?php

declare(strict_types=1);

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostResourceTest extends TestCase
{
    /**
     * Test if the resource can be stored.
     */
    public function test_store_resource(): void
    {
        $user = new User();

        $user->fill([
            'name'  => 'Rafael Indriago',
            'email' => 'rafael.indriago93@gmail.com',
            'type'  => 'writer',
        ]);

        $user->password = Str::random();

        $user->save();

        $data = [
            'data' => [
                'type'  => 'posts',

                'attributes' => [
                    'title'     => 'New title',
                    'content'   => 'New content.',
                ],

                'relationships' => [
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

        $response = $this->json('POST', 'api/posts', $data, $headers);

        $response->assertStatus(201);
        $response->assertJson($data);

        $this->assertDatabaseHas('posts', $data['data']['attributes']);
    }

    /**
     * Test if the resource can be showed.
     */
    public function test_show_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'posts',
                'id'    => '1',

                'attributes' => [
                    'title'     => 'New title',
                    'content'   => 'New content.',
                ],

                'relationships' => [
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

        $post->fill($data['data']['attributes']);

        $post->writer()
            ->associate($user);

        $post->save();

        $response = $this->json('GET', 'api/posts/1', [], $headers);

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
                'type'  => 'posts',
                'id'    => '1',

                'attributes' => [
                    'title'     => 'New title',
                    'content'   => 'New content.',
                ],

                'relationships' => [
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

        $post->fill($data['data']['attributes']);

        $post->writer()
            ->associate($user);

        $post->save();

        $data['data']['attributes']['title'] = 'Updated title';
        $data['data']['attributes']['content'] = 'Updated content.';

        $response = $this->json('PATCH', 'api/posts/1', $data, $headers);

        $response->assertStatus(200);
        $response->assertJson($data);

        $this->assertDatabaseHas('posts', $data['data']['attributes']);
    }

    /**
     * Test if the resource cen be destroyed.
     */
    public function test_destroy_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'posts',

                'attributes' => [
                    'title'     => 'New title',
                    'content'   => 'New content.',
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

        $post->fill($data['data']['attributes']);

        $post->writer()
            ->associate($user);

        $post->save();

        $response = $this->json('DELETE', 'api/posts/1', [], $headers);

        $response->assertStatus(200);
        $response->assertJson([]);

        $this->assertDatabaseMissing('posts', $data['data']['attributes']);
    }
}
