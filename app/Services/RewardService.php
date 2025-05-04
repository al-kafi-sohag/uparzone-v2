<?php

namespace App\Services;

use App\Models\User;

class RewardService
{
    private const REWARD_TIERS = [
        50 => 0.64,
        30 => 0.32,
        20 => 0.16,
        10 => 0.08,
        5 => 0.04,
        0 => 0.02,
    ];

    public function calculateReward(User $user, int $duration): float
    {
        $referralCount = $user->total_referral;
        $rate = $this->getRewardRate($referralCount);

        return round($rate * $duration, 2);
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
