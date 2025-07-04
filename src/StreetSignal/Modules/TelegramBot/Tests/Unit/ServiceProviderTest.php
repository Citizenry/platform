<?php

namespace StreetSignal\Modules\TelegramBot\Tests\Unit;

use Tests\TestCase;
use StreetSignal\Modules\TelegramBot\ServiceProvider;
use StreetSignal\Modules\TelegramBot\Services\TelegramBotService;
use StreetSignal\Modules\TelegramBot\Services\ConversationManager;
use StreetSignal\Modules\TelegramBot\Services\AuthenticationManager;
use StreetSignal\Modules\TelegramBot\Services\FormFlowManager;
use StreetSignal\Modules\TelegramBot\Services\StreetSignalApiClient;

class ServiceProviderTest extends TestCase
{
    public function test_service_provider_is_registered()
    {
        $this->assertTrue($this->app->providerIsLoaded(ServiceProvider::class));
    }

    public function test_services_are_bound_in_container()
    {
        $this->assertTrue($this->app->bound(TelegramBotService::class));
        $this->assertTrue($this->app->bound(ConversationManager::class));
        $this->assertTrue($this->app->bound(AuthenticationManager::class));
        $this->assertTrue($this->app->bound(FormFlowManager::class));
        $this->assertTrue($this->app->bound(StreetSignalApiClient::class));
    }

    public function test_services_are_singletons()
    {
        $service1 = $this->app->make(TelegramBotService::class);
        $service2 = $this->app->make(TelegramBotService::class);
        
        $this->assertSame($service1, $service2);
    }

    public function test_config_is_published()
    {
        $this->assertNotNull(config('telegram'));
        $this->assertIsArray(config('telegram'));
    }
}