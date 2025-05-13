<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserTransaction;

class FixReferral extends Command
{
    protected $signature = 'fix:referral {--id= : User ID}';
    protected $description = '';

    public function handle()
    {
        $id = $this->option('id');
        $this->info('Start Checking Referral');
        if($id){
            $referrals = User::where('referer_id', $id)->get();
        }else{
            $referrals = User::latest()->get();
        }
        foreach($referrals as $referral){
                $this->info('Found Referral:' . $referral->id);
                $this->info('Checking Referral Transactions');
                $userTransaction = UserTransaction::where('receiver_id', $id)
                ->orWhere('sender_id', $referral->id)
                ->where('type', 'like', 'referral%')
                ->get();

                if($userTransaction->count() > 0){
                    $this->info('Referral Transaction found');
                }else{
                    $this->error('Referral Transaction not found');
                }
        }
    }
}
