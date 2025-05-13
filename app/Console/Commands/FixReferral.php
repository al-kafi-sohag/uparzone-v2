<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserWithdraw;
use App\Services\UserTransactionService;
use App\Services\UserBalanceService;

class FixReferral extends Command
{
    protected $signature = 'fix:referral {--id= : User ID}';
    protected $description = '';

    public function handle()
    {
        $id = $this->option('id');
        $this->info("\n\n\nStart Checking Referral");
        if($id){
            $referrals = User::where('referer_id', $id)->get();
        }else{
            $referrals = User::where('referer_id', '!=', null)->latest()->get();
        }
        foreach($referrals as $referral){
            $this->info("\n\nChecking Referral:" . $referral->id);
            $userTransaction = UserTransaction::where('receiver_id', $referral->referer_id)
                ->Where('sender_id', $referral->id)
                ->where('key', 'referral')
                ->get();

            if($userTransaction->count() > 0){
                $this->info("Referral Transaction found");
                $this->info("Referral Transaction: " . $userTransaction->count()." found");
                foreach($userTransaction as $transaction){
                    $this->info("Transaction: " . $transaction->id);
                }
            }else{
                $this->error("Referral Transaction not found");
                $userTransactionService = new UserTransactionService();
                if($referral->is_premium){
                    $userTransactionService->createTransaction($referral->referer_id, $referral->id, config('app.referral_amount'), 'Referral Reward for user ' . $referral->name, UserTransaction::STATUS_COMPLETED, UserTransaction::TYPE_CREDIT, 'referral');
                    $this->info("Referral Transaction created");
                    $userBalanceService = new UserBalanceService();
                    $userBalanceService->setUser($referral->referer_id)->addBalance(config('app.referral_amount'));
                    $earnings = UserWithdraw::where('user_id', $referral->referer_id)->get();
                    foreach($earnings as $earning){
                        $this->info("Earning: " . $earning->id);
                        $userBalanceService->setUser($earning->user_id)->removeBalance($earning->amount);
                    }
                    $this->info("Referral Balance added");
                }else{
                    $userTransactionService->createTransaction($referral->referer_id, $referral->id, config('app.referral_amount'), 'Referral Reward for user ' . $referral->name, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT, 'referral');
                }
            }
        }
    }
}
