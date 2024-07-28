<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ChatRepository
{
    public static function query(): Builder
    {
        return Chat::query();
    }

    public static function create(array $data): Chat
    {
        return Chat::create($data);
    }

    public static function getChatId(int $userId): ?Chat
    {
        return self::query()
            ->where('user_id', $userId)
            ->first();
    }

    public static function checkChatIdExists(string $chatId): bool
    {
        return self::query()
            ->where('chat_id', $chatId)
            ->exists();
    }

    public static function checkAccess(User $user, string $chatId): bool
    {
        $chat = self::query()
            ->where('chat_id', $chatId)
            ->first();

        if (! $chat) {
            return true;
        }

        return $chat->user_id !== $user->id;
    }
}
