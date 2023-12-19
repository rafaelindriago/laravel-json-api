<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as Exception;

class ResourceValidationException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        $errorsObject = [];

        foreach ($this->errors() as $attribute => $errors) {
            foreach ($errors as $error) {

                $errorsObject[] = [
                    "status"    => "422",
                    "title"     => "Unprocessable Entity",

                    "detail"    => $error,

                    "source" => [
                        "pointer"   => str_replace('.', '/', $attribute),
                    ],
                ];
            }
        }

        $data = [
            'errors'    => $errorsObject,
        ];

        return new JsonResponse($data, 422);
    }
}
