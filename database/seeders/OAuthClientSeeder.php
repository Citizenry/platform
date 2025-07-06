<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\DB;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use the exact client ID and secret that matches docker-compose.yml configuration
        $clientId = 'streetsignalui';
        $clientSecret = '138a6df73e70a5be36ebc2be60d4473d2b057182';
        
        // Hash the secret for storage (Laravel Passport v11 expects hashed secrets)
        $hashedSecret = password_hash($clientSecret, PASSWORD_DEFAULT);
        
        // Check if a client with this ID already exists
        $existingClient = DB::table('oauth_clients')->where('id', $clientId)->first();
        
        if ($existingClient) {
            // Update the existing client to ensure it has the correct configuration
            DB::table('oauth_clients')
                ->where('id', $clientId)
                ->update([
                    'name' => 'StreetSignal UI Client',
                    'secret' => $hashedSecret,
                    'redirect' => '',
                    'personal_access_client' => false,
                    'password_client' => true,
                    'revoked' => false,
                    'updated_at' => now(),
                ]);
            
            $this->command->info('OAuth Client updated:');
            $this->command->info('Client ID: ' . $clientId);
            $this->command->info('Client Name: StreetSignal UI Client');
            $this->command->info('');
            $this->command->info('Client credentials match docker-compose.yml configuration.');
            return;
        }

        // Create the client directly in the database
        DB::table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => null,
            'name' => 'StreetSignal UI Client',
            'secret' => $hashedSecret,
            'provider' => null,
            'redirect' => '',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('OAuth Client created:');
        $this->command->info('Client ID: ' . $clientId);
        $this->command->info('Client Name: StreetSignal UI Client');
        $this->command->info('');
        $this->command->info('Client credentials match docker-compose.yml configuration.');
        $this->command->warn('IMPORTANT: These credentials are configured for Docker development only!');
    }
}