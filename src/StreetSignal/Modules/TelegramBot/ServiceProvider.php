<?php

namespace StreetSignal\Modules\TelegramBot;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use StreetSignal\Modules\TelegramBot\Services\TelegramBotService;
use StreetSignal\Modules\TelegramBot\Services\ConversationManager;
use StreetSignal\Modules\TelegramBot\Services\AuthenticationManager;
use StreetSignal\Modules\TelegramBot\Services\FormFlowManager;
use StreetSignal\Modules\TelegramBot\Services\StreetSignalApiClient;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::prefix('api/v5')
            ->middleware('api')
            ->namespace('StreetSignal\Modules\TelegramBot\Http\Controllers')
            ->group(__DIR__ . '/routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConversationManager::class);
        $this->app->singleton(AuthenticationManager::class);
        $this->app->singleton(FormFlowManager::class);
        $this->app->singleton(StreetSignalApiClient::class);
        
        $this->app->singleton(TelegramBotService::class, function ($app) {
            return new TelegramBotService(
                config('telegram.bot_token'),
                $app->make(ConversationManager::class),
                $app->make(AuthenticationManager::class),
                $app->make(FormFlowManager::class)
            );
        });
    }
}