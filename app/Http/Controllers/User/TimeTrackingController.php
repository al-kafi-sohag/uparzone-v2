<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserTimeTracking;
use App\Services\RewardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeTrackingController extends Controller
{
    public function __construct(
        protected RewardService $rewardService
    ) {
        $this->middleware('auth:web');
    }

    public function heartbeat(Request $request)
    {
        $user = Auth::user();
        $now = now();
        $duration = $this->calculateDuration($user, $now);
        $rewardAmount = 0;
        $shouldTrack = $this->shouldTrackActivity($duration);
    
        if ($shouldTrack) {
            $rewardAmount = $this->rewardService->calculateReward($user, $duration);
            $this->createTimeTrackingRecord($user, $now, $duration, $rewardAmount);
        }
    
        $this->updateUser($user, $now, $duration, $rewardAmount, $shouldTrack);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Heartbeat received',
            'data' => [
                'active_time' => $user->active_time,
                'balance' => $user->balance,
            ]
        ]);
    }

    protected function calculateDuration($user, Carbon $now): float
    {
        if (!$user->last_active_at) {
            return 0;
        }
        $lastActiveAt = Carbon::parse($user->last_active_at);
        $duration = $lastActiveAt->diffInSeconds($now);
        return $duration;
    }

    protected function shouldTrackActivity(float $duration): bool
    {
        return $duration > 0 && $duration < config('app.heartbeat_interval')*3;
    }

    protected function createTimeTrackingRecord($user, Carbon $now, float $duration, float $rewardAmount): void
    {
        UserTimeTracking::create([
            'user_id' => $user->id,
            'last_active_at' => $now,
            'active_time' => $duration,
            'reward_amount' => $rewardAmount,
        ]);
    }

    protected function updateUser($user, Carbon $now, float $duration, float $rewardAmount, bool $add): void
    {
        DB::transaction(function () use ($user, $now, $duration, $rewardAmount, $add) {
            $updates = [
                'last_active_at' => $now,
            ];

            if ($add) {
                $updates['active_time'] = $user->active_time + $duration;
                $updates['balance'] = $user->balance + $rewardAmount;
            }

            $user->update($updates);
        }, 3);
    }
}
