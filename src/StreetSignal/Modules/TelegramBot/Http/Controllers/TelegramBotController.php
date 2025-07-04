<?php

namespace StreetSignal\Modules\TelegramBot\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Bus\Command\CommandBus;
use App\Bus\Query\QueryBus;
use StreetSignal\Modules\V5\Http\Controllers\V5Controller;
use StreetSignal\Modules\TelegramBot\Services\TelegramBotService;
use StreetSignal\Modules\TelegramBot\Models\TelegramBotConfig;
use StreetSignal\Modules\TelegramBot\Requests\TelegramConfigRequest;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Exception;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends V5Controller
{
    protected TelegramBotService $botService;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus, TelegramBotService $botService)
    {
        parent::__construct($queryBus, $commandBus);
        $this->botService = $botService;
    }

    /**
     * Handle incoming webhook from Telegram
     */
    public function webhook(Request $request): JsonResponse
    {
        try {
            $update = $request->all();
            
            // Validate webhook signature if configured
            if (!$this->validateWebhook($request)) {
                Log::warning('Invalid Telegram webhook signature', ['ip' => $request->ip()]);
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Process the update
            $this->botService->processUpdate($update);

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            Log::error('Telegram webhook error: ' . $e->getMessage(), [
                'exception' => $e,
                'update' => $request->all()
            ]);
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Get bot configuration
     */
    public function getConfig(): JsonResponse
    {
        $config = TelegramBotConfig::first();
        
        if (!$config) {
            return response()->json([
                'is_enabled' => false,
                'webhook_url' => null,
                'default_survey_id' => null,
                'settings' => []
            ]);
        }

        return response()->json([
            'is_enabled' => $config->is_enabled,
            'webhook_url' => $config->webhook_url,
            'default_survey_id' => $config->default_survey_id,
            'settings' => $config->settings ?? []
        ]);
    }

    /**
     * Update bot configuration
     */
    public function updateConfig(TelegramConfigRequest $request): JsonResponse
    {
        $config = TelegramBotConfig::firstOrNew();
        
        $config->fill($request->validated());
        $config->save();

        return response()->json(['message' => 'Configuration updated successfully']);
    }

    /**
     * Setup webhook with Telegram
     */
    public function setupWebhook(Request $request): JsonResponse
    {
        try {
            $config = TelegramBotConfig::first();
            
            if (!$config || !$config->bot_token) {
                return response()->json(['error' => 'Bot token not configured'], 400);
            }

            $bot = new BotApi($config->bot_token);
            $webhookUrl = $config->webhook_url ?: url('/api/v5/telegram/webhook');
            
            $result = $bot->setWebhook($webhookUrl);
            
            if ($result) {
                $config->webhook_url = $webhookUrl;
                $config->save();
                
                return response()->json([
                    'message' => 'Webhook setup successfully',
                    'webhook_url' => $webhookUrl
                ]);
            }
            
            return response()->json(['error' => 'Failed to setup webhook'], 500);
        } catch (Exception $e) {
            Log::error('Telegram webhook setup error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to setup webhook: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get bot usage statistics
     */
    public function getStats(): JsonResponse
    {
        // TODO: Implement statistics collection
        return response()->json([
            'total_users' => 0,
            'total_conversations' => 0,
            'total_submissions' => 0,
            'active_conversations' => 0
        ]);
    }

    /**
     * Validate webhook request from Telegram
     */
    private function validateWebhook(Request $request): bool
    {
        // For now, just check if request comes from Telegram IP ranges
        // In production, you might want to implement more sophisticated validation
        $telegramIps = [
            '149.154.160.0/20',
            '91.108.4.0/22'
        ];

        $clientIp = $request->ip();
        
        foreach ($telegramIps as $range) {
            if ($this->ipInRange($clientIp, $range)) {
                return true;
            }
        }

        // Allow localhost for development
        return in_array($clientIp, ['127.0.0.1', '::1']);
    }

    /**
     * Check if IP is in range
     */
    private function ipInRange(string $ip, string $range): bool
    {
        list($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;
        return ($ip & $mask) == $subnet;
    }
}