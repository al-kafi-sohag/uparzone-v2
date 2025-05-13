<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserTransaction;
use App\Services\UserTransactionService;

class FixReferral extends Command
{
    protected $signature = 'fix:referral {--id= : User ID}';
    protected $description = '';
    public UserTransactionService $userTransactionService;

    public function __construct(UserTransactionService $userTransactionService)
    {
        $this->userTransactionService = $userTransactionService;
    }

    public function handle()
    {
        $id = $this->option('id');
        $this->info('Start Checking Referral');
        if($id){
            $users = User::where('id', $id)->get();
        }else{
            $users = User::latest()->get();
        }
        foreach($users as $user){
            if($user->referer_id){
                $referer = User::findOrFail($user->referer_id);
                $this->info('Found Referral:' . $referer->id);
                $this->info('Checking Referral Transactions');
                $userTransaction = UserTransaction::where('receiver_id', $user->id)
                ->orWhere('sender_id', $referer->id)
                ->where('type', 'like', '%referral%')
                ->get();
                if($userTransaction->count() > 0){
                    $this->info('Found Referal Transaction:' . $userTransaction->count());
                }else{
                    // $this->userTransactionService->createTransaction($referer->id, $user->id, config('app.referral_amount'), 'Referral Reward for user ' . $user->name, UserTransaction::STATUS_PENDING, UserTransaction::TYPE_CREDIT, 'referral-' . $user->id);
                    $this->error('Found No Referal Transaction for user ' . $user->id);
                }
            }
        }
    }
}
