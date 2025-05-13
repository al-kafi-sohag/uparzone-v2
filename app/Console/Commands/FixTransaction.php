<?php

namespace App\Console\Commands;

use App\Models\UserTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FixTransaction extends Command
{

    protected $signature = 'fix:transaction';

    protected $description = '';

    public function handle()
    {
        $transactions = UserTransaction::where('key', 'like', 'referral%')->get();
        foreach($transactions as $transaction){
            $this->info("Transaction: " . $transaction->id);
            if($transaction->sender_id){
                continue;
            }

            $sender = Str::before($transaction->key, '-');
            $this->error("Found Sender: " . $sender);
            // $transaction->update([
            //     'key' => 'referral',
            //     'sender_id' => $sender,
            // ]);
            $this->info("Transaction: " . $transaction->id . " updated");
        }
    }
}
