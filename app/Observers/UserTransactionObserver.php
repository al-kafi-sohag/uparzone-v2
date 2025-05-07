<?php

namespace App\Observers;

use App\Models\UserTransaction;

class UserTransactionObserver
{
    /**
     * Handle the UserTransaction "created" event.
     */
    public function created(UserTransaction $userTransaction): void
    {

    }

    /**
     * Handle the UserTransaction "updated" event.
     */
    public function updated(UserTransaction $userTransaction): void
    {
        //
    }

    /**
     * Handle the UserTransaction "deleted" event.
     */
    public function deleted(UserTransaction $userTransaction): void
    {
        //
    }

    /**
     * Handle the UserTransaction "restored" event.
     */
    public function restored(UserTransaction $userTransaction): void
    {
        //
    }

    /**
     * Handle the UserTransaction "force deleted" event.
     */
    public function forceDeleted(UserTransaction $userTransaction): void
    {
        //
    }
}
