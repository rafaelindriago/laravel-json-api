<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.name' => [
                'nullable', 'string', 'max:100',
            ],
            'data.attributes.email' => [
                'nullable', 'string', 'email:rfc,dns',
                Rule::unique('users', 'email')
                    ->ignore($this->route('user')),
            ],
            'data.attributes.type' => [
                'nullable', 'string',
                Rule::in(['reader', 'writer']),
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
            'data.attributes.name'  => 'name',
            'data.attributes.email' => 'email',
            'data.attributes.tyoe'  => 'type',
        ];
    }
}
