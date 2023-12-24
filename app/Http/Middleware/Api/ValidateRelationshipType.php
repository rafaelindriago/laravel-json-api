<?php

declare(strict_types=1);

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateRelationshipType
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string $relationship, string $type): Response
    {
        if ($request->isMethod('POST') || $request->isMethod('PATCH')) {
            $relationshipData = $request->input("data.relationships.{$relationship}.data");

            if (is_array($relationshipData)) {
                if ( ! array_is_list($relationshipData)) {
                    if(isset($relationshipData['type']) && $relationshipData['type'] !== $type) {

                        $data['errors'][] = [
                            'status'    => '409',
                            'title'     => 'Conflict',
                            'detail'    => "The expected resource type is {$type}.",

                            'source' => [
                                'pointer'   => "/data/relationships/{$relationship}/data/type",
                            ],
                        ];

                        return new JsonResponse($data, 409);
                    }
                }
            } else {
                foreach ($relationshipData as $key => $relatedData) {
                    if (isset($relatedData['type']) && $relatedData['type'] !== $type) {

                        $data['errors'][] = [
                            'status'    => '409',
                            'title'     => 'Conflict',
                            'detail'    => "The expected resource type is {$type}.",

                            'source' => [
                                'pointer'   => "/data/relationships/{$relationship}/data/{$key}/type",
                            ],
                        ];
                    }
                }

                if (isset($data['errors'])) {
                    return new JsonResponse($data, 409);
                }
            }
        }

        return $next($request);
    }
}
