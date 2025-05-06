<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Models\Post;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function home(Request $request)
    {
        $data['posts'] = Post::with(['user', 'media'])->active()->latest()->paginate(3);

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
