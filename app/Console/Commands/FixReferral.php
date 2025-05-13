<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserTransaction;


class FixReferral extends Command
{
    protected $signature = 'fix:referral';
    protected $description = '';


    public function handle()
    {
        $this->info('Start Checking Referral');
        $users = User::latest()->get();
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
                    $this->error('Found No Referal Transaction for user ' . $user->id);
                }

            }
        }
    }
}
