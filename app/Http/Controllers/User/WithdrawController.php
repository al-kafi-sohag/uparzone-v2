<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\WithdrawRequest;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWithdraw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
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

            $userTransaction = UserTransaction::create([
                'receiver_id' => null,
                'sender_id' => $user->id,
                'amount' => $request->amount,
                'note' => 'Withdrawal request for ' . $request->amount . ' tk',
                'status' => UserTransaction::STATUS_PENDING,
                'type' => UserTransaction::TYPE_DEBIT,
            ]);

            $withdraw = UserWithdraw::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'gateway' => $request->gateway,
                'account_number' => $request->account_number,
                'division' => $request->division,
                'user_transaction_id' => $userTransaction->id,
            ]);

            $user->update([
                'balance' => $user->balance - $request->amount,
            ]);

            DB::commit();

            sweetalert()->success('Withdrawal request submitted successfully! Please wait for the approval.');
            return redirect()->route('user.wallet');
        } catch (\Exception $e) {
            DB::rollBack();
            sweetalert()->error('Withdrawal request failed! Please try again.');
            Log::error($e->getMessage());
            return redirect()->route('user.wallet');
        }
    }
}
