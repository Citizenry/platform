# OAuth Configuration and Health Check

This document outlines the process for configuring and validating OAuth credentials in the platform.

## Environment-Based Configuration

The OAuth client ID and secret are configured via environment variables. This approach enhances security by keeping sensitive credentials out of version control.

- `OAUTH_CLIENT_ID`: The client ID for the OAuth application.
- `OAUTH_CLIENT_SECRET`: The client secret for the OAuth application.

These variables should be set in your `.env` file:

```
OAUTH_CLIENT_ID=your-client-id
OAUTH_CLIENT_SECRET=your-client-secret
```

## Database Migration

A database migration is used to ensure the `client_secret` in the `api_keys` table matches the value in the environment. The migration hashes the `OAUTH_CLIENT_SECRET` using `sha1()` before storing it.

To run the migration:

```bash
vendor/robmorgan/phinx/bin/phinx migrate
```

## Health Check Endpoint

A health check endpoint is available to validate the OAuth configuration. This endpoint verifies that the environment variables are set and that the credentials match the values in the database.

- **URL**: `/api/health/oauth`
- **Method**: `GET`

### Success Response

```json
{
  "status": "ok",
  "message": "OAuth credentials are valid."
}
```

### Error Responses

**Missing Environment Variables:**

```json
{
  "status": "error",
  "message": "OAuth client ID or secret is not configured in the environment."
}
```

**Client Not Found:**

```json
{
  "status": "error",
  "message": "OAuth client with ID 'your-client-id' not found in the database."
}
```

**Secret Mismatch:**

```json
{
  "status": "error",
  "message": "OAuth client secret mismatch between environment and database."
}
```

## Troubleshooting

If the health check fails, follow these steps:

1.  **Verify `.env` file**: Ensure that `OAUTH_CLIENT_ID` and `OAUTH_CLIENT_SECRET` are correctly set in your `.env` file.
2.  **Check Database Connection**: Confirm that the application can connect to the database. If you are running the database in Docker, ensure that `DB_HOST` and `DB_PORT` are correctly configured.
3.  **Run Migrations**: Run the Phinx migrations to update the database with the latest credentials.