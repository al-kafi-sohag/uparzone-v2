<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        if (user()) {
            return redirect()->route('user.home');
        }
        return view('auth.onboarding');
    }
}
