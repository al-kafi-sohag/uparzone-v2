<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserTimeTracking;
use App\Services\RewardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        if ($this->shouldTrackActivity($duration)) {
            $rewardAmount = $this->rewardService->calculateReward($user, $duration);
            $this->createTimeTrackingRecord($user, $now, $duration, $rewardAmount);
        }

        $this->updateUser($user, $now, $duration, $rewardAmount);

        return response()->json([
            'status' => 'success',
            'message' => 'Heartbeat received',
            'data' => [
                'active_time' => $user->active_time,
                'balance' => $user->balance,
            ]
        ]);
    }

    protected function calculateDuration($user, Carbon $now): int
    {
        return $user->last_active_at
            ? $user->last_active_at->diffInSeconds($now)
            : 0;
    }

    protected function shouldTrackActivity(int $duration): bool
    {
        return $duration > 0 && $duration < 60;
    }

    protected function createTimeTrackingRecord($user, Carbon $now, int $duration, float $rewardAmount): void
    {
        UserTimeTracking::create([
            'user_id' => $user->id,
            'last_active_at' => $now,
            'active_time' => $duration,
            'reward_amount' => $rewardAmount,
        ]);
    }

    protected function updateUser($user, Carbon $now, int $duration, float $rewardAmount): void
    {
        DB::transaction(function () use ($user, $now, $duration, $rewardAmount) {
            $user->update(['last_active_at' => $now]);
            $user->increment('active_time', $duration);
            $user->increment('balance', $rewardAmount);
        });

        $user->refresh();
    }
}
