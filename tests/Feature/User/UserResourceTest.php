<?php

declare(strict_types=1);

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    /**
     * Test if the resource can be stored.
     */
    public function test_store_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'users',

                'attributes' => [
                    'name'  => 'Rafael Indriago',
                    'email' => 'rafael.indriago93@gmail.com',
                    'type'  => 'writer',
                ],
            ],
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        $response = $this->json('POST', 'api/users', $data, $headers);

        $response->assertStatus(201);
        $response->assertJson($data);

        $this->assertDatabaseHas('users', $data['data']['attributes']);
    }

    /**
     * Test if the resource can be showed.
     */
    public function test_show_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'users',
                'id'    => '1',

                'attributes' => [
                    'name'  => 'Rafael Indriago',
                    'email' => 'rafael.indriago93@gmail.com',
                    'type'  => 'writer',
                ],
            ],
        ];

        $headers = [
            'Accept'    => 'application/json',
        ];

        $user = new User();

        $user->fill($data['data']['attributes']);

        $user->password = Str::random();

        $user->save();

        $response = $this->json('GET', 'api/users/1', [], $headers);

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
                'type'  => 'users',
                'id'    => '1',

                'attributes' => [
                    'name'  => 'Rafael Indriago',
                    'email' => 'rafael.indriago93@gmail.com',
                    'type'  => 'writer',
                ],
            ],
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];

        $user = new User();

        $user->fill($data['data']['attributes']);

        $user->password = Str::random();

        $user->save();

        $data['data']['attributes']['name'] = 'Andres Moya';
        $data['data']['attributes']['email'] = 'rafael.indriago.58321@gmail.com';

        $response = $this->json('PATCH', 'api/users/1', $data, $headers);

        $response->assertStatus(200);
        $response->assertJson($data);

        $this->assertDatabaseHas('users', $data['data']['attributes']);
    }

    /**
     * Test if the resource cen be destroyed.
     */
    public function test_destroy_resource(): void
    {
        $data = [
            'data' => [
                'type'  => 'users',

                'attributes' => [
                    'name'  => 'Rafael Indriago',
                    'email' => 'rafael.indriago93@gmail.com',
                    'type'  => 'writer',
                ],
            ],
        ];

        $headers = [
            'Accept'    => 'application/json',
        ];

        $user = new User();

        $user->fill($data['data']['attributes']);

        $user->password = Str::random();

        $user->save();

        $response = $this->json('DELETE', 'api/users/1', [], $headers);

        $response->assertStatus(200);
        $response->assertJson([]);

        $this->assertDatabaseMissing('users', $data['data']['attributes']);
    }
}
