<?php

namespace App\Providers;

use Fol\App;
use Interop\Container\ServiceProviderInterface;
use PDO;
use SimpleCrud\Fields\File;
use SimpleCrud\Fields\Slug;
use SimpleCrud\SimpleCrud;

class Database implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'pdo' => function (App $app): PDO {
                return new PDO(env('APP_DB_DSN'), env('APP_DB_USERNAME'), env('APP_DB_PASSWORD'));
            },

            'db' => function (App $app): SimpleCrud {
                $db = new SimpleCrud($app->get('pdo'));

                File::register($db);
                Slug::register($db);

                $db->getTableFactory()
                    ->addNamespace('App\\Models\\');

                $db->getFieldFactory()
                    ->addNamespace('App\\Models\\Fields\\')
                    ->mapNames([
                        'body' => 'Serializable',
                        'images' => 'Serializable',
                        'links' => 'Serializable',
                        'referrers' => 'Serializable',
                    ]);

                $db->setAttribute(File::ATTR_DIRECTORY, $app->getPath('data/uploads'));
                $db->setAttribute('app', $app);

                if ($app->has('cache.db') && !env('APP_DEV')) {
                    $cache = $app->get('cache.db')->getItem('db_scheme');

                    if ($cache->isHit()) {
                        $db->setScheme($cache->get());
                    } else {
                        $cache->set($db->getScheme());
                        $app->get('cache.db')->save($cache);
                    }
                }

                return $db;
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
