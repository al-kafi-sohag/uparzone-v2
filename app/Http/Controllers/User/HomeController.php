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

    public function home()
    {
        $data['posts'] = Post::with(['user', 'media'])->active()->latest()->paginate(10);

        return view('user.home.home', $data);
    }
}
