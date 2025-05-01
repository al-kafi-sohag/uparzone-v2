<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
