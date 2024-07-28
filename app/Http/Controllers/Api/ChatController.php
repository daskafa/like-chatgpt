<?php

namespace App\Http\Controllers\Api;

use App\Constants\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChatRequest;
use App\Repositories\ChatRepository;
use App\Repositories\UserPremiumRepository;
use App\Services\Api\ChatService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class ChatController extends Controller
{
    public function chat(ChatRequest $request, ChatService $chatService): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();

            if ($request->get('chat_id')) {
                $checkAccess = ChatRepository::checkAccess($user, $request->get('chat_id'));

                if ($checkAccess) {
                    return responseJson(
                        type: 'message',
                        message: 'You do not have access to this chat',
                    );
                }
            }

            if (! UserPremiumRepository::isActive($user)) {
                return responseJson(
                    type: 'message',
                    message: 'You need to have an active subscription to use this feature',
                );
            }

            $remainingChatCredit = $chatService->getRemainingChatCredit($user);

            if ($remainingChatCredit <= 0) {
                return responseJson(
                    type: 'message',
                    message: 'You have run out of chat credit',
                );
            }

            $createChat = $chatService->createChat($user, $request->get('message'));
            UserPremiumRepository::decrementChatCredit($user);

            DB::commit();

            return responseJson(
                type: 'data',
                data: [
                    'bot_message' => $createChat->bot_message,
                    'chat_id' => $createChat->chat_id,
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
