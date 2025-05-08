<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWithdraw;
use App\Services\UserTransactionService;
use App\Services\UserBalanceService;
class UserWithdrawService
{
    private UserWithdraw $userWithdraw;
    private UserTransactionService $userTransactionService;
    private UserBalanceService $userBalanceService;

    public function __construct(UserWithdraw $userWithdraw,UserTransactionService $userTransactionService,UserBalanceService $userBalanceService)
    {
        $this->userWithdraw = $userWithdraw;
        $this->userTransactionService = $userTransactionService;
        $this->userBalanceService = $userBalanceService;
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

        $this->withdrawBonus($userWithdraw);

        return $userWithdraw;
    }

    public function withdrawBonus($userWithdraw)
    {
        $user = user();
        $total_amount = $userWithdraw->amount;
        $total_bonus = $total_amount * 0.1;
        $actual_withdraw = $total_amount - $total_bonus;

        if($user->referer_id){
            $receieveable_amount = $total_bonus*.5;
            $this->userTransactionService->createTransaction($user->referer_id, $user->id, $receieveable_amount, 'Withdrawal bonus from User:' . $user->id, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT);
            // $this->userBalanceService->setUser($user->referer_id)->addBalance($receieveable_amount);
        }

        $count = User::where('referer_id', $user->id)->count();
        if($count > 0){
            $receieveable_amount = ($total_bonus*.5)/$count;

            $reffered_by = User::where('referer_id', $user->id)->get();
            foreach ($reffered_by as $reffered_user) {
                $this->userTransactionService->createTransaction($reffered_user->id, $user->id, $receieveable_amount, 'Withdrawal bonus from User:' . $user->id, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT);
                // $this->userBalanceService->setUser($reffered_user->id)->addBalance($receieveable_amount);
            }
        }
    }
}
