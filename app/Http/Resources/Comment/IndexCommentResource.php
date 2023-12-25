<?php

declare(strict_types=1);

namespace App\Http\Resources\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class IndexCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type'  => 'comments',
            'id'    => (string) $this->id,

            'attributes' => [
                'content'   => $this->whenHas('content', $this->content),
            ],

            'relationships' => [
                'post' => $this->whenLoaded('post', fn() => [
                    'data' => [
                        'type'  => 'posts',
                        'id'    => (string) $this->post->id,
                    ],
                ]),

                'writer' => $this->whenNotNull($this->whenLoaded('writer', fn() => [
                    'data' => [
                        'type'  => 'users',
                        'id'    => (string) $this->writer->id,
                    ],
                ]), ['data' => null]),
            ],

            'links' => [
                'self'  => URL::route('comments.show', $this->resource),
            ],
        ];
    }
}
