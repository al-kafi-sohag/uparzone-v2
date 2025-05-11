<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class RewardService
{
    private const REWARD_TIERS = [
        50 => 0.64,
        30 => 0.32,
        20 => 0.16,
        10 => 0.08,
        5 => 0.04,
        0 => 0.02,
    ]; // this rate is per 30 second

    public function calculateReward($user, float $duration): float
    {
        $referralCount = $user->premium_referral_count;
        $rate = $this->getRewardRate($referralCount);
        $result = ($rate * $duration)/30;
        return (float) number_format($result, 4, '.', '');
    }

    protected function getRewardRate(int $referralCount): float
    {
        foreach (self::REWARD_TIERS as $threshold => $rate) {
            if ($referralCount >= $threshold) {
                return $rate;
            }
        }

        return self::REWARD_TIERS[0];
    }
}
