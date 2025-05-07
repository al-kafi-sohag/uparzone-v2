<?php

namespace App\Jobs;

use App\Models\UserTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\UserPayment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
            DB::beginTransaction();
            $userPayment = UserPayment::with('user')->find($this->userPaymentId);
            $userPayment->user->update([
                'is_premium' => true,
                'reference_code' => $userPayment->user->id,
            ]);


            $userTransaction = UserTransaction::find($userPayment->user_id);
            $userTransaction->update([
                'status' => UserTransaction::STATUS_COMPLETED,
            ]);



            DB::commit();
            Log::info('User paid premium', [
                'user_id' => $userPayment->user_id,
                'user_payment_id' => $userPayment->id,
                'user' => $userPayment->user,
            ]);


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }
}
