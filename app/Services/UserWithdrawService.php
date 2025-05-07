<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWithdraw;
use App\Services\UserTransactionService;
class UserWithdrawService
{
    private UserWithdraw $userWithdraw;
    private UserTransactionService $userTransactionService;

    public function __construct(UserWithdraw $userWithdraw,UserTransactionService $userTransactionService)
    {
        $this->userWithdraw = $userWithdraw;
        $this->userTransactionService = $userTransactionService;
    }

    public function createWithdrawal(int $userId, float $amount, string $gateway, string $account_number, string $division, ?array $details, int $userTransactionId, int $status)
    {
        $userWithdraw = $this->userWithdraw->create([
            'user_id' => $userId,
            'amount' => $amount,
            'gateway' => $gateway,
            'account_number' => $account_number,
            'division' => $division,
            'details' => $details,
            'user_transaction_id' => $userTransactionId,
            'status' => $status,
        ]);

        $this->withdrawBonus();

        return $userWithdraw;
    }

    public function withdrawBonus()
    {
        $total_amount = $this->userWithdraw->amount;
        $total_bonus = $total_amount * 0.1;
        $actual_withdraw = $total_amount - $total_bonus;

        if($this->userWithdraw->user->referer_id){
            $receiceable_amount = $total_bonus*.5;
            $this->userTransactionService->createTransaction($this->userWithdraw->user->referer_id, $this->userWithdraw->user->id, $receiceable_amount, 'Withdrawal bonus for ' . $this->userWithdraw->user->name, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT);
        }

        $count = User::where('referer_id', $this->userWithdraw->user->id)->count();
        if($count > 0){
            $receiceable_amount = ($total_bonus*.5)/$count;

            $reffered_by = User::where('referer_id', $this->userWithdraw->user->id)->get();
            foreach ($reffered_by as $reffered_user) {
                $this->userTransactionService->createTransaction($reffered_user->id, $this->userWithdraw->user->id, $receiceable_amount, 'Withdrawal bonus for ' . $this->userWithdraw->user->name, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT);
            }
        }
    }
}
