<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserBalanceService;
use App\Services\UserTransactionService;

class UserController extends Controller
{
    public UserBalanceService $userBalanceService;
    public UserTransactionService $userTransactionService;

    public function __construct(UserBalanceService $userBalanceService, UserTransactionService $userTransactionService)
    {
        $this->middleware('auth:admin');
        $this->userBalanceService = $userBalanceService;
        $this->userTransactionService = $userTransactionService;
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

    public function getReferrals($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $referrals = User::where('referer_id', $id)->latest()->get();
        return datatables()->of($referrals)
            ->addIndexColumn()
            ->addColumn('status', function ($referral) {
                return '<span class="badge ' . ($referral->status == User::STATUS_ACTIVE ? 'bg-success' : 'bg-danger') . '">' . $referral->statusText . '</span>';
            })
            ->addColumn('premium', function ($referral) {
                return '<span class="badge ' . ($referral->is_premium ? 'bg-success' : 'bg-danger') . '">' . $referral->isPremiumText . '</span>';
            })
            ->addColumn('created_at', function ($referral) {
                return '<div>' . $referral->created_at->format('d M, Y') . '</div>' .
                       '<small class="text-muted">' . $referral->created_at->format('h:i A') . '</small>';
            })
            ->addColumn('action', function ($referral) {
                return '<a href="' . route('admin.user.profile', $referral->id) . '" class="btn btn-info">View</a>';
            })
            ->rawColumns(['status', 'premium', 'created_at', 'action'])
            ->make(true);
    }

    public function ajaxUserList(Request $request)
    {
        $search = $request->search;

        if ($search == '') {
            $users = User::select('id', 'name', 'email')
                ->orderby('name', 'asc')
                ->limit(10)
                ->get();
        } else {
            $users = User::select('id', 'name', 'email')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orderby('name', 'asc')
                ->limit(10)
                ->get();
        }

        $response = [];
        foreach ($users as $user) {
            $response[] = [
                'id' => $user->id,
                'text' => $user->name . ' (' . $user->email . ')'
            ];
        }

        return response()->json($response);
    }

    public function addReferral(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'referral_id' => 'required|exists:users,id|different:user_id',
        ]);

        $user = User::find($request->referral_id);

        // Check if user already has a referer
        if ($user->referer_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'This user already has a referrer'
            ]);
        }

        // Update user's referer_id
        $user->referer_id = $request->user_id;
        $user->save();

        // Update referrer's total_referral count
        $referrer = User::find($request->user_id);
        $referrer->total_referral = $referrer->referrals()->count();


        // Update premium referral count if applicable
        if ($user->is_premium) {
            $referrer->premium_referral_count = $referrer->premiumReferrals()->count();
            $this->userBalanceService->setUser($referrer->id)->addBalance(config('app.referral_amount'));
            $this->userTransactionService->createTransaction($referrer->id, $user->id, config('app.referral_amount'), 'Referral Reward for user ' . $user->name, UserTransaction::STATUS_COMPLETED, UserTransaction::TYPE_CREDIT, 'referral-' . $user->id);
        }

        $referrer->save();
        $this->userTransactionService->createTransaction($referrer->id, $user->id, config('app.referral_amount'), 'Referral Reward for user ' . $user->name, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT, 'referral-' . $user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Referral added successfully'
        ]);
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
