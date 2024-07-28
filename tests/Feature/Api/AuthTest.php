<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth(): void
    {
        $deviceUuid = Str::uuid()->toString();

        $response = $this->post('/api/auth', [
            'device_uuid' => $deviceUuid,
            'device_name' => 'Iphone 15 Pro',
        ]);

        $response->assertStatus(200)->assertJson(fn ($json) => [
            $json->has('data', fn ($json) => [
                $json->where('is_premium', false)
                    ->has('user', fn ($json) => [
                        $json->where('device_name', 'Iphone 15 Pro'),
                        $json->has('premium_information', fn ($json) => [
                            $json->where('remaining_active_chat_credit', null)
                        ])
                        ->etc(),
                    ])
                ->has('token')
            ]),
        ]);

        $this->assertDatabaseHas('devices', [
            'uuid' => $deviceUuid,
            'name' => 'Iphone 15 Pro',
        ]);

        $this->assertDatabaseHas('users', [
            'device_uuid' => $deviceUuid,
            'email' => null,
            'password' => null,
        ]);
    }
}
