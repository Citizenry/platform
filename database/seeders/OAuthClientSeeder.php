<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if a client with this name already exists
        $existingClient = Client::where('name', 'StreetSignal Web Client')->first();
        
        if ($existingClient) {
            $this->command->info('OAuth Client already exists:');
            $this->command->info('Client ID: ' . $existingClient->id);
            $this->command->info('Client Name: ' . $existingClient->name);
            $this->command->info('');
            $this->command->warn('IMPORTANT: Use these credentials for your frontend configuration!');
            return;
        }

        // Generate a UUID and secret that we'll use
        $clientId = Str::uuid()->toString();
        $clientSecret = Str::random(40);
        
        // Hash the secret for storage (Laravel Passport v11 expects hashed secrets)
        $hashedSecret = password_hash($clientSecret, PASSWORD_DEFAULT);
        
        // Create the client directly in the database using raw SQL to avoid model issues
        \DB::table('oauth_clients')->insert([
            'id' => $clientId,
            'user_id' => null,
            'name' => 'StreetSignal Web Client',
            'secret' => $hashedSecret, // Store hashed secret
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
        $this->command->info('Client Secret: ' . $clientSecret);
        $this->command->info('');
        $this->command->warn('IMPORTANT: Save these credentials for your frontend configuration!');
    }
}