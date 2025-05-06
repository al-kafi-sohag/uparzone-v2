<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Get comments for a post
     */
    public function getComments(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $comments = Comment::with('user')
            ->where('post_id', $request->post_id)
            ->whereNull('parent_id') // Only get top-level comments
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                $replies = Comment::with('user')
                    ->where('parent_id', $comment->id)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'content' => $reply->content,
                            'createdAt' => $reply->created_at->diffForHumans(),
                            'user' => [
                                'name' => $reply->user->name,
                                'avatar' => $reply->user->profile_photo_url ?? '',
                            ],
                        ];
                    });

                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'createdAt' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->profile_photo_url ?? '',
                    ],
                    'replies' => $replies,

                ];
            });

        return response()->json([
            'success' => true,
            'comments' => $comments,
            'count' => $comments->count() + Comment::where('post_id', $request->post_id)->whereNotNull('parent_id')->count(),
        ]);
    }

    /**
     * Store a new comment
     */
    public function store(CommentRequest $request)
    {
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        $formattedComment = [
            'id' => $comment->id,
            'content' => $comment->content,
            'createdAt' => $comment->created_at->diffForHumans(),
            'user' => [
                'name' => Auth::user()->name,
                'avatar' => Auth::user()->profile_photo_url ?? '',
            ],
            'replies' => [],
        ];

        return response()->json([
            'success' => true,
            'comment' => $formattedComment,
        ]);
    }
}
