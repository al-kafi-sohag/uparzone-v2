<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

function user(): bool|User
{
    if (Auth::check()) {
        return Auth::user();
    }
    return false;
}
