<?php

namespace App\Providers;

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\StandardDebugBar;
use Fol\App;
use Interop\Container\ServiceProviderInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

class Logger implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'log' => function (App $app): MonologLogger {
                $log = new MonologLogger('app');
                $path = env('APP_DEV') ? $app->getPath('data/error.log') : $app->getPath('../logs/app.error');
                $log->pushHandler(new StreamHandler($path, MonologLogger::WARNING));

                return $log;
            },
            'log.csp' => function (App $app): MonologLogger {
                $log = new MonologLogger('app');
                $path = env('APP_DEV') ? $app->getPath('data/csp.log') : $app->getPath('../logs/csp.error');
                $log->pushHandler(new StreamHandler($path, MonologLogger::ERROR));

                return $log;
            },
            'debugbar' => function (App $app): StandardDebugBar {
                $bar = new StandardDebugBar();
                $bar->addCollector(new PDOCollector(new TraceablePDO($app->get('pdo'))));
                return $bar;
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
