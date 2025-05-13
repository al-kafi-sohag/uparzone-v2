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
        $this->info("\n\n\nStart Checking Referral");
        if($id){
            $referrals = User::where('referer_id', $id)->get();
        }else{
            $referrals = User::latest()->get();
        }
        foreach($referrals as $referral){
            $this->info("\n\nChecking Referral:" . $referral->id);
            $userTransaction = UserTransaction::where('receiver_id', $id)
                ->orWhere('sender_id', $referral->id)
                ->where('type', 'like', 'referral%')
                ->get();

            if($userTransaction->count() > 0){
                $this->info("\nReferral Transaction found");
            }else{
                $this->error("\nReferral Transaction not found");
            }
        }
    }
}
