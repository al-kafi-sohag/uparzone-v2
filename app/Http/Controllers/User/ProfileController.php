<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileRequest;
use App\Http\Requests\User\SetLanguageRequest;
use App\Http\Requests\User\VerifyReferenceCodeRequest;
use App\Models\Gender;
use App\Models\Mood;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function completeProfile()
    {
        if (Auth::user()->is_complete_profile) {
            return redirect()->route('user.home');
        }
        $data['user'] = Auth::user();
        $data['moods'] = Mood::select('id', 'name', 'emoji', 'order')->where('status', Mood::STATUS_ACTIVE)->orderBy('order', 'asc')->get();
        return view('user.profile.complete-profile', $data);
    }

    public function storeProfileData(ProfileRequest $request)
    {
        User::where('id', Auth::user()->id)->update([
            'age' => $request->age,
            'gender' => $request->gender,
            'profession' => $request->profession,
            'mood_id' => $request->mood,
            'is_complete_profile' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => [
                'is_complete_profile' => true
            ]
        ]);
    }

    public function setLanguage(SetLanguageRequest $request): JsonResponse
    {
        User::where('id', Auth::user()->id)->update(['lang' => $request->language]);
        App::setLocale($request->language);

        return response()->json([
            'status' => 'success',
            'message' => 'Language changed successfully',
            'data' => [
                'language' => $request->language
            ]
        ]);
    }

    public function verifyReferenceCode(VerifyReferenceCodeRequest $request): JsonResponse
    {
        $user = User::where('reference_code', $request->reference_code)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Reference code does not exist',
            ]);
        }
        User::where('id', Auth::user()->id)->update(['referer_id' => $user->id]);
        return response()->json([
            'status' => 'success',
            'message' => 'Reference code verified successfully',
            'data' => [
                'referer_id' => $user->id,
                'referer_name' => $user->name
            ]
        ]);
    }
}
