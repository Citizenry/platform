<?php

/**
 * Telegram Bot API routes
 */

$router->group([
    'prefix' => 'telegram',
], function () use ($router) {
    // Webhook endpoint for Telegram
    $router->post('/webhook', 'TelegramBotController@webhook');
    
    // Admin endpoints for bot management
    $router->group([
        'middleware' => ['auth:api', 'scope:config'],
    ], function () use ($router) {
        $router->get('/config', 'TelegramBotController@getConfig');
        $router->put('/config', 'TelegramBotController@updateConfig');
        $router->post('/setup', 'TelegramBotController@setupWebhook');
        $router->get('/stats', 'TelegramBotController@getStats');
    });
});