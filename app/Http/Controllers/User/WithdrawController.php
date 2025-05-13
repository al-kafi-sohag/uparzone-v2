<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\WithdrawRequest;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWithdraw;
use App\Services\UserTransactionService;
use App\Services\UserWithdrawService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    public UserTransactionService $userTransactionService;
    public UserWithdrawService $userWithdrawService;

    public function __construct(UserTransactionService $userTransactionService, UserWithdrawService $userWithdrawService)
    {
        $this->middleware('auth:web');
        $this->userTransactionService = $userTransactionService;
        $this->userWithdrawService = $userWithdrawService;
    }

    public function index()
    {
        return view('user.wallet.index');
    }

    public function store(WithdrawRequest $request)
    {
        try {

            DB::beginTransaction();

            $user = User::find(user()->id);

            $total_withdraw = $request->amount;
            $actual_withdraw = $total_withdraw - $total_withdraw * 0.1;

            $userTransaction = $this->userTransactionService->createTransaction(null, $user->id, $total_withdraw, 'Withdrawal request for ' . $request->amount . ' tk', UserTransaction::STATUS_PENDING, UserTransaction::TYPE_DEBIT);

            $this->userWithdrawService->createWithdrawal($user->id, $total_withdraw, $request->gateway, $request->account_number, $request->division, $request->details, $userTransaction->id, UserWithdraw::STATUS_PENDING);

            $user->update([
                'balance' => $user->balance - $total_withdraw,
            ]);

            DB::commit();

            sweetalert()->success('Withdrawal request submitted successfully! Please wait for the approval.');
            return redirect()->route('user.home');
        } catch (\Exception $e) {
            DB::rollBack();
            sweetalert()->error('Withdrawal request failed! Please try again.');
            Log::error($e->getMessage());
            return redirect()->route('user.home');
        }
    }

    public function list()
    {
        $data['withdraws'] = UserWithdraw::where('user_id', user()->id)->latest()->paginate(10);
        return view('user.wallet.list', $data);
    }
}
