<?php

declare(strict_types=1);

namespace App\Http\Resources\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type'  => 'posts',
            'id'    => (string) $this->id,

            'attributes' => [
                'title'     => $this->whenHas('title', $this->title),
                'content'   => $this->whenHas('content', $this->content),
            ],

            'relationships' => [
                'writer'    => $this->whenLoaded('writer', fn() => [
                    'data' => [
                        'type'  => 'users',
                        'id'    => (string) $this->writer->id,
                    ],
                ]),
            ],

            'links' => [
                'self'  => URL::route('posts.show', $this->resource),
            ],
        ];
    }
}
