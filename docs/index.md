---
layout: home

hero:
  name: "StreetSignal Platform"
  text: "Crisis Mapping & Crowdsourcing Platform"
  tagline: "Empowering communities through real-time crisis information sharing"
  image:
    src: /logo-hz.png
    alt: StreetSignal Logo
  actions:
    - theme: brand
      text: View on GitHub
      link: https://github.com/streetsignal/platform

features:
  - title: Real-time Crisis Mapping
    details: Interactive maps for tracking and visualizing crisis events as they unfold
  - title: Crowdsourced Data
    details: Community-driven information gathering and verification
  - title: Multi-platform Support
    details: Web, mobile, and API access for maximum reach and accessibility
  - title: Scalable Architecture
    details: Built with Laravel backend and modern frontend technologies
---

# StreetSignal Platform Documentation

Welcome to the comprehensive documentation for the StreetSignal Platform - a powerful crisis mapping and crowdsourcing solution designed to help communities share and access critical information during emergencies.

## What is StreetSignal?

StreetSignal is an open-source platform that enables real-time crisis mapping and information sharing. It combines the power of crowdsourcing with modern web technologies to create a reliable system for emergency response and community coordination.

## Key Features

- **Interactive Crisis Maps**: Real-time visualization of crisis events and resources
- **Community Reporting**: Easy-to-use interfaces for citizens to report incidents
- **Data Verification**: Built-in systems for validating and moderating user-submitted content
- **Multi-channel Access**: Web application, mobile apps, and API endpoints
- **Scalable Infrastructure**: Designed to handle high traffic during crisis situations

## Technology Stack

- **Backend**: Laravel (PHP)
- **Frontend**: Angular with TypeScript
- **Database**: MySQL/PostgreSQL
- **Containerization**: Docker
- **Documentation**: VitePress

## Getting Started

### Quick Start with Docker

```bash
# Clone the repository
git clone https://github.com/streetsignal/platform.git
cd platform

# Start with Docker
make start
```

### Manual Installation

```bash
# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start the development server
php artisan serve
```

## Contributing

StreetSignal is an open-source project and we welcome contributions from the community. Please see our GitHub repository for contribution guidelines.

## License

This project is licensed under the AGPL-3.0 License. See the LICENSE file for details.

## Support

For questions, issues, or contributions, please visit our [GitHub repository](https://github.com/streetsignal/platform) or contact the development team.