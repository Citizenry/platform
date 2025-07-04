# StreetSignal Platform Changelog

## [Latest] - 2025-01-07

### 🚀 Major Features

#### Telegram Bot Integration
- **NEW**: Complete Telegram bot module for interactive report submission
- Multi-step form flows with validation
- Media upload support (photos, files)
- OAuth-based account linking
- Rate limiting and spam protection
- Session management for conversation state
- Both anonymous and authenticated submission modes

### 🔧 Technical Improvements

#### PHP 8.2+ Compatibility
- Updated to support PHP 8.2 and 8.3
- Fixed `json_decode` TypeError in ConfigRepository
- Fixed foreach null argument errors in Post formatter
- Updated `willdurand/negotiation` to ^3.1 for PHP 8.2 compatibility
- Added `ohanzee/database` dependency

#### Laravel 9 Upgrade
- Upgraded from Laravel 8 to Laravel 9.x
- Enhanced security features
- Improved performance and caching
- Better dependency management
- Modern middleware and routing

#### Infrastructure Updates
- Docker configuration improvements
- Enhanced development environment setup
- Better error handling and logging
- Improved test infrastructure

### 🔒 Security Enhancements
- OAuth 2.0 authentication via Laravel Passport
- Enhanced input validation and sanitization
- Rate limiting for API endpoints
- Secure file upload handling
- Webhook signature verification for Telegram

### 📚 Documentation Updates
- Updated main README.md with current features
- Enhanced developer documentation
- Added Telegram Bot module documentation
- Updated getting started guide
- Improved API documentation

### 🛠️ Developer Experience
- Modern PHP features and type hints
- Comprehensive test suite with PHPUnit and Behat
- Code quality tools (PHP_CodeSniffer, PHPSpec)
- Docker-based development environment
- Improved debugging and logging

### 📊 API Improvements
- Enhanced API v5 with new endpoints
- Telegram Bot API integration
- Better error responses and status codes
- Improved rate limiting
- Enhanced authentication flows

### 🗃️ Database Changes
- New tables for Telegram Bot functionality:
  - `telegram_bot_config` - Bot configuration settings
  - `telegram_bot_users` - User account mappings
  - `telegram_conversations` - Conversation state management
- Migration improvements and cleanup
- Better indexing for performance

### 🔄 Data Sources
- **NEW**: Telegram Bot integration
- Enhanced SMS provider support
- Improved email processing
- Better Twitter API integration
- RSS feed improvements
- Web interface enhancements

### 🧪 Testing
- Expanded test coverage
- Unit tests for new Telegram Bot module
- Integration tests for API endpoints
- Behat scenarios for user workflows
- Performance testing improvements

### 📱 Frontend Compatibility
- Updated API endpoints for frontend integration
- Better error handling for client applications
- Enhanced authentication flows
- Improved media upload handling

## Previous Versions

### [v4.x] - Legacy
- Kohana-based architecture
- Basic API functionality
- Original data source integrations

### [v3.x] - Legacy
- Initial StreetSignal platform
- Basic mapping and visualization
- Core data collection features

---

## Migration Notes

### From v4.x to v5.x
1. **PHP Version**: Upgrade to PHP 8.2+ recommended
2. **Laravel**: Major framework upgrade to Laravel 9
3. **Dependencies**: Run `composer update` to update all packages
4. **Database**: Run migrations for new Telegram Bot tables
5. **Configuration**: Update `.env` file with new Telegram Bot settings
6. **API**: Review API v5 changes for any breaking changes

### New Environment Variables
```env
# Telegram Bot Configuration
TELEGRAM_BOT_TOKEN=your_bot_token_here
TELEGRAM_WEBHOOK_URL=https://yourdomain.com/api/v5/telegram/webhook
TELEGRAM_WEBHOOK_SECRET=your_webhook_secret
TELEGRAM_SERVICE_TOKEN=your_service_api_token
```

## Support

For questions about these changes or migration assistance:
- Check the [Developer Documentation](docs/development-and-code/getting-started.md)
- Review the [Telegram Bot Documentation](src/StreetSignal/Modules/TelegramBot/README.md)
- Open an issue on [GitHub](https://github.com/streetsignal/platform/issues)
- Join our [community chat](https://gitter.im/streetsignal/Community)