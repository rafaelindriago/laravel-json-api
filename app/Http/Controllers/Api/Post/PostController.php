<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StorePostRequest;
use App\Http\Requests\Api\Post\UpdatePostRequest;
use App\Http\Resources\Post\IndexPostResourceCollection;
use App\Http\Resources\Post\ShowPostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostController extends Controller
{
    /**
     * Create a new controller.
     */
    public function __construct()
    {
        $this->authorizeResource(Post::class);

        $this->middleware('resource.type:posts');

        $this->middleware('relationship.type:writer,users');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $posts = Post::query()
            ->paginate();

        return new IndexPostResourceCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResource
    {
        $post = new Post();

        $attributes = $request->validated('data.attributes');

        $post->fill($attributes);

        $relationships = $request->input('data.relationships');

        $post->writer()
            ->associate($relationships['writer']['data']['id']);

        $post->save();

        $post->load('writer');

        return new ShowPostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): JsonResource
    {
        $post->load('writer');

        return new ShowPostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResource
    {
        $attributes = $request->validated('data.attributes');

        $post->fill($attributes);

        $relationships = $request->input('data.relationships');

        if (isset($relationships['writer']['data']['id'])) {
            $post->writer()
                ->associate($relationships['writer']['data']['id']);
        }

        $post->save();

        $post->load('writer');

        return new ShowPostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResource
    {
        $post->delete();

        return new JsonResource([]);
    }
}
