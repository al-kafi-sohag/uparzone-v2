<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.onboarding');
    }
}
