<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $notFoundHttpException, Request $request): ?JsonResponse {
            if ($request->is('api/*')) {
                $data['errors'][] = [
                    'status'    => '404',
                    'title'     => 'Not Found',
                    'detail'    => 'The requested resource was not found.',
                ];

                return new JsonResponse($data, 404);
            }
        });

        $this->renderable(function (ValidationException $validationException, Request $request): ?JsonResponse {
            if ($request->is('api/*')) {
                foreach ($validationException->errors() as $attribute => $errors) {
                    $data['errors'][] = [
                        'status'    => '422',
                        'title'     => 'Unprocessable Content',
                        'detail'    => current($errors),

                        'source' => [
                            'pointer'   => '/' . str_replace('.', '/', $attribute),
                        ],
                    ];
                }

                return new JsonResponse($data, 422);
            }
        });
    }
}
