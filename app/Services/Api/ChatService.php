<?php

namespace App\Services\Api;

use App\Models\Chat;
use App\Models\User;
use App\Repositories\ChatRepository;
use App\Repositories\UserPremiumRepository;
use Illuminate\Support\Str;

class ChatService
{
    public function getRemainingChatCredit(User $user): int
    {
        return UserPremiumRepository::getRemainingChatCredit($user);
    }

    public function createChat(User $user, string $message): Chat
    {
        return ChatRepository::create([
            'user_id' => $user->id,
            'chat_id' => $this->generateChatId($user->id),
            'user_message' => $message,
            'bot_message' => $this->getBotMessage(),
        ]);
    }

    private function generateChatId(int $userId): string
    {
        $userChatId = ChatRepository::getChatId($userId);

        if ($userChatId) {
            return $userChatId->chat_id;
        }

        $newChatId = Str::random(10);

        if (ChatRepository::checkChatIdExists($newChatId)) {
            return $this->generateChatId($userId);
        }

        return $newChatId;
    }

    private function getBotMessage(): string
    {
        return 'Bot message.';
    }
}
