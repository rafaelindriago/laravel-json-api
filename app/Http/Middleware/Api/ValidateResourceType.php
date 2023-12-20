<?php

declare(strict_types=1);

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateResourceType
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if ($request->isMethod('POST') || $request->isMethod('PATCH')) {
            if ($request->input('data.type') !== $type) {
                $data['errors'][] = [
                    'status'    => '409',
                    'title'     => 'Conflict',
                    'detail'    => "The expected resource type is {$type}.",

                    'source' => [
                        'pointer'   => '/data/type',
                    ],
                ];

                return new JsonResponse($data, 409);
            }
        }

        return $next($request);
    }
}
