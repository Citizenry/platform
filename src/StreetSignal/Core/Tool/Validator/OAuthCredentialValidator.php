<?php

namespace StreetSignal\Core\Tool\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OAuthCredentialValidator
{
    public function validate()
    {
        $clientId = env('OAUTH_CLIENT_ID');
        $clientSecret = env('OAUTH_CLIENT_SECRET');

        if (empty($clientId) || empty($clientSecret)) {
            return [
                'status' => 'error',
                'message' => 'OAuth client ID or secret is not configured in the environment.',
            ];
        }

        $client = DB::table('oauth_clients')->where('id', $clientId)->first();

        if (!$client) {
            return [
                'status' => 'error',
                'message' => "OAuth client with ID '{$clientId}' not found in the database.",
            ];
        }

        if ($clientSecret !== $client->secret) {
            return [
                'status' => 'error',
                'message' => 'OAuth client secret mismatch between environment and database.',
            ];
        }

        return [
            'status' => 'ok',
            'message' => 'OAuth credentials are valid.',
        ];
    }
}