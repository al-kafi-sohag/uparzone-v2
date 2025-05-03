<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function completeProfile()
    {
        $data['user'] = Auth::user();
        return view('user.profile.complete-profile', $data);
    }

    public function languageChange($lang): JsonResponse
    {
        $supportedLanguages = ['en', 'bn', 'hi'];
        if (!in_array($lang, $supportedLanguages)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unsupported language'
            ]);
        }
        User::where('id', Auth::user()->id)->update(['lang' => $lang]);
        App::setLocale($lang);

        return response()->json([
            'status' => 'success',
            'message' => 'Language changed successfully',
            'data' => [
                'language' => $lang
            ]
        ]);
    }
}
