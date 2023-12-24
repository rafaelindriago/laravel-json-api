<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.title' => [
                'required', 'string', 'max:200',
            ],
            'data.attributes.content' => [
                'required', 'string', 'max:2000',
            ],

            'data.relationships.writer.data.id' => [
                'required', 'string',
                Rule::exists('users', 'id'),
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'data.attributes.title'     => 'title',
            'data.attributes.content'   => 'content',

            'data.relationships.writer.data.id' => 'writer',
        ];
    }
}
