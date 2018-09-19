<?php
require dirname(__DIR__).'/bootstrap.php';

if (php_sapi_name() === 'cli-server' && $file = Server::run(__DIR__)) {
    return false;
}

define('APP_BUILD_ID', 'NO_BUILD_ID');

//Execute the app
App\App::run();
