<?php

namespace App\Providers;

use Illuminate\Auth\RequestGuard;
use Laravel\Passport\TokenRepository;
use App\Passport\TokenGuard;
use League\OAuth2\Server\ResourceServer;
use StreetSignal\Contracts\Repository\Entity\UserRepository;
use Laravel\Passport\ClientRepository as LaravelPassportClientRepository;
use Laravel\Passport\Bridge\UserRepository as LaravelPassportUserRepository;
use Laravel\Passport\PassportServiceProvider as LaravelPassportServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository as LaravelPassportRefreshTokenRepository;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Route;

class PassportServiceProvider extends LaravelPassportServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        

        $this->app->bind(
            LaravelPassportClientRepository::class,
            \App\Passport\ClientRepository::class
        );

        $this->app->bind(
            \League\OAuth2\Server\Repositories\ClientRepositoryInterface::class,
            \App\Passport\ClientRepository::class
        );

        $this->app->bind(
            LaravelPassportUserRepository::class,
            \App\Passport\UserRepository::class
        );

        $this->app->bind(
            LaravelPassportRefreshTokenRepository::class,
            \App\Passport\RefreshTokenRepository::class
        );
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array  $config
     * @return RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new RequestGuard(function ($request) use ($config) {
            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                $this->app->make(UserRepository::class),
                // Auth::createUserProvider($config['provider']),
                $this->app->make(TokenRepository::class),
                $this->app->make(\League\OAuth2\Server\Repositories\ClientRepositoryInterface::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }
}
