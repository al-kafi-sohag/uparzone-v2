<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

function user()
{
    if (Auth::check()) {
        return Auth::guard('web')->user();
    }
    return false;
}

function admin()
{
    if (Auth::guard('admin')->check()) {
        return Auth::guard('admin')->user();
    }
    return false;
}

function str_limit($string, $limit = 10, $end = '...')
{
    return Str::limit($string, $limit, $end);
}

function profile_img ($img = null){
    return $img ? asset($img) : asset('user/img/default-user.jpg');
}
