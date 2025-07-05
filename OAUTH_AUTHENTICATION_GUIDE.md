# OAuth2 Authentication Configuration Guide

## Overview
This document outlines the working OAuth2 authentication configuration for the StreetSignal platform after resolving the `401 Unauthorized` error.

## Working Configuration

### Client Credentials
- **Client ID**: `af64b571-69ee-42c7-a579-036f70329595`
- **Client Secret**: `0ry4kV5vfVjaub1LI9yTUD6wqqTaQznvzCBlUfZn`
- **Grant Type**: `password`

### User Credentials
- **Username**: `admin@example.com`
- **Password**: `admin`

### API Endpoint
- **URL**: `http://localhost:8081/oauth/token`
- **Method**: `POST`
- **Content-Type**: `application/json`

## Example Request

```bash
curl -X POST http://localhost:8081/oauth/token \
  -H "Content-Type: application/json" \
  -d '{
    "grant_type": "password",
    "client_id": "af64b571-69ee-42c7-a579-036f70329595",
    "client_secret": "0ry4kV5vfVjaub1LI9yTUD6wqqTaQznvzCBlUfZn",
    "username": "admin@example.com",
    "password": "admin"
  }'
```

## Expected Response

```json
{
  "token_type": "Bearer",
  "expires_in": 31536000,
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
  "refresh_token": "def50200..."
}
```

## Technical Implementation

### Custom ClientRepository
The application uses a custom `ClientRepository` located at:
- **File**: `/var/www/app/Passport/ClientRepository.php`
- **Purpose**: Handles plain-text client secret validation using `hash_equals()`
- **Key Method**: `validateSecret()` - performs secure plain-text comparison

### Laravel Passport Configuration
- **Secret Hashing**: Disabled (`Passport::hashClientSecrets(false)`)
- **Client Type**: Password grant client
- **Secret Storage**: Plain-text in database

## Troubleshooting

### Common Issues
1. **Wrong client credentials**: Ensure exact UUID and secret match
2. **Wrong user credentials**: Use `admin@example.com` not just `admin`
3. **Database connectivity**: Verify `oauth_clients` table exists and is accessible

### Debug Steps
1. Verify client exists: `Laravel\Passport\Client::find('af64b571-69ee-42c7-a579-036f70329595')`
2. Check user exists: `App\User::where('email', 'admin@example.com')->first()`
3. Test database connection: `DB::table('oauth_clients')->count()`

## Resolution Summary
The original `401 Unauthorized` error was resolved by:
1. Using correct client credentials (UUID format, not shortened)
2. Using correct user email format (`admin@example.com`)
3. Confirming custom `ClientRepository` handles plain-text validation correctly

The custom repository was already properly implemented and working - the issue was incorrect credentials in test requests.