<?php

namespace StreetSignal\Modules\TelegramBot\Services;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\Update;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Exception;
use Illuminate\Support\Facades\Log;
use StreetSignal\Modules\TelegramBot\Models\TelegramBotUser;
use StreetSignal\Modules\TelegramBot\Models\TelegramConversation;
use StreetSignal\Modules\TelegramBot\Models\TelegramBotConfig;

class TelegramBotService
{
    protected ?BotApi $bot = null;
    protected ConversationManager $conversationManager;
    protected AuthenticationManager $authManager;
    protected FormFlowManager $formFlowManager;

    public function __construct(
        ?string $botToken,
        ConversationManager $conversationManager,
        AuthenticationManager $authManager,
        FormFlowManager $formFlowManager
    ) {
        if ($botToken) {
            $this->bot = new BotApi($botToken);
        }
        
        $this->conversationManager = $conversationManager;
        $this->authManager = $authManager;
        $this->formFlowManager = $formFlowManager;
    }

    /**
     * Process incoming update from Telegram
     */
    public function processUpdate(array $updateData): void
    {
        try {
            $update = Update::fromResponse($updateData);
            
            if ($update->getMessage()) {
                $this->handleMessage($update->getMessage());
            } elseif ($update->getCallbackQuery()) {
                $this->handleCallbackQuery($update->getCallbackQuery());
            }
        } catch (\Exception $e) {
            Log::error('Error processing Telegram update: ' . $e->getMessage(), [
                'update' => $updateData,
                'exception' => $e
            ]);
        }
    }

    /**
     * Handle incoming message
     */
    protected function handleMessage(Message $message): void
    {
        $chatId = $message->getChat()->getId();
        $userId = $message->getFrom()->getId();
        $username = $message->getFrom()->getUsername();
        $text = $message->getText();

        // Find or create bot user
        $botUser = TelegramBotUser::findOrCreateByTelegramId($userId, $username);
        
        // Get or create conversation
        $conversation = TelegramConversation::findOrCreateActive($userId);

        // Handle commands
        if ($text && str_starts_with($text, '/')) {
            $this->handleCommand($chatId, $text, $botUser, $conversation);
            return;
        }

        // Handle regular messages based on conversation state
        $this->handleConversationMessage($chatId, $message, $botUser, $conversation);
    }

    /**
     * Handle bot commands
     */
    protected function handleCommand(int $chatId, string $command, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $commandParts = explode(' ', $command, 2);
        $commandName = $commandParts[0];
        $commandArgs = $commandParts[1] ?? '';

        switch ($commandName) {
            case '/start':
                $this->handleStartCommand($chatId, $botUser, $conversation);
                break;
                
            case '/report':
                $this->handleReportCommand($chatId, $botUser, $conversation);
                break;
                
            case '/surveys':
                $this->handleSurveysCommand($chatId, $botUser, $conversation);
                break;
                
            case '/link':
                $this->handleLinkCommand($chatId, $botUser, $conversation);
                break;
                
            case '/unlink':
                $this->handleUnlinkCommand($chatId, $botUser, $conversation);
                break;
                
            case '/status':
                $this->handleStatusCommand($chatId, $botUser, $conversation);
                break;
                
            case '/help':
                $this->handleHelpCommand($chatId, $botUser, $conversation);
                break;
                
            default:
                $this->sendMessage($chatId, "Unknown command. Type /help to see available commands.");
        }
    }

    /**
     * Handle /start command
     */
    protected function handleStartCommand(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $config = TelegramBotConfig::first();
        $welcomeMessage = $config?->getSetting('welcome_message') ?? 
            "Welcome to StreetSignal Bot! 🏙️\n\n" .
            "I can help you submit reports about issues in your community.\n\n" .
            "Commands:\n" .
            "/report - Submit a new report\n" .
            "/surveys - View available report types\n" .
            "/link - Link your StreetSignal account\n" .
            "/help - Show all commands";

        $this->sendMessage($chatId, $welcomeMessage);
        
        // Clear any existing conversation state
        $conversation->clearState();
    }

    /**
     * Handle /report command
     */
    protected function handleReportCommand(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $this->formFlowManager->startReportFlow($chatId, $botUser, $conversation);
    }

    /**
     * Handle /surveys command
     */
    protected function handleSurveysCommand(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $this->formFlowManager->showAvailableSurveys($chatId, $botUser, $conversation);
    }

    /**
     * Handle /link command
     */
    protected function handleLinkCommand(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $this->authManager->startLinkingProcess($chatId, $botUser, $conversation);
    }

    /**
     * Handle /unlink command
     */
    protected function handleUnlinkCommand(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $this->authManager->unlinkAccount($chatId, $botUser, $conversation);
    }

    /**
     * Handle /status command
     */
    protected function handleStatusCommand(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $status = $botUser->isAuthenticated() ? 
            "✅ Linked to StreetSignal account" : 
            "❌ Not linked to StreetSignal account";
            
        $this->sendMessage($chatId, "Account Status: $status");
    }

    /**
     * Handle /help command
     */
    protected function handleHelpCommand(int $chatId, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $config = TelegramBotConfig::first();
        $helpMessage = $config?->getSetting('help_message') ?? 
            "StreetSignal Bot Commands:\n\n" .
            "/start - Welcome message and setup\n" .
            "/report - Submit a new report\n" .
            "/surveys - View available report types\n" .
            "/link - Link your StreetSignal account\n" .
            "/unlink - Unlink your account\n" .
            "/status - Check account status\n" .
            "/help - Show this help message\n\n" .
            "To submit a report, use /report and follow the prompts.";

        $this->sendMessage($chatId, $helpMessage);
    }

    /**
     * Handle conversation messages
     */
    protected function handleConversationMessage(int $chatId, Message $message, TelegramBotUser $botUser, TelegramConversation $conversation): void
    {
        $currentState = $conversation->getState('current_state');
        
        if (!$currentState) {
            $this->sendMessage($chatId, "I'm not sure what you're trying to do. Type /help to see available commands.");
            return;
        }

        // Delegate to appropriate handler based on state
        switch ($currentState) {
            case 'awaiting_survey_selection':
            case 'collecting_form_data':
                $this->formFlowManager->handleFormInput($chatId, $message, $botUser, $conversation);
                break;
                
            case 'awaiting_auth_confirmation':
                $this->authManager->handleAuthInput($chatId, $message, $botUser, $conversation);
                break;
                
            default:
                $this->sendMessage($chatId, "I'm not sure what you're trying to do. Type /help to see available commands.");
        }
    }

    /**
     * Handle callback queries (inline keyboard responses)
     */
    protected function handleCallbackQuery($callbackQuery): void
    {
        $chatId = $callbackQuery->getMessage()->getChat()->getId();
        $userId = $callbackQuery->getFrom()->getId();
        $data = $callbackQuery->getData();

        $botUser = TelegramBotUser::findOrCreateByTelegramId($userId);
        $conversation = TelegramConversation::findOrCreateActive($userId);

        // Answer the callback query to remove loading state
        $this->bot->answerCallbackQuery($callbackQuery->getId());

        // Handle the callback data
        if (str_starts_with($data, 'survey_')) {
            $surveyId = (int) str_replace('survey_', '', $data);
            $this->formFlowManager->selectSurvey($chatId, $surveyId, $botUser, $conversation);
        } elseif (str_starts_with($data, 'confirm_')) {
            $action = str_replace('confirm_', '', $data);
            $this->formFlowManager->handleConfirmation($chatId, $action, $botUser, $conversation);
        }
    }

    /**
     * Send message to chat
     */
    public function sendMessage(int $chatId, string $text, $replyMarkup = null): void
    {
        if (!$this->bot) {
            Log::error('Telegram bot not initialized');
            return;
        }

        try {
            $this->bot->sendMessage($chatId, $text, null, false, null, $replyMarkup);
        } catch (Exception $e) {
            Log::error('Failed to send Telegram message: ' . $e->getMessage(), [
                'chat_id' => $chatId,
                'text' => $text
            ]);
        }
    }

    /**
     * Send photo to chat
     */
    public function sendPhoto(int $chatId, $photo, string $caption = null): void
    {
        if (!$this->bot) {
            Log::error('Telegram bot not initialized');
            return;
        }

        try {
            $this->bot->sendPhoto($chatId, $photo, $caption);
        } catch (Exception $e) {
            Log::error('Failed to send Telegram photo: ' . $e->getMessage(), [
                'chat_id' => $chatId
            ]);
        }
    }

    /**
     * Check if bot is configured and enabled
     */
    public function isEnabled(): bool
    {
        $config = TelegramBotConfig::first();
        return $config && $config->is_enabled && $config->bot_token && $this->bot;
    }
}