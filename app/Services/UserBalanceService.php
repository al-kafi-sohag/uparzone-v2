<?php

namespace App\Services;

use App\Models\User;

class UserBalanceService
{
    private ?User $user = null;

    public function setUser(int $userId): self
    {
        $user = User::findOrFail($userId);
        $this->user = $user;
        return $this;
    }

    public function addBalance(float $amount): bool
    {
        $this->ensureUserIsSet();

        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than zero');
        }

        $this->user->balance += $amount;
        return $this->user->save();
    }

    public function removeBalance(float $amount): bool
    {
        $this->ensureUserIsSet();

        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than zero');
        }

        if ($this->user->balance < $amount) {
            throw new \InvalidArgumentException('Insufficient balance');
        }

        $this->user->balance -= $amount;
        return $this->user->save();
    }

    public function getBalance(): float
    {
        $this->ensureUserIsSet();
        return $this->user->balance;
    }

    private function ensureUserIsSet(): void
    {
        if (!$this->user) {
            throw new \Exception('User not set. Call setUser() first.');
        }
    }
}
