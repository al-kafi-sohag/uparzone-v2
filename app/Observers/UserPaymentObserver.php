<?php

namespace App\Observers;

use App\Models\UserPayment;
use App\Jobs\UserPaidPremiumJob;
use App\Models\UserTransaction;


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
                'is_premium' => true,
                'reference_code' => $userPayment->user->id,
            ]);


            $userTransaction = UserTransaction::find($userPayment->user_transaction_id);
            $userTransaction->update([
                'status' => UserTransaction::STATUS_COMPLETED,
            ]);

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
