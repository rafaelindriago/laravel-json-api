<?php

declare(strict_types=1);

namespace Tests\Feature\Tag;

use App\Models\Tag;
use Tests\TestCase;

class TagResourceTest extends TestCase
{
    /**
     * Test if the resource can be stored.
     */
    public function test_store_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'tags',

                'attributes' => [
                    'name'  => 'newtag',
                ],
            ],
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        $response = $this->json('POST', 'api/tags', $data, $headers);

        $response->assertStatus(201);
        $response->assertJson($data);

        $this->assertDatabaseHas('tags', $data['data']['attributes']);
    }

    /**
     * Test if the resource can be showed.
     */
    public function test_show_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'tags',
                'id'    => '1',

                'attributes' => [
                    'name'  => 'newtag',
                ],
            ],
        ];

        $headers = [
            'Accept'    => 'application/json',
        ];

        $tag = new Tag();

        $tag->fill($data['data']['attributes']);

        $tag->save();

        $response = $this->json('GET', 'api/tags/1', [], $headers);

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
                'type'  => 'tags',
                'id'    => '1',

                'attributes' => [
                    'name'  => 'newtag',
                ],
            ],
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        $tag = new Tag();

        $tag->fill($data['data']['attributes']);

        $tag->save();

        $data['data']['attributes']['name'] = 'updatedtag';

        $response = $this->json('PATCH', 'api/tags/1', $data, $headers);

        $response->assertStatus(200);
        $response->assertJson($data);

        $this->assertDatabaseHas('tags', $data['data']['attributes']);
    }

    /**
     * Test if the resource can be destroyed.
     */
    public function test_destroy_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'tags',

                'attributes' => [
                    'name'  => 'newtag',
                ],
            ],
        ];

        $headers = [
            'Accept'    => 'application/json',
        ];

        $tag = new Tag();

        $tag->fill($data['data']['attributes']);

        $tag->save();

        $response = $this->json('DELETE', 'api/tags/1', [], $headers);

        $response->assertStatus(200);
        $response->assertJson([]);

        $this->assertDatabaseMissing('tags', $data['data']['attributes']);
    }
}
