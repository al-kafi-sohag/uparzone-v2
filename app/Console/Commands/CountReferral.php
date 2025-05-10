<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CountReferral extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:referral';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count total referral for each user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->total_referral = $user->referrals()->count();
            $user->save();

            $this->info("Referral count updated for user {$user->id}");
            $this->info("Total referral count updated for user {$user->total_referral}");
        }
    }
}
