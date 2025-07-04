<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Telegram Bot Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the StreetSignal Telegram Bot integration.
    | These settings control bot behavior, authentication, and API access.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Bot Token
    |--------------------------------------------------------------------------
    |
    | The bot token provided by BotFather when creating your Telegram bot.
    | This is required for the bot to authenticate with the Telegram API.
    |
    */
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the webhook that receives updates from Telegram.
    | The webhook URL should point to your application's webhook endpoint.
    |
    */
    'webhook' => [
        'url' => env('TELEGRAM_WEBHOOK_URL'),
        'secret' => env('TELEGRAM_WEBHOOK_SECRET'),
        'max_connections' => env('TELEGRAM_WEBHOOK_MAX_CONNECTIONS', 40),
        'allowed_updates' => [
            'message',
            'callback_query',
            'inline_query'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Token
    |--------------------------------------------------------------------------
    |
    | OAuth token for the service user account that will be used for
    | anonymous submissions. This should be a valid API token with
    | permissions to create posts.
    |
    */
    'service_token' => env('TELEGRAM_SERVICE_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Rate limiting settings to prevent abuse and ensure fair usage.
    | These limits apply per user per time period.
    |
    */
    'rate_limits' => [
        'messages_per_minute' => env('TELEGRAM_RATE_LIMIT_MESSAGES', 10),
        'reports_per_hour' => env('TELEGRAM_RATE_LIMIT_REPORTS', 5),
        'reports_per_day' => env('TELEGRAM_RATE_LIMIT_REPORTS_DAILY', 20),
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for user conversation sessions and state management.
    |
    */
    'session' => [
        'timeout_minutes' => env('TELEGRAM_SESSION_TIMEOUT', 30),
        'cleanup_interval_hours' => env('TELEGRAM_SESSION_CLEANUP_INTERVAL', 24),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for handling file uploads from Telegram users.
    |
    */
    'uploads' => [
        'max_file_size_mb' => env('TELEGRAM_MAX_FILE_SIZE', 10),
        'allowed_types' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'video/mp4',
            'video/quicktime',
            'audio/mpeg',
            'audio/ogg',
            'application/pdf'
        ],
        'storage_disk' => env('TELEGRAM_STORAGE_DISK', 'public'),
        'temp_directory' => 'telegram/temp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Bot Behavior
    |--------------------------------------------------------------------------
    |
    | Settings that control how the bot behaves and responds to users.
    |
    */
    'behavior' => [
        'anonymous_submissions_enabled' => env('TELEGRAM_ANONYMOUS_ENABLED', true),
        'require_location_for_reports' => env('TELEGRAM_REQUIRE_LOCATION', false),
        'auto_delete_temp_files' => env('TELEGRAM_AUTO_DELETE_TEMP', true),
        'send_typing_indicator' => env('TELEGRAM_SEND_TYPING', true),
        'max_message_length' => env('TELEGRAM_MAX_MESSAGE_LENGTH', 4096),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Messages
    |--------------------------------------------------------------------------
    |
    | Default messages that the bot will send to users. These can be
    | overridden in the database configuration.
    |
    */
    'messages' => [
        'welcome' => "👋 Welcome to StreetSignal!\n\nI can help you submit reports about issues in your community.\n\nUse /help to see available commands or /report to start submitting a report.",
        
        'help' => "🤖 StreetSignal Bot Commands:\n\n" .
                 "/start - Start using the bot\n" .
                 "/help - Show this help message\n" .
                 "/report - Submit a new report\n" .
                 "/link - Link your StreetSignal account\n" .
                 "/unlink - Unlink your account\n" .
                 "/status - Check your account status\n" .
                 "/myreports - View your recent reports\n" .
                 "/cancel - Cancel current operation\n\n" .
                 "You can also send me photos, locations, or text messages to start a report.",
        
        'error' => "❌ Something went wrong. Please try again later or contact support.",
        
        'rate_limited' => "⏰ You're sending messages too quickly. Please wait a moment and try again.",
        
        'maintenance' => "🔧 The bot is currently under maintenance. Please try again later.",
        
        'unauthorized' => "🔒 You need to link your StreetSignal account to use this feature. Use /link to get started.",
        
        'report_submitted' => "✅ Your report has been submitted successfully!\n\nThank you for helping improve your community.",
        
        'account_linked' => "🔗 Your StreetSignal account has been successfully linked!\n\nYou can now submit reports that will be associated with your account.",
        
        'account_unlinked' => "🔓 Your StreetSignal account has been unlinked.\n\nYou can still submit anonymous reports or link a different account using /link.",
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for logging bot activities and errors.
    |
    */
    'logging' => [
        'enabled' => env('TELEGRAM_LOGGING_ENABLED', true),
        'level' => env('TELEGRAM_LOG_LEVEL', 'info'),
        'log_user_messages' => env('TELEGRAM_LOG_USER_MESSAGES', false),
        'log_api_calls' => env('TELEGRAM_LOG_API_CALLS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Settings
    |--------------------------------------------------------------------------
    |
    | Settings that are useful during development and testing.
    |
    */
    'development' => [
        'debug_mode' => env('TELEGRAM_DEBUG_MODE', false),
        'test_chat_id' => env('TELEGRAM_TEST_CHAT_ID'),
        'mock_api_responses' => env('TELEGRAM_MOCK_API', false),
    ],
];