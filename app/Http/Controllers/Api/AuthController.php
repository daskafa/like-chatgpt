<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Resources\Api\AuthResource;
use App\Repositories\UserRepository;
use App\Services\Api\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function auth(AuthRequest $request, AuthService $service): JsonResponse
    {
        try {
            DB::beginTransaction();

            $deviceUUID = $request->get('device_uuid');

            if (! UserRepository::checkUserIsRegistered($deviceUUID)) {
                $service->registerUser($deviceUUID, $request->get('device_name'));
            }

            DB::commit();

            return responseJson(
                type: 'data',
                data: [
                    'is_premium' => false,
                    'user' => AuthResource::make(UserRepository::getUserByDeviceUuid($deviceUUID)),
                ],
            );
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
