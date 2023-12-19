<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\StoreUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Create a new controller
     *
     */
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $users = User::query()
            ->paginate();

        return new UserResourceCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResource
    {
        $user = new User();

        $attributes = $request->validated('data.attributes');

        $user->fill($attributes);

        $user->password = Str::random();

        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResource
    {
        $attributes = $request->validated('data.attributes');

        $user->fill($attributes);

        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResource
    {
        $user->delete();

        return new JsonResource([]);
    }
}
