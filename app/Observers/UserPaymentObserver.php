<?php

namespace App\Observers;

use App\Models\UserPayment;
use App\Jobs\UserPaidPremiumJob;
use App\Models\User;
use App\Models\UserTransaction;
use App\Services\UserBalanceService;
use App\Services\UserTransactionService;


class UserPaymentObserver
{

    public function created(UserPayment $userPayment): void
    {
        //
    }

    public function updating(UserPayment $userPayment): void
    {
        //
    }

    public function updated(UserPayment $userPayment): void
    {
        if ($userPayment->status == UserPayment::STATUS_COMPLETED) {

            $userPayment = UserPayment::with('user')->find($userPayment->id);
            $userPayment->user->update([
                'is_premium' => true
            ]);


            $userTransaction = UserTransaction::find($userPayment->user_transaction_id);
            $userTransaction->update([
                'status' => UserTransaction::STATUS_COMPLETED,
            ]);

            $referrer = User::where('id', $userPayment->user->referer_id)->first();
            if ($referrer) {
                $referrerUserTransaction = UserTransaction::where('key', 'referral')->where('receiver_id', $referrer->id)->where('sender_id', $userPayment->user->id)->first();
                if ($referrerUserTransaction) {
                    $referrerUserTransaction->update([
                        'status' => UserTransaction::STATUS_COMPLETED,
                        'key' => 'referral-completed',
                    ]);

                    $userBalanceService = new UserBalanceService();
                    $userBalanceService->setUser($referrer->id)->addBalance($referrerUserTransaction->amount);
                    $referrer->update([
                        'total_referral' => $referrer->referrals()->count(),
                        'premium_referral_count' => $referrer->premiumReferrals()->count(),
                    ]);
                }
            }

        }
    }

    public function deleted(UserPayment $userPayment): void
    {
        //
    }

    /**
     * Handle the UserPayment "restored" event.
     */
    public function restored(UserPayment $userPayment): void
    {
        //
    }

    /**
     * Handle the UserPayment "force deleted" event.
     */
    public function forceDeleted(UserPayment $userPayment): void
    {
        //
    }
}
