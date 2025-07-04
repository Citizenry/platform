<?php

namespace StreetSignal\Modules\TelegramBot\Services;

use StreetSignal\Modules\TelegramBot\Models\TelegramConversation;
use StreetSignal\Modules\TelegramBot\Models\TelegramBotUser;
use Carbon\Carbon;

class ConversationManager
{
    /**
     * Get or create active conversation for user
     */
    public function getOrCreateConversation(int $telegramUserId): TelegramConversation
    {
        return TelegramConversation::findOrCreateActive($telegramUserId);
    }

    /**
     * Update conversation state
     */
    public function updateState(TelegramConversation $conversation, array $updates): void
    {
        $conversation->updateState($updates);
    }

    /**
     * Get conversation state value
     */
    public function getState(TelegramConversation $conversation, string $key, $default = null)
    {
        return $conversation->getState($key, $default);
    }

    /**
     * Set conversation state value
     */
    public function setState(TelegramConversation $conversation, string $key, $value): void
    {
        $conversation->setState($key, $value);
        $conversation->save();
    }

    /**
     * Clear conversation state
     */
    public function clearState(TelegramConversation $conversation): void
    {
        $conversation->clearState();
    }

    /**
     * Check if conversation is in specific state
     */
    public function isInState(TelegramConversation $conversation, string $state): bool
    {
        return $conversation->getState('current_state') === $state;
    }

    /**
     * Set conversation to specific state
     */
    public function setCurrentState(TelegramConversation $conversation, string $state): void
    {
        $conversation->setState('current_state', $state);
        $conversation->save();
    }

    /**
     * Clean up expired conversations
     */
    public function cleanupExpiredConversations(): int
    {
        return TelegramConversation::expired()->delete();
    }

    /**
     * Get active conversations count
     */
    public function getActiveConversationsCount(): int
    {
        return TelegramConversation::active()->count();
    }

    /**
     * Get conversation statistics
     */
    public function getStatistics(): array
    {
        return [
            'active_conversations' => TelegramConversation::active()->count(),
            'expired_conversations' => TelegramConversation::expired()->count(),
            'total_conversations' => TelegramConversation::count(),
            'conversations_today' => TelegramConversation::where('created_at', '>=', Carbon::today())->count(),
            'conversations_this_week' => TelegramConversation::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
        ];
    }
}