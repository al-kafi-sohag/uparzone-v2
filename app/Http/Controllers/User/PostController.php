<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Mood;
use App\Models\Religion;
use App\Models\Gender;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function create()
    {
        $data['categories'] = PostCategory::active()->orderBy('order', 'asc')->get();
        $data['moods'] = Mood::active()->orderBy('order', 'asc')->get();
        $data['religions'] = Religion::active()->get();
        $data['genders'] = Gender::active()->get();
        return view('user.post.create', $data);
    }

}
