<?php

namespace Tests\Feature\Api;

use App\Models\Device;
use App\Models\Product;
use App\Models\User;
use App\Models\UserPremium;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription(): void
    {
        $this->artisan('migrate');

        $device = Device::factory()->create();
        $user = User::factory()->create([
            'device_uuid' => $device->uuid,
        ]);

        Sanctum::actingAs($user);

        $this->artisan('app:create-products');

        $product = Product::first();

        $receiptToken = Str::random(50);

        $response = $this->post('/api/subscription', [
            'product_id' => $product->uuid,
            'receipt_token' => $receiptToken,
        ]);

        if (isset($response->json()['data'])){
            $response->assertStatus(200)->assertJson(fn ($json) => [
                $json->has('data', fn ($json) => [
                    $json->where('subscription_status', true)
                ]),
            ]);

            $this->assertDatabaseHas('user_premiums', [
                'device_uuid' => $device->uuid,
                'product_id' => $product->uuid,
                'remaining_chat_credit' => $product->chat_credit,
                'receipt_token' => $receiptToken,
                'is_active' => true,
            ]);
        } else {
            $response->assertStatus(200)->assertJson(fn ($json) => [
                $json->where('message', 'Purchase transaction failed.')
            ]);
        }
    }

    public function test_subscription_is_active(): void
    {
        $device = Device::factory()->create();
        $user = User::factory()->create([
            'device_uuid' => $device->uuid,
        ]);

        Sanctum::actingAs($user);

        $this->artisan('app:create-products');

        $product = Product::first();

        $receiptToken = Str::random(50);

        UserPremium::factory()->create([
            'device_uuid' => $device->uuid,
            'product_id' => $product->uuid,
            'remaining_chat_credit' => $product->chat_credit,
            'receipt_token' => $receiptToken,
        ]);

        $response = $this->post('/api/subscription', [
            'product_id' => $product->uuid,
            'receipt_token' => $receiptToken,
        ]);

        $response->assertStatus(200)->assertJson(fn ($json) => [
            $json->where('message', 'You already have an active subscription.')
        ]);

        $this->assertDatabaseCount('user_premiums', 1);
    }
}
