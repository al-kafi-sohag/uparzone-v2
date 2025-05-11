<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function index()
    {
        // return redirect()->route('user.maintenance');

        if (Auth::check()) {
            Auth::logout();

            // Clear session data
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        return view('auth.onboarding');
    }

    public function maintenance()
    {
        return view('auth.maintenance');
    }
}
