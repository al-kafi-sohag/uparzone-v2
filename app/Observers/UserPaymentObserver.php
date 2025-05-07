<?php

namespace App\Observers;

use App\Models\UserPayment;
use App\Jobs\UserPaidPremiumJob;


class UserPaymentObserver
{

    public function created(UserPayment $userPayment): void
    {
        //
    }

    public function updating(UserPayment $userPayment): void
    {
        if ($userPayment->status == UserPayment::STATUS_COMPLETED) {
            $userPayment->user->update([
                'balance' => $userPayment->user->balance + $userPayment->amount,
            ]);
            UserPaidPremiumJob::dispatch($userPayment->id);
        }
    }
    public function updated(UserPayment $userPayment): void
    {
        //
    }

    /**
     * Handle the UserPayment "deleted" event.
     */
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
