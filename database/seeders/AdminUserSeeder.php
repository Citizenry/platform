<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user if it doesn't exist
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'password' => Hash::make('admin'),
                'realname' => 'Administrator',
                'created' => now(),
                'updated' => now(),
            ]
        );

        $this->command->info('Admin user created/verified:');
        $this->command->info('Email: ' . $admin->email);
        $this->command->info('Password: admin');
        $this->command->info('');
        $this->command->warn('IMPORTANT: Change the default password in production!');
    }
}