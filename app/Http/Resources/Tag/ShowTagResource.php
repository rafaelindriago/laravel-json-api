<?php

declare(strict_types=1);

namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ShowTagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'type'  => 'tags',
                'id'    => (string) $this->id,

                'attributes' => [
                    'name'  => $this->whenHas('name', $this->name),
                ],

                'relationships' => [],
            ],

            'links' => [
                'self'  => URL::route('tags.show', $this->resource),
            ],
        ];
    }
}
