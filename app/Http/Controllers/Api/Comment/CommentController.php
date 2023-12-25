<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\StoreCommentRequest;
use App\Http\Requests\Api\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\IndexCommentResourceCollection;
use App\Http\Resources\Comment\ShowCommentResource;
use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentController extends Controller
{
    /**
     * Create a new controller.
     */
    public function __construct()
    {
        $this->authorizeResource(Comment::class);

        $this->middleware('resource.type:comments');

        $this->middleware('relationship.type:post,posts');
        $this->middleware('relationship.type:writer,users');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $comments = Comment::query()
            ->paginate();

        return new IndexCommentResourceCollection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request): JsonResource
    {
        $comment = new Comment();

        $attributes = $request->validated('data.attributes');

        $comment->fill($attributes);

        $post = $request->validated('data.relationships.post.data.id');

        $comment->post()
            ->associate($post);

        $writer = $request->validated('data.relationships.writer.data.id');

        $comment->writer()
            ->associate($writer);

        $comment->save();

        $comment->load(['post', 'writer']);

        return new ShowCommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResource
    {
        $comment->load(['post', 'writer']);

        return new ShowCommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResource
    {
        $attributes = $request->validated('data.attributes');

        $comment->fill($attributes);

        $post = $request->validated('data.relationships.post.data.id');

        if ($post) {
            $comment->post()
                ->associate($post);
        }

        $writer = $request->validated('data.relationships.writer.data.id');

        if ($writer) {
            $comment->writer()
                ->associate($writer);
        } else {
            $comment->writer()
                ->disassociate();
        }

        $comment->save();

        $comment->load(['post', 'writer']);

        return new ShowCommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResource
    {
        $comment->delete();

        return new JsonResource([]);
    }
}
