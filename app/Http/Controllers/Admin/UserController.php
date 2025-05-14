<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWithdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserBalanceService;
use App\Services\UserTransactionService;
use App\Http\Requests\Admin\UserBalanceUpdateRequest;
use App\Http\Requests\Admin\UserPremiumUpgradeRequest;
use App\Models\UserPayment;

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
        $data['user'] = User::find($id);
        if (!$data['user']) {
            return redirect()->route('admin.user.list')->with('error', 'User not found');
        }
        $data['payments'] = UserPayment::with([
            'user:id,name',
        ])
            ->where('user_id', $id)
            ->latest()->get();

        $data['withdraws'] = UserWithdraw::with([
            'user:id,name',
        ])
            ->where('user_id', $id)
            ->latest()->get();
        return view('admin.user.profile', $data);
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

        if ($user->referer_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'This user already has a referrer'
            ]);
        }

        $user->referer_id = $request->user_id;
        $user->save();

        $referrer = User::find($request->user_id);
        $referrer->total_referral = $referrer->referrals()->count();

        if ($user->is_premium) {
            $referrer->premium_referral_count = $referrer->premiumReferrals()->count();
            $this->userBalanceService->setUser($referrer->id)->addBalance(config('app.referral_amount'));
            $this->userTransactionService->createTransaction($referrer->id, $user->id, config('app.referral_amount'), 'Referral Reward for user ' . $user->name, UserTransaction::STATUS_COMPLETED, UserTransaction::TYPE_CREDIT, 'referral' . $user->id);
        }

        $referrer->save();
        $this->userTransactionService->createTransaction($referrer->id, $user->id, config('app.referral_amount'), 'Referral Reward for user ' . $user->name, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT, 'referral' . $user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Referral added successfully'
        ]);
    }

    public function getTransactions($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $transactions = UserTransaction::with('sender', 'receiver')
            ->where('receiver_id', $id)
            ->orWhere('sender_id', $id)
            ->latest()->get();

        return datatables()->of($transactions)
            ->addIndexColumn()
            ->addColumn('amount', function ($transaction) {
                $prefix = '';
                return $prefix . ' ' . number_format($transaction->amount, 2) . ' ' . config('app.currency');
            })
            ->addColumn('type', function ($transaction) {
                $badgeClass = $transaction->type == UserTransaction::TYPE_CREDIT ? 'bg-success' : 'bg-danger';
                return '<span class="badge ' . $badgeClass . '">' . $transaction->typeText . '</span>';
            })
            ->addColumn('status', function ($transaction) {
                $badgeClass = $transaction->status == UserTransaction::STATUS_COMPLETED ? 'bg-success' : 'bg-warning';
                return '<span class="badge ' . $badgeClass . '">' . $transaction->statusText . '</span>';
            })
            ->addColumn('sender', function ($transaction) {
                return '<a href="' . '/admin/user/profile/' . $transaction->sender_id . '">' . ($transaction->sender ? $transaction->sender->name . ' (' . $transaction->sender->id . ')' : 'System') . '</a>';
            })
            ->addColumn('receiver', function ($transaction) {
                return '<a href="' . '/admin/user/profile/' . $transaction->receiver_id . '">' . ($transaction->receiver ? $transaction->receiver->name . ' (' . $transaction->receiver->id . ')' : 'System') . '</a>';
            })
            ->addColumn('created_at', function ($transaction) {
                return '<div>' . $transaction->created_at->format('d M, Y') . '</div>' .
                       '<small class="text-muted">' . $transaction->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['type', 'status', 'created_at', 'sender', 'receiver'])
            ->make(true);
    }

    public function loginAs($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        session(['admin_id' => Auth::guard('admin')->id()]);
        Auth::guard('web')->login($user);

        return redirect()->route('user.home')->with('success', 'You are now logged in as ' . $user->name);
    }

    public function updateBalance(UserBalanceUpdateRequest $request)
    {
        if ($request->type == 'credit') {
            $this->userBalanceService->setUser($request->user_id)->addBalance($request->amount);
            $this->userTransactionService->createTransaction(null, $request->user_id, $request->amount, $request->note, UserTransaction::STATUS_COMPLETED, UserTransaction::TYPE_CREDIT);
        } else {
            $this->userBalanceService->setUser($request->user_id)->removeBalance($request->amount);
            $this->userTransactionService->createTransaction(null, $request->user_id, $request->amount, $request->note, UserTransaction::STATUS_COMPLETED, UserTransaction::TYPE_DEBIT);
        }

        sweetAlert()->success('Balance updated successfully');
        return redirect()->back();
    }

    public function updatePremium(UserPremiumUpgradeRequest $request)
    {
        $user = User::find($request->user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->is_premium = $request->is_premium;
        $user->save();

        if ($request->is_premium) {
            $userTransaction = $this->userTransactionService->createTransaction(null, $user->id, config('app.premium_price'), 'Premium Payment', UserTransaction::STATUS_COMPLETED, UserTransaction::TYPE_DEBIT);
            UserPayment::create([
                'user_id' => $user->id,
                'user_transaction_id' => $userTransaction->id,
                'amount' => config('app.premium_price'),
                'currency' => config('app.currency'),
                'status' => UserPayment::STATUS_COMPLETED,
                'payment_method' => UserPayment::PAYMENT_METHOD_MANUAL,
                'payment_note' => 'Premium Payment made by admin',
            ]);
        }

        sweetAlert()->success('Premium status updated successfully');
        return redirect()->back();
    }
}
