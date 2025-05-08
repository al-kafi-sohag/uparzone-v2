<?php

namespace App\Services;

use App\Models\UserTransaction;

class UserTransactionService
{

    public UserTransaction $userTransaction;

    public function __construct()
    {
        $this->userTransaction = new UserTransaction();
    }

    public function createTransaction(?int $receiverId, ?int $senderId, float $amount, string $note, int $status, int $type, ?string $key = null): UserTransaction
    {
        return $this->userTransaction->create([
            'receiver_id' => $receiverId,
            'sender_id' => $senderId,
            'amount' => $amount,
            'note' => $note,
            'status' => $status,
            'type' => $type,
            'key' => $key,
        ]);
    }
}
