<?php

declare(strict_types=1);

namespace Tests\Feature\Tag;

use App\Models\Tag;
use Tests\TestCase;

class TagResourceCollectionTest extends TestCase
{
    /**
     * Test if the resource can be indexed.
     */
    public function test_index_resource_collection(): void
    {
        $data = [
            'data' => [
                [
                    'type'  => 'tags',
                    'id'    => '1',

                    'attributes' => [
                        'name'  => 'newtag',
                    ],
                ],
            ],
        ];

        $headers = [
            'Accept'    => 'application/json',
        ];

        $user = new Tag();

        $user->fill($data['data'][0]['attributes']);

        $user->save();

        $response = $this->json('GET', 'api/tags', [], $headers);

        $response->assertStatus(200);
        $response->assertJson($data);
    }
}
