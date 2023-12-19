<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserResourceCollectionTest extends TestCase
{
    /**
     * Test if the resource can be indexed.
     */
    public function test_index_resource_collection(): void
    {
        $data = [
            'data' => [
                [
                    'type'  => 'users',
                    'id'    => '1',

                    'attributes' => [
                        'name'  => 'Rafael Indriago',
                        'email' => 'rafael.indriago93@gmail.com',
                        'type'  => 'writer',
                    ],
                ],
            ],
        ];

        $headers = [
            'Accept'    => 'application/json',
        ];

        $user = new User();

        $user->fill($data['data'][0]['attributes']);

        $user->password = Str::random();

        $user->save();

        $response = $this->json('GET', 'api/users', [], $headers);

        $response->assertStatus(200);
        $response->assertJson($data);
    }
}
