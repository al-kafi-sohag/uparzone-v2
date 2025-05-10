<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Religion;
use App\Models\Mood;

class MigrateV1Users extends Command
{
    protected $signature = 'migrate:users';
    protected $description = 'Migrate users from main to this ';

    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate(); // Optional: Only if starting fresh

        $v1Users = DB::connection('v1')->table('users')->get();

        foreach ($v1Users as $v1User) {
            $v2User = [
                // Direct Mappings
                'id' => $v1User->id,
                'name' => $v1User->name,
                'email' => $v1User->email,
                'email_verified_at' => $v1User->email_verified_at,
                'password' => $v1User->password,
                'remember_token' => $v1User->remember_token,
                'created_at' => $v1User->created_at,
                'updated_at' => $v1User->updated_at,
                'referer_id' => $v1User->refer_id,
                'phone' => $v1User->phone,
                'age' => $v1User->age,
                'address' => $v1User->address,
                'state' => $v1User->state,
                'zip_code' => $v1User->zip,
                'balance' => $v1User->wallet,
                'reserved_balance' => $v1User->reserve,
                'active_time' => $v1User->spend_time,
                'is_premium' => $v1User->premium === 'active' ? 1 : 0,
                'age_privacy' => $v1User->age_privacy === 'private' ? 1 : 0,
                'gender_privacy' => $v1User->gender_privacy === 'private' ? 1 : 0,
                'address_privacy' => $v1User->address_privacy === 'private' ? 1 : 0,
                'religion_privacy' => $v1User->religion_privacy === 'private' ? 1 : 0,
                'status' => $v1User->active_status,
                'is_complete_profile' => $v1User->details_status === 'active' ? 1 : 0,
                'gender' => $v1User->gender,

                // New Fields with Defaults
                'google_id' => null,
                'reference_code' => $v1User->id,
                'lang' => 'en',
                'balance_privacy' => 0,
                'freeze_balance' => 0,
                'active_time_privacy' => 0,
                'city' => null,
                'city_privacy' => 0,
                'country' => null,
                'country_privacy' => 0,
                'state_privacy' => 0,
                'zip_code_privacy' => 0,
                'mood_privacy' => 0,
                'last_active_at' => $v1User->updated_at, // Use last update time
                'total_referral' => 0,
            ];

            // Map Religion
            if (!empty($v1User->religion)) {
                $religion = Religion::firstOrCreate(['name' => $v1User->religion]);
                $v2User['religion_id'] = $religion->id;
            }

            // Map Mood
            if (!empty($v1User->mood)) {
                $mood = Mood::firstOrCreate(['name' => $v1User->mood]);
                $v2User['mood_id'] = $mood->id;
            }

            DB::table('users')->insert($v2User);
            $this->info("Migrated user {$v1User->id}");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->info('Users migrated successfully.');
    }
}
