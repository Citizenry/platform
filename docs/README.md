# StreetSignal Platform

[![Build Status](https://travis-ci.org/streetsignal/platform.png)](https://travis-ci.org/streetsignal/platform) [![Coverage Status](https://coveralls.io/repos/github/streetsignal/platform/badge.svg)](https://coveralls.io/github/streetsignal/platform) [![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

![StreetSignal Logo](streetsignal-logo.png)

## What is StreetSignal?

StreetSignal is an open source web application for information collection, visualization and interactive mapping. It helps you to collect info from: SMS, Twitter, RSS feeds, Email, and **Telegram**. It helps you to process that information, categorize it, geo-locate it and publish it on a map.

## Platform Updates

### Latest Features
- **Telegram Bot Integration**: Submit reports through interactive Telegram conversations
- **PHP 8.2+ Support**: Enhanced performance and modern PHP compatibility
- **Laravel 9**: Upgraded framework for better security and features
- **Enhanced API**: Improved v5 API with new endpoints

### Technical Improvements
- Modern dependency management
- Enhanced security features
- Better error handling and logging
- Improved test coverage

## Required reading: Code of Conduct.

We love having you here. To ensure everyone has a good experience, we ask **everyone** that interacts with our community and staff to read our code of conduct.

{% content-ref url="code-of-conduct/" %}
[code-of-conduct](code-of-conduct/)
{% endcontent-ref %}



If you are not a developer, or just don't want to set it up yourself, you can start a hosted deployment [here](https://www.streetsignal.com/pricing).

If you want to install and host the StreetSignal Platform yourself, check out one of our Setup Guides

{% content-ref url="development-and-code/setup_alternatives/" %}
[setup\_alternatives](development-and-code/setup\_alternatives/)
{% endcontent-ref %}

If you are a developer and want to install and customise the code, read through the Development & Code and Front-End Development sections:

{% content-ref url="development-and-code/getting-started.md" %}
[getting-started.md](development-and-code/getting-started.md)
{% endcontent-ref %}

{% content-ref url="front-end-development/changing-ui-styles-introduction-to-the-pattern-library/" %}
[changing-ui-styles-introduction-to-the-pattern-library](front-end-development/changing-ui-styles-introduction-to-the-pattern-library/)
{% endcontent-ref %}

## Data Collection Methods

StreetSignal supports multiple ways to collect information:

- **Web Interface**: Browser-based report submission
- **Mobile Apps**: iOS and Android applications
- **SMS**: Text message integration
- **Email**: Email-to-report conversion
- **Twitter**: Social media monitoring
- **RSS Feeds**: Automated content aggregation
- **Telegram Bot**: Interactive chat-based reporting *(NEW)*
- **API**: Direct programmatic access

## System Requirements

- **PHP**: 7.4 - 8.3 (8.2+ recommended)
- **Laravel**: 9.x
- **Database**: MySQL 5.7+ or PostgreSQL 9.6+
- **Web Server**: Apache or Nginx
- **Memory**: 512MB minimum, 2GB recommended
- **Storage**: 1GB minimum for basic installation

### A note for grassroots organizations

If you are starting a deployment for a grassroots organization, you can apply for a free social-impact responder account [here](https://www.streetsignal.com/pricing/apply-for-free) after verifying that you meet the criteria.

## Getting Involved

Check out how you can get involved and contribute to our work:

{% content-ref url="contributing-or-getting-involved/" %}
[contributing-or-getting-involved](contributing-or-getting-involved/)
{% endcontent-ref %}

## Development Resources

### Quick Start
```bash
# Clone the repository
git clone https://github.com/streetsignal/platform.git

# Start with Docker
make start

# Or install dependencies manually
composer install
npm install
```

### Testing
```bash
# Run all tests
composer test

# Run specific test suites
composer unit
composer behat
```

### API Documentation
- **API v5**: Current version with full feature support
- **Telegram Bot API**: New integration endpoints
- **Legacy API v3**: Maintenance mode only

## Useful Links

* [User Documentation](https://www.streetsignal.com/support)
* [StreetSignal.com](https://www.streetsignal.com)
* [StreetSignal Platform v2](https://github.com/streetsignal/StreetSignal\_Web)
* [StreetSignal on Github](https://github.com/streetsignal)
* [Platform Client (Frontend)](https://github.com/streetsignal/platform-client-mzima)
* [Telegram Bot Documentation](../src/StreetSignal/Modules/TelegramBot/README.md)
