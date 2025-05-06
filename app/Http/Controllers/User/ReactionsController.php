<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\ReactionRequest;
use App\Models\Reaction;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function store(ReactionRequest $request)
    {
        try {
            DB::beginTransaction();

            $userId = user()->id;
            $postId = $request->post_id;

            $post = Post::findOrFail($postId);

            $reaction = Reaction::where('post_id', $postId)
                               ->where('user_id', $userId)
                               ->first();

            if ($reaction) {
                $reaction->delete();
                $post->decrement('reactions');

                $message = 'Reaction removed successfully';
                $actionTaken = 'removed';
            } else {
                Reaction::create([
                    'post_id' => $postId,
                    'user_id' => $userId,
                ]);

                $post->increment('reactions');

                $message = 'Reaction added successfully';
                $actionTaken = 'added';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'action' => $actionTaken,
                'reaction_count' => $post->reactions,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reaction failed: ' . $e->getMessage(), [
                'user_id' => user()->id,
                'post_id' => $request->post_id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process reaction. Please try again.',
            ], 500);
        }
    }
}
