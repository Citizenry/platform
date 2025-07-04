<?php

namespace StreetSignal\Modules\TelegramBot\Services;

use StreetSignal\Modules\TelegramBot\Models\TelegramBotUser;
use StreetSignal\Modules\TelegramBot\Models\TelegramConversation;
use StreetSignal\Modules\V5\Models\User\User;
use TelegramBot\Api\Types\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthenticationManager
{
    protected TelegramBotService $botService;
    protected ConversationManager $conversationManager;

    public function __construct()
    {
        // We'll inject the bot service later to avoid circular dependency
    }

    /**
     * Set the bot service (called from service provider)
     */
    public function setBotService(TelegramBotService $botService): void
    {
        $this->botService = $botService;
    }

    /**
     * Start the account linking process
     */
    public function startLinkingProcess(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        if ($botUser->isAuthenticated()) {
            $this->botService->sendMessage($chatId, "You're already linked to a StreetSignal account. Use /unlink to disconnect first.");
            return;
        }

        // Generate a unique linking token
        $linkingToken = Str::random(32);
        
        $conversation->updateState([
            'current_state' => 'awaiting_auth_confirmation',
            'linking_token' => $linkingToken,
            'linking_started_at' => now()->toISOString()
        ]);

        $linkingUrl = url("/auth/telegram/link?token={$linkingToken}");
        
        $message = "🔗 Link your StreetSignal account\n\n" .
                  "To link your Telegram account with StreetSignal:\n\n" .
                  "1. Click this link: {$linkingUrl}\n" .
                  "2. Log in to your StreetSignal account\n" .
                  "3. Authorize the connection\n" .
                  "4. Return here and type 'confirm'\n\n" .
                  "This link will expire in 10 minutes.\n" .
                  "Type 'cancel' to abort the linking process.";

        $this->botService->sendMessage($chatId, $message);
    }

    /**
     * Handle authentication input during linking process
     */
    public function handleAuthInput(int $chatId, Message $message, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $text = strtolower(trim($message->getText()));
        
        if ($text === 'cancel') {
            $conversation->clearState();
            $this->botService->sendMessage($chatId, "Account linking cancelled.");
            return;
        }

        if ($text === 'confirm') {
            $this->checkLinkingStatus($chatId, $botUser, $conversation);
            return;
        }

        $this->botService->sendMessage($chatId, "Please type 'confirm' after completing the linking process, or 'cancel' to abort.");
    }

    /**
     * Check if the linking process was completed
     */
    protected function checkLinkingStatus(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $linkingToken = $conversation->getState('linking_token');
        
        if (!$linkingToken) {
            $this->botService->sendMessage($chatId, "No active linking process found. Please start over with /link.");
            $conversation->clearState();
            return;
        }

        // Check if linking was completed (this would be set by the web auth flow)
        $linkingData = cache()->get("telegram_linking_{$linkingToken}");
        
        if (!$linkingData) {
            $this->botService->sendMessage($chatId, 
                "Linking not completed yet. Please complete the web authentication process and try again.\n" .
                "Type 'cancel' to abort the linking process."
            );
            return;
        }

        // Complete the linking
        $this->completeLinking($chatId, $botUser, $conversation, $linkingData);
    }

    /**
     * Complete the account linking process
     */
    protected function completeLinking(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation, array $linkingData): void
    {
        try {
            $userId = $linkingData['user_id'];
            $oauthToken = $linkingData['oauth_token'];
            
            // Verify the user exists
            $user = User::find($userId);
            if (!$user) {
                throw new \Exception('User not found');
            }

            // Link the accounts
            $botUser->linkAccount($userId, $oauthToken);
            
            // Clear conversation state
            $conversation->clearState();
            
            // Clear the linking cache
            $linkingToken = $conversation->getState('linking_token');
            cache()->forget("telegram_linking_{$linkingToken}");

            $this->botService->sendMessage($chatId, 
                "✅ Account linked successfully!\n\n" .
                "Your Telegram account is now connected to your StreetSignal account. " .
                "Reports you submit will be associated with your account."
            );

            Log::info('Telegram account linked successfully', [
                'telegram_user_id' => $botUser->telegram_user_id,
                'user_id' => $userId
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to complete Telegram account linking', [
                'telegram_user_id' => $botUser->telegram_user_id,
                'error' => $e->getMessage()
            ]);

            $this->botService->sendMessage($chatId, 
                "❌ Failed to link account. Please try again later or contact support."
            );
        }
    }

    /**
     * Unlink the user's account
     */
    public function unlinkAccount(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        if (!$botUser->isAuthenticated()) {
            $this->botService->sendMessage($chatId, "You don't have a linked StreetSignal account.");
            return;
        }

        $botUser->unlinkAccount();
        $conversation->clearState();

        $this->botService->sendMessage($chatId, 
            "✅ Account unlinked successfully!\n\n" .
            "Your Telegram account is no longer connected to StreetSignal. " .
            "You can still submit anonymous reports."
        );

        Log::info('Telegram account unlinked', [
            'telegram_user_id' => $botUser->telegram_user_id
        ]);
    }

    /**
     * Get authentication token for API requests
     */
    public function getAuthToken(TelegramBotUser $botUser): ?string
    {
        if (!$botUser->isAuthenticated()) {
            return null;
        }

        return $botUser->oauth_token;
    }

    /**
     * Check if user can perform authenticated actions
     */
    public function canPerformAuthenticatedActions(TelegramBotUser $botUser): bool
    {
        return $botUser->isAuthenticated() && $botUser->oauth_token;
    }

    /**
     * Get user ID for authenticated user
     */
    public function getAuthenticatedUserId(TelegramBotUser $botUser): ?int
    {
        return $botUser->isAuthenticated() ? $botUser->user_id : null;
    }

    /**
     * Create a service user for anonymous submissions
     */
    public function getServiceUser(): User
    {
        // Find or create a dedicated service user for anonymous Telegram submissions
        $serviceUser = User::where('email', 'telegram-bot@streetsignal.local')->first();
        
        if (!$serviceUser) {
            $serviceUser = User::create([
                'email' => 'telegram-bot@streetsignal.local',
                'realname' => 'Telegram Bot Service',
                'username' => 'telegram-bot-service',
                'password' => bcrypt(Str::random(32)), // Random password, never used
                'role' => 'user'
            ]);
        }

        return $serviceUser;
    }
}