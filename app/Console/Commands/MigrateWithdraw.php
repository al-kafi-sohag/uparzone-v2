<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateWithdraw extends Command
{
    protected $signature = 'migrate:withdraw';
    protected $description = 'Migrate withdraw data with status mapping';

    public function handle()
    {
        $this->info('Starting migration process...');

        DB::connection('v1')->table('withdraws')->orderBy('id')->chunk(200, function ($withdraws) {
            foreach ($withdraws as $old) {
                DB::transaction(function () use ($old) {
                    // Create user transaction
                    $txId = DB::table('user_transactions')->insertGetId([
                        'receiver_id' => $old->user_id,
                        'sender_id' => $old->user_id,
                        'amount' => (double)$old->amount,
                        'note' => 'Withdrawal: ' . $old->transaction_id,
                        'status' => $this->mapStatus($old->status), // Mapped status
                        'type' => 1,
                        'key' => $old->transaction_id,
                        'created_at' => $old->created_at,
                        'updated_at' => $old->updated_at,
                    ]);

                    // Create user withdraw with mapped status
                    DB::table('user_withdraws')->insert([
                        'user_id' => $old->user_id,
                        'user_transaction_id' => $txId,
                        'amount' => (double)$old->amount,
                        'gateway' => $old->gateway_select,
                        'account_number' => $old->gateway_number,
                        'division' => $old->divisions,
                        'details' => json_encode([
                            'legacy_transaction_id' => $old->transaction_id,
                            'transaction_user' => $old->transaction_user,
                        ]),
                        'status' => $this->mapStatus($old->status), // Mapped status
                        'created_at' => $old->created_at,
                        'updated_at' => $old->updated_at,
                    ]);
                });
                $this->info("Migrated withdraw {$old->id}");
            }
        });

        $this->info('Migration completed successfully.');
    }

    protected function mapStatus($oldStatus)
    {
        return strtolower($oldStatus) === 'completed' ? 1 : 0;
    }
}
