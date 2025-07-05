<?php

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db_config = [
    'adapter' => 'mysql',
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
    'name' => getenv('DB_DATABASE'),
    'user' => getenv('DB_USERNAME'),
    'pass' => getenv('DB_PASSWORD'),
    'charset' => 'utf8mb4',
    'collation' => getenv('DB_COLLATION') ?: 'utf8mb4_unicode_520_ci'
];

if (getenv('DB_SOCKET')) {
    $db_config['unix_socket'] = getenv('DB_SOCKET');
}

return [
    'paths' => [
        'migrations' => __DIR__ . '/database/migrations/phinx',
        'seeds' => __DIR__ . '/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'ushahidi',
        'ushahidi' => $db_config,
    ]
];
