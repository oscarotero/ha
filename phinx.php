<?php

require 'bootstrap.php';

$app = new App\App();

return [
    'paths' => [
        'migrations' => __DIR__.'/db/migrations',
        'seeds' => __DIR__.'/db/seeds',
    ],

    'environments' => [
        'default_database' => 'development',
        'development' => [
            'name' => $app->get('pdo')->query('SELECT DATABASE()')->fetch()[0],
            'connection' => $app->get('pdo'),
        ],
    ],
];
