<?php

namespace App\Services\Api;

class SubscriptionService
{
    public function checkPurchaseTransaction(string $productId, string $receiptToken): bool
    {
        return rand(0, 1) === 1;
    }
}
