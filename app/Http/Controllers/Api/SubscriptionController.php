<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubscriptionRequest;
use App\Repositories\ProductRepository;
use App\Repositories\UserPremiumRepository;
use App\Services\Api\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscription(SubscriptionRequest $request, SubscriptionService $subscriptionService): JsonResponse
    {
        if (UserPremiumRepository::isActive(Auth::user())) {
            return responseJson(
                type: 'message',
                message: 'You already have an active subscription.',
            );
        }

        if (! $subscriptionService->checkPurchaseTransaction($request->get('product_id'), $request->get('receipt_token'))) {
            return responseJson(
                type: 'message',
                message: 'Purchase transaction failed.',
            );
        }

        UserPremiumRepository::makePremium(
            ProductRepository::getByUuid($request->get('product_id')),
            Auth::user(),
            $request->get('receipt_token')
        );

        return responseJson(
            type: 'data',
            data: [
                'subscription_status' => true,
            ],
        );
    }
}
