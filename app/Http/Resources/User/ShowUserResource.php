<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ShowUserResource extends JsonResource
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
                'type'  => 'users',
                'id'    => (string) $this->resource->id,

                'attributes' => [
                    'name'  => $this->whenHas('name', $this->resource->name),
                    'email' => $this->whenHas('email', $this->resource->email),
                    'type'  => $this->whenHas('type', $this->resource->type),
                ],

                'relationships' => [

                ],
            ],

            'links' => [
                'self'  => URL::route('users.show', $this->resource),
            ],
        ];
    }
}
