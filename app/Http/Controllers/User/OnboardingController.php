<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        // return redirect()->route('user.maintenance');
        if (user()) {
            return redirect()->route('user.home');
        }
        return view('auth.onboarding');
    }

    public function maintenance()
    {
        return view('auth.maintenance');
    }
}
