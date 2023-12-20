<?php

declare(strict_types=1);

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateResourceId
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $parameter): Response
    {
        if ($request->isMethod('PATCH')) {
            $model = $request->route($parameter);

            $id = $model instanceof Model
                ? (string) $model->getKey()
                : $model;

            if ($request->input('data.id') !== $id) {
                $data['errors'][] = [
                    'status'    => '409',
                    'title'     => 'Conflict',
                    'detail'    => "The expected resource id is {$id}.",

                    'source' => [
                        'pointer'   => '/data/id',
                    ],
                ];

                return new JsonResponse($data, 409);
            }
        }

        return $next($request);
    }
}
