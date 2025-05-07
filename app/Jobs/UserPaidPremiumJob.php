<?php

namespace App\Jobs;

use App\Models\UserTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\UserPayment;
use Illuminate\Support\Facades\Log;

class UserPaidPremiumJob implements ShouldQueue
{
    use Queueable;

    public $userPaymentId;


    public function __construct($userPaymentId)
    {
        $this->userPaymentId = $userPaymentId;
    }

    public function handle(): void
    {
        try {
            $userPayment = UserPayment::with('user')->find($this->userPaymentId);
            $userPayment->user->update([
                'is_premium' => true,
            ]);


            $userTransaction = UserTransaction::find($userPayment->user_id);
            $userTransaction->update([
                'status' => UserTransaction::STATUS_COMPLETED,
            ]);

            Log::info('User paid premium', [
                'user_id' => $userPayment->user_id,
                'user_payment_id' => $userPayment->id,
                'user' => $userPayment->user,
            ]);


        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
