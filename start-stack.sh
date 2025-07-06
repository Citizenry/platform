#!/bin/bash

# StreetSignal Platform Docker Stack Startup Script

set -e

echo "🚀 Starting StreetSignal Platform Stack..."

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker first."
    exit 1
fi

# Check if frontend directory exists
FRONTEND_PATH="/home/jascha/Documents/Citizenry/platform-client-mzima"
if [ ! -d "$FRONTEND_PATH" ]; then
    echo "❌ Frontend directory not found at: $FRONTEND_PATH"
    echo "Please ensure the platform-client-mzima repository is cloned to the expected location."
    exit 1
fi

echo "✅ Prerequisites check passed"

# Pull latest images
echo "📦 Pulling latest Docker images..."
docker compose pull

# Build services
echo "🔨 Building services..."
docker compose build

# Start services
echo "🏃 Starting services..."
docker compose up -d

# Wait for services to be healthy
echo "⏳ Waiting for services to be ready..."

# Function to check service health
check_service_health() {
    local service=$1
    local max_attempts=30
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if docker compose ps $service | grep -q "healthy\|Up"; then
            echo "✅ $service is ready"
            return 0
        fi
        echo "⏳ Waiting for $service... (attempt $attempt/$max_attempts)"
        sleep 5
        attempt=$((attempt + 1))
    done
    
    echo "❌ $service failed to become ready"
    return 1
}

# Check each service
check_service_health "mysql"
check_service_health "redis"

# Wait a bit more for migration to complete
echo "⏳ Waiting for database migration to complete..."
sleep 10

check_service_health "platform"
check_service_health "frontend"

echo ""
echo "🎉 StreetSignal Platform Stack is ready!"
echo ""
echo "📍 Access URLs:"
echo "   Frontend:  http://localhost:3000"
echo "   Backend:   http://localhost:8081"
echo "   API Docs:  http://localhost:8081/api/v3"
echo ""
echo "🗄️  Database:"
echo "   Host:      localhost:33061"
echo "   Database:  streetsignal"
echo "   Username:  streetsignal"
echo "   Password:  streetsignal"
echo ""
echo "📋 Useful commands:"
echo "   View logs:     docker compose logs -f"
echo "   Stop stack:    docker compose down"
echo "   Restart:       docker compose restart"
echo ""
echo "📖 For more information, see docker compose.README.md"