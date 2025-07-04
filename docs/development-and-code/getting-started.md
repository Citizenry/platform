# Development: Overview

## Overview

### What does StreetSignal Do? <a id="what-does-streetsignal-do"></a>

* StreetSignal is a tool for collecting, managing, and visualizing data.
* Data can be collected from anyone, anytime, anywhere by SMS, email, web, Twitter, RSS, and **Telegram**.
* Posts can be managed and triaged with filters and workflows.
* Data can be viewed in many ways: on a map, in a list, or as a visualization.

### Who is StreetSignal For? <a id="who-is-streetsignal-for"></a>

Anyone can use StreetSignal, but traditionally it has been a tool used by Crisis Responders, Human Rights Reporters, and Citizens & Governments \(such as election monitoring or corruption reporters\). We also serve environmental mappers, asset monitoring, citizen journalism, international development, and many others.

### Technical Specifications <a id="technical-specifications"></a>

**Current Development Stack (v5)**

* **Backend**: StreetSignal Platform is built on a modern PHP stack using Laravel 9.x
* **PHP Version**: 7.4 - 8.3 (8.2+ recommended for optimal performance)
* **Database**: MySQL 5.7+ or PostgreSQL 9.6+
* **Dependencies**: Managed with Composer
* **API**: RESTful API v5 with comprehensive endpoints
* **Authentication**: OAuth 2.0 via Laravel Passport
* **New Features**: Telegram Bot integration, enhanced security, improved performance

**Frontend Stack**

* The user interface is a separate application (platform-client-mzima) built with modern JavaScript frameworks
* **Framework**: Angular/React-based single-page application
* **Build Tools**: Modern build pipeline with Webpack and npm
* **Mapping**: Leaflet.js for interactive maps
* **Styling**: Component-based CSS architecture

**What's New and Improved?**

* **Laravel 9 Framework**: Modern, secure, and well-maintained framework
* **PHP 8.2+ Support**: Latest PHP features and performance improvements
* **Telegram Bot Integration**: Interactive chat-based report submission
* **Enhanced API**: Comprehensive v5 API with better documentation
* **Improved Security**: OAuth 2.0, rate limiting, and input validation
* **Better Testing**: Comprehensive test suite with PHPUnit and Behat
* **Docker Support**: Containerized development environment
* **Modern Dependencies**: Up-to-date libraries and security patches

#### Code is easier to customize

* **Modular Architecture**: Clean separation of concerns with Laravel's structure
* **Service-Oriented Design**: Business logic isolated in service classes
* **Repository Pattern**: Data access abstraction for easier testing and maintenance
* **Event-Driven**: Laravel events for extensible functionality
* **API-First**: Frontend and backend completely decoupled
* **Modern PHP**: Type hints, namespaces, and PSR standards

#### The Current Stack

**Backend Technologies:**
- **OS**: Linux (Ubuntu/Debian recommended)
- **Language**: PHP 7.4 - 8.3
- **Framework**: Laravel 9.x
- **Web Server**: Apache/Nginx
- **Database**: MySQL 5.7+ or PostgreSQL 9.6+
- **Cache**: Redis (recommended) or Memcached
- **Queue**: Redis, Database, or SQS
- **Search**: Elasticsearch (optional)

**Frontend Technologies:**
- **Framework**: Modern JavaScript (Angular/React)
- **Build Tools**: Webpack, npm/yarn
- **Mapping**: Leaflet.js
- **UI Components**: Component-based architecture
- **Styling**: SCSS/CSS modules

**Development Tools:**
- **Containerization**: Docker & Docker Compose
- **Testing**: PHPUnit, Behat, Jest
- **Code Quality**: PHP_CodeSniffer, ESLint
- **CI/CD**: GitHub Actions, Travis CI
- **Documentation**: API Blueprint, Swagger

**Data Sources:**
- **Web Interface**: Browser-based submission
- **SMS**: Multiple provider integrations
- **Email**: IMAP-based collection
- **Twitter**: API integration
- **RSS Feeds**: Automated aggregation
- **Telegram Bot**: Interactive chat interface *(NEW)*
- **API**: Direct programmatic access

#### Development Environment Setup

**Quick Start with Docker:**
```bash
# Clone repository
git clone https://github.com/streetsignal/platform.git
cd platform

# Start development environment
make start

# Backend will be available at localhost:8080
```

**Manual Setup:**
```bash
# Install dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan passport:install

# Start development server
php artisan serve
```

**Frontend Setup:**
```bash
# Clone frontend repository
git clone https://github.com/streetsignal/platform-client-mzima.git

# Follow frontend-specific setup instructions
