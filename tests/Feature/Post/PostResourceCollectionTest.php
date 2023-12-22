<?php

declare(strict_types=1);

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostResourceCollectionTest extends TestCase
{
    /**
     * Test if the resource can be indexed.
     */
    public function test_index_resource_collection(): void
    {
        $data = [
            'data' => [
                [
                    'type'  => 'posts',
                    'id'    => '1',

                    'attributes' => [
                        'title'     => 'New title',
                        'content'   => 'New content.',
                    ],

                    'relationships' => [

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

        $post->fill($data['data'][0]['attributes']);

        $post->writer()
            ->associate($user);

        $post->save();

        $response = $this->json('GET', 'api/posts', [], $headers);

        $response->assertStatus(200);
        $response->assertJson($data);
    }
}
