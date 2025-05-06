<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function home(Request $request)
    {
        // Get the current user ID
        $userId = user()->id;

        // Query posts with user reactions
        $data['posts'] = Post::with(['user', 'media', 'postReactions'])
            ->active()
            ->latest()
            ->leftJoin('reactions', function ($join) use ($userId) {
                $join->on('posts.id', '=', 'reactions.post_id')
                     ->where('reactions.user_id', '=', $userId);
            })
            ->select('posts.*', 'reactions.id as user_has_reacted')
            ->paginate(3);

        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $data['posts'],
                'pagination' => [
                    'more' => $data['posts']->hasMorePages(),
                    'next_page_url' => $data['posts']->nextPageUrl()
                ]
            ]);
        }

        return view('user.home.home', $data);
    }
}
