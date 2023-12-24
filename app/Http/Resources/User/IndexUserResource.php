<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class IndexUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type'  => 'users',
            'id'    => (string) $this->id,

            'attributes' => [
                'name'  => $this->whenHas('name', $this->name),
                'email' => $this->whenHas('email', $this->email),
                'type'  => $this->whenHas('type', $this->type),
            ],

            'relationships' => [
                'posts' => $this->whenLoaded('posts', fn() => [
                    'data' => $this->posts->map(fn($post) => [
                        'type'  => 'posts',
                        'id'    => (string) $post->id,
                    ]),
                ]),
            ],

            'links' => [
                'self'  => URL::route('users.show', $this->resource),
            ],
        ];
    }
}
