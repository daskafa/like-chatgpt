<?php

namespace Tests\Feature\Api;

use App\Models\Device;
use App\Models\Product;
use App\Models\User;
use App\Models\UserPremium;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_without_chat_id(): void
    {
        $this->artisan('migrate');

        $device = Device::factory()->create();
        $user = User::factory()->create([
            'device_uuid' => $device->uuid,
        ]);

        Sanctum::actingAs($user);

        $this->artisan('app:create-products');

        $product = Product::first();

        UserPremium::factory()->create([
            'device_uuid' => $device->uuid,
            'product_id' => $product->uuid,
            'remaining_chat_credit' => $product->chat_credit,
            'is_active' => true,
        ]);

        $response = $this->post('/api/chat', [
            'message' => 'Hello, World!',
        ]);

        $response->assertStatus(200)->assertJson(fn ($json) => [
            $json->has('data', fn ($json) => [
                $json->where('bot_message', 'Bot message.'),
                $json->etc(),
            ]),
        ]);
    }

    public function test_chat_with_chat_id(): void
    {
        $this->artisan('migrate');

        $device = Device::factory()->create();
        $user = User::factory()->create([
            'device_uuid' => $device->uuid,
        ]);

        Sanctum::actingAs($user);

        $this->artisan('app:create-products');

        $product = Product::first();

        UserPremium::factory()->create([
            'device_uuid' => $device->uuid,
            'product_id' => $product->uuid,
            'remaining_chat_credit' => $product->chat_credit,
            'is_active' => true,
        ]);

        $response = $this->post('/api/chat', [
            'message' => 'Hello, World!',
        ]);

        $chatId = $response->json()['data']['chat_id'];

        $response2 = $this->post('/api/chat', [
            'message' => 'Hello, World!',
            'chat_id' => $chatId,
        ]);

        $response2->assertStatus(200)->assertJson(fn ($json) => [
            $json->has('data', fn ($json) => [
                $json->where('bot_message', 'Bot message.'),
                $json->etc(),
            ]),
        ]);
    }

    public function test_chat_not_enough_credit(): void
    {
        $this->artisan('migrate');

        $device = Device::factory()->create();
        $user = User::factory()->create([
            'device_uuid' => $device->uuid,
        ]);

        Sanctum::actingAs($user);

        $this->artisan('app:create-products');

        $product = Product::first();

        UserPremium::factory()->create([
            'device_uuid' => $device->uuid,
            'product_id' => $product->uuid,
            'remaining_chat_credit' => 0,
            'is_active' => true,
        ]);

        $response = $this->post('/api/chat', [
            'message' => 'Hello, World!',
        ]);

        $response->assertStatus(200)->assertJson(fn ($json) => [
            $json->where('message', 'You have run out of chat credit.'),
        ]);
    }
}
