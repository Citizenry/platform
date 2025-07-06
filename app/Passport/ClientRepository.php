<?php

namespace App\Passport;

use Laravel\Passport\ClientRepository as PassportClientRepository;

class ClientRepository extends PassportClientRepository
{
    /**
     * Validate a client's secret.
     *
     * This custom implementation validates against a plain-text secret
     * using a constant-time string comparison.
     *
     * @param  string  $clientId
     * @param  string  $clientSecret
     * @return bool
     */
    public function validateSecret($clientId, $clientSecret)
    {
        if (! $client = $this->find($clientId)) {
            return false;
        }

        // Use hash_equals for constant-time comparison to prevent timing attacks
        return hash_equals($client->secret, $clientSecret);
    }
}