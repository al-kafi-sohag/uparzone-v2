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


function formatTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

function starts_with($string, $substring) {
    return Str::startsWith($string, $substring);
}

function sanitize_content($content) {
    $content = strip_tags($content);
    $content = preg_replace('/[\x00-\x1F\x7F]/u', '', $content);
    $content = htmlspecialchars($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $content = preg_replace('/\s+/', ' ', $content);
    $content = trim($content);
    return $content;
}
