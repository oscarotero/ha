<?php

namespace App\Providers;

use Fol\App;
use Interop\Container\ServiceProviderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Stash\Driver\FileSystem;
use Stash\Driver\Redis;
use Stash\Pool;

class Cache implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'cache.http' => function (App $app): CacheItemPoolInterface {
                //$driver = new Redis(['prefix_key' => 'ha.http']);
                $driver = new FileSystem([
                    'path' => $app->getPath('data/cache'),
                ]);

                return new Pool($driver);
            },
            'cache.db' => function (App $app): CacheItemPoolInterface {
                $driver = new FileSystem([
                    'path' => $app->getPath('data/cache'),
                    'prefix_key' => 'ha.db',
                ]);

                return new Pool($driver);
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
