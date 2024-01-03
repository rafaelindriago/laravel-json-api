<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
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
                'nullable', 'string', 'max:50', 'alpha_num',
                Rule::unique('tags', 'name')
                    ->ignore($this->route('tag')),
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
        ];
    }
}
