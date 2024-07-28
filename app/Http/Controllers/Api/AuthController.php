<?php

namespace App\Http\Controllers\Api;

use App\Constants\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Resources\Api\AuthResource;
use App\Repositories\DeviceRepository;
use App\Repositories\UserPremiumRepository;
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
            } else {
                DeviceRepository::updateDeviceName($deviceUUID, $request->get('device_name'));
            }

            DB::commit();

            return responseJson(
                type: 'data',
                data: [
                    'is_premium' => UserPremiumRepository::isActive(
                        UserRepository::getByDeviceUuid($deviceUUID)
                    ),
                    'user' => AuthResource::make(UserRepository::getByDeviceUuid($deviceUUID)),
                    'token' => UserRepository::createPlainTextToken(
                        UserRepository::getByDeviceUuid($deviceUUID)
                    ),
                ],
            );
        } catch (\Exception $exception) {
            DB::rollBack();

            return exceptionResponseJson(
                message: Constants::GENERAL_EXCEPTION_ERROR_MESSAGE,
                exceptionMessage: $exception->getMessage(),
            );
        }
    }
}
