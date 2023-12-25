<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.content' => [
                'nullable', 'string', 'max:1000',
            ],

            'data.relationships.post.data.id' => [
                'nullable', 'string',
                Rule::exists('posts', 'id'),
            ],
            'data.relationships.writer.data.id' => [
                'nullable', 'nullable', 'string',
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
            'data.attributes.content'   => 'content',

            'data.relationships.post.data.id'   => 'post',
            'data.relationships.writer.data.id' => 'writer',
        ];
    }
}
