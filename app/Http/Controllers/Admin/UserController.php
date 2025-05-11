<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function list()
    {
        return view('admin.user.list');
    }

    public function getUsers()
    {
        $users = User::query();

        return datatables()->of($users)
            ->addIndexColumn()
            ->addColumn('status', function ($user) {
                return '<span class="badge ' . ($user->status == User::STATUS_ACTIVE ? 'bg-success' : 'bg-danger') . '">' . $user->statusText . '</span>';
            })
            ->addColumn('premium', function ($user) {
                return '<span class="badge ' . ($user->is_premium ? 'bg-success' : 'bg-danger') . '">' . $user->isPremiumText . '</span>';
            })
            ->addColumn('created_at', function ($user) {
                return $user->created_at->format('d M Y');
            })
            ->addColumn('action', function ($user) {
                return '<div class="btn-group">
                    <a href="' . route('admin.user.profile', $user->id) . '" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> View
                    </a>
                    <a href="' . route('admin.user.loginas', $user->id) . '" class="btn btn-primary btn-sm">
                        <i class="fas fa-sign-in-alt"></i> Login As
                    </a>
                </div>';
            })
            ->rawColumns(['status', 'premium', 'action'])
            ->make(true);
    }

    public function profile($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.user.list')->with('error', 'User not found');
        }

        return view('admin.user.profile', compact('user'));
    }

    public function loginAs($id)
    {
        // Use first() to ensure we get a single model instance
        $user = User::where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Store admin session to be able to return back
        session(['admin_id' => Auth::guard('admin')->id()]);

        // Login as the selected user
        Auth::guard('web')->login($user);

        return redirect()->route('user.home')->with('success', 'You are now logged in as ' . $user->name);
    }
}
