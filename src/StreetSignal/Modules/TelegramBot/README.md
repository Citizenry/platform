# StreetSignal Telegram Bot Module

This module provides Telegram bot integration for the StreetSignal platform, allowing users to submit reports through Telegram conversations.

## Features

- **Report Submission**: Users can submit reports through guided conversations
- **Hybrid Authentication**: Supports both anonymous and authenticated submissions
- **Multi-step Forms**: Handles complex form flows with validation
- **Media Upload**: Supports photo and file uploads from Telegram
- **Account Linking**: OAuth-based account linking for authenticated users
- **Rate Limiting**: Built-in protection against spam and abuse
- **Session Management**: Persistent conversation state management

## Architecture

The module follows Laravel's modular architecture pattern with the following components:

### Services
- [`TelegramBotService`](Services/TelegramBotService.php) - Main bot orchestration
- [`ConversationManager`](Services/ConversationManager.php) - Session state management
- [`AuthenticationManager`](Services/AuthenticationManager.php) - Account linking/unlinking
- [`FormFlowManager`](Services/FormFlowManager.php) - Multi-step form handling
- [`StreetSignalApiClient`](Services/StreetSignalApiClient.php) - Internal API communication

### Models
- [`TelegramBotConfig`](Models/TelegramBotConfig.php) - Bot configuration settings
- [`TelegramBotUser`](Models/TelegramBotUser.php) - Telegram user profiles
- [`TelegramConversation`](Models/TelegramConversation.php) - Conversation state

### Controllers
- [`TelegramBotController`](Http/Controllers/TelegramBotController.php) - Webhook and admin endpoints

## Installation

1. **Install Dependencies**
   ```bash
   composer require telegram-bot/api:^2.3
   ```

2. **Register Service Provider**
   Add to `config/app.php`:
   ```php
   StreetSignal\Modules\TelegramBot\ServiceProvider::class,
   ```

3. **Run Migrations**
   ```bash
   php artisan migrate
   ```

4. **Configure Environment**
   Add to `.env`:
   ```env
   TELEGRAM_BOT_TOKEN=your_bot_token_here
   TELEGRAM_WEBHOOK_URL=https://yourdomain.com/api/v5/telegram/webhook
   TELEGRAM_WEBHOOK_SECRET=your_webhook_secret
   TELEGRAM_SERVICE_TOKEN=your_service_api_token
   ```

## Configuration

The module uses [`config/telegram.php`](../../../config/telegram.php) for configuration. Key settings include:

- **Bot Token**: Telegram bot authentication token
- **Webhook Settings**: URL and security configuration
- **Rate Limits**: Message and report submission limits
- **File Upload**: Size limits and allowed file types
- **Session Management**: Timeout and cleanup settings

## Database Schema

### telegram_bot_config
Stores bot configuration settings (singleton table).

### telegram_bot_users
Maps Telegram users to StreetSignal accounts with OAuth tokens.

### telegram_conversations
Maintains conversation state for multi-step interactions.

## API Endpoints

### Webhook
- `POST /api/v5/telegram/webhook` - Receives updates from Telegram

### Admin (Protected)
- `GET /api/v5/telegram/config` - Get bot configuration
- `PUT /api/v5/telegram/config` - Update bot configuration
- `GET /api/v5/telegram/users` - List bot users
- `GET /api/v5/telegram/stats` - Get usage statistics

## Bot Commands

- `/start` - Initialize bot interaction
- `/help` - Show available commands
- `/report` - Start report submission
- `/link` - Link StreetSignal account
- `/unlink` - Unlink account
- `/status` - Check account status
- `/myreports` - View recent reports
- `/cancel` - Cancel current operation

## Conversation Flow

1. **User Interaction**: User sends message or command
2. **User Resolution**: Find or create TelegramBotUser record
3. **State Management**: Load conversation state
4. **Command/Message Processing**: Route to appropriate handler
5. **Response Generation**: Send reply to user
6. **State Update**: Persist conversation changes

## Authentication Flow

### Account Linking
1. User sends `/link` command
2. Bot generates unique linking token
3. User visits web URL with token
4. User authenticates via OAuth
5. Token exchanged for access token
6. Account linked in database

### Submission Modes
- **Anonymous**: Uses service token for API calls
- **Authenticated**: Uses user's OAuth token

## Development

### Testing
```bash
# Run unit tests
php artisan test --filter=TelegramBot

# Test webhook locally with ngrok
ngrok http 8000
# Update TELEGRAM_WEBHOOK_URL in .env
```

### Debugging
Enable debug mode in `config/telegram.php`:
```php
'development' => [
    'debug_mode' => true,
    'test_chat_id' => 'your_test_chat_id',
],
```

## Security Considerations

- **Webhook Verification**: Validates Telegram webhook signatures
- **Rate Limiting**: Prevents abuse and spam
- **Token Security**: OAuth tokens encrypted in database
- **Input Validation**: All user input validated and sanitized
- **File Upload Security**: File type and size restrictions

## Monitoring

The module logs important events:
- User interactions and commands
- Report submissions
- Authentication events
- Errors and exceptions

Monitor logs for:
- High error rates
- Unusual usage patterns
- Failed authentication attempts
- Rate limit violations

## Troubleshooting

### Common Issues

1. **Webhook Not Receiving Updates**
   - Verify webhook URL is accessible
   - Check webhook secret configuration
   - Ensure SSL certificate is valid

2. **Authentication Failures**
   - Verify service token is valid
   - Check OAuth configuration
   - Ensure API endpoints are accessible

3. **File Upload Issues**
   - Check file size limits
   - Verify storage disk configuration
   - Ensure temp directory is writable

### Debug Commands
```bash
# Check bot configuration
php artisan tinker
>>> TelegramBotConfig::first()

# Test API connectivity
>>> app(StreetSignalApiClient::class)->checkHealth()

# Clear expired conversations
>>> app(ConversationManager::class)->cleanupExpiredConversations()
```

## Contributing

When contributing to this module:

1. Follow PSR-12 coding standards
2. Add unit tests for new functionality
3. Update documentation for API changes
4. Test with actual Telegram bot before submitting
5. Consider security implications of changes

## License

This module is part of the StreetSignal platform and follows the same licensing terms.