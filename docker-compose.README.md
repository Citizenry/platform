# Docker Compose Setup for StreetSignal Platform

This Docker Compose configuration provides a complete development environment for the StreetSignal Platform including the backend API and frontend web client.

## Services

- **mysql**: MariaDB 10.11 database server
- **redis**: Redis cache and queue backend
- **migration**: One-time service that runs database migrations and seeds
- **platform**: Main Laravel API backend with nginx and PHP-FPM
- **platform_tasks**: Background task processor and queue worker
- **frontend**: Angular-based web client (Mzima)

## Quick Start

1. **Prerequisites**:
   - Docker and Docker Compose installed
   - Frontend client code available at `/home/jascha/Documents/Citizenry/platform-client-mzima`

2. **Start the stack**:
   ```bash
   docker compose up -d
   ```

3. **Access the application**:
   - Frontend: http://localhost:3000
   - Backend API: http://localhost:8081
   - Database: localhost:33061 (user: streetsignal, password: streetsignal)

4. **Default Admin Login**:
   - Email: `admin@example.com`
   - Password: `admin`
   - **Important**: Change these credentials in production!

## Service Details

### Database (mysql)
- **Image**: mariadb:10.11
- **Port**: 33061 (external) → 3306 (internal)
- **Database**: streetsignal
- **Credentials**: streetsignal/streetsignal
- **Features**: 
  - Persistent data storage
  - Health checks
  - UTF8MB4 character set

### Cache & Queue (redis)
- **Image**: redis:7.2-alpine
- **Purpose**: Caching and queue backend
- **Features**: Health checks

### Migration Service
- **Purpose**: One-time database setup
- **Actions**:
  - Runs Phinx migrations (`php artisan phinx:migrate`)
  - Seeds database (`php artisan db:seed`)
- **Dependencies**: Waits for mysql and redis to be healthy

### Platform API (platform)
- **Port**: 8081 (external) → 8080 (internal)
- **Features**:
  - Laravel API backend
  - Nginx web server
  - PHP-FPM process manager
  - Health checks on `/api/v3/config`
- **Dependencies**: Waits for migration to complete

### Background Tasks (platform_tasks)
- **Purpose**: Queue processing and scheduled tasks
- **Features**:
  - Queue listener
  - 30-second task execution period
- **Dependencies**: Waits for migration to complete

### Frontend Web Client (frontend)
- **Port**: 3000 (external) → 8080 (internal)
- **Technology**: Angular with Ionic
- **Build**: Development build for faster compilation
- **Dependencies**: Waits for platform API to be healthy

## Environment Variables

Key environment variables are pre-configured for development:

```bash
# Database
DB_HOST=mysql
DB_DATABASE=streetsignal
DB_USERNAME=streetsignal
DB_PASSWORD=streetsignal

# Cache & Queue
REDIS_HOST=redis
CACHE_DRIVER=redis
QUEUE_DRIVER=redis

# OAuth (Frontend Configuration)
OAUTH_CLIENT_ID=streetsignalui
OAUTH_CLIENT_SECRET=138a6df73e70a5be36ebc2be60d4473d2b057182

# API URLs (Frontend Configuration)
API_URL=http://localhost:8081
BACKEND_URL=http://localhost:8081
```

## Development Workflow

### Starting Services
```bash
# Start all services
docker compose up -d

# View logs
docker compose logs -f

# View specific service logs
docker compose logs -f platform
docker compose logs -f frontend
```

### Database Operations
```bash
# Run additional migrations
docker compose exec platform php artisan phinx:migrate

# Seed database again
docker compose exec platform php artisan db:seed

# Access database directly
docker compose exec mysql mysql -u streetsignal -pstreetsignal streetsignal
```

### Development Commands
```bash
# Access platform container
docker compose exec platform bash

# Run Laravel commands
docker compose exec platform php artisan config:cache
docker compose exec platform php artisan route:list

# Restart specific services
docker-compose restart platform
docker-compose restart frontend
```

### Stopping Services
```bash
# Stop all services
docker compose down

# Stop and remove volumes (WARNING: deletes database data)
docker compose down -v
```

## Troubleshooting

### Service Health Checks
All services include health checks. Check service status:
```bash
docker-compose ps
```

### Common Issues

1. **Migration fails**: Ensure mysql is fully started before migration runs
2. **Frontend can't connect to API**: Check that platform service is healthy
3. **Permission issues**: Check file permissions in mounted volumes
4. **Authentication fails (401 Unauthorized)**:
   - Verify admin user exists: `docker compose exec platform php artisan tinker --execute="echo App\User::where('email', 'admin@example.com')->exists() ? 'User exists' : 'User missing';"`
   - Check OAuth client: `docker compose exec platform php artisan tinker --execute="echo Laravel\Passport\Client::where('id', 'streetsignalui')->exists() ? 'Client exists' : 'Client missing';"`
   - Re-run seeders if needed: `docker compose exec platform php artisan db:seed --force`

### Logs
```bash
# All services
docker compose logs

# Specific service
docker compose logs platform
docker compose logs frontend
docker compose logs mysql
```

## Production Considerations

For production deployment:

1. **Security**:
   - Change default passwords
   - Use environment files for secrets
   - Enable SSL/TLS

2. **Performance**:
   - Use production build for frontend (`web:build`)
   - Configure proper resource limits
   - Use external database and cache services

3. **Monitoring**:
   - Add monitoring and logging services
   - Configure health check endpoints
   - Set up alerting

## File Structure

```
.
├── docker-compose.yml          # Main compose configuration
├── docker-compose.README.md    # This documentation
├── Dockerfile                  # Platform API container
├── docker/                     # Docker configuration files
└── /home/jascha/Documents/Citizenry/platform-client-mzima/
    ├── Dockerfile              # Frontend container
    └── docker-compose.yml      # Frontend-specific compose