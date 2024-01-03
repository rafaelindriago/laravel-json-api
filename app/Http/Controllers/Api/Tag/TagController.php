<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Tag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tag\StoreTagRequest;
use App\Http\Requests\Api\Tag\UpdateTagRequest;
use App\Http\Resources\Tag\IndexTagResourceCollection;
use App\Http\Resources\Tag\ShowTagResource;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagController extends Controller
{
    /**
     * Create a new controller.
     */
    public function __construct()
    {
        $this->authorizeResource(Tag::class);

        $this->middleware('resource.type:tags');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $tags = Tag::query()
            ->paginate();

        return new IndexTagResourceCollection($tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request): JsonResource
    {
        $tag = new Tag();

        $attributes = $request->validated('data.attributes');

        $tag->fill($attributes);

        $tag->save();

        return new ShowTagResource($tag);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): JsonResource
    {
        return new ShowTagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag): JsonResource
    {
        $attributes = $request->validated('data.attributes');

        $tag->fill($attributes);

        $tag->save();

        return new ShowTagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): JsonResource
    {
        $tag->delete();

        return new JsonResource([]);
    }
}
