<?php

namespace App\Providers;

use Fol\App;
use Interop\Container\ServiceProviderInterface;
use League\Plates\Engine;
use Middlewares\ImageManipulation;

class Templates implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'templates' => function (App $app): Engine {
                $templates = new Engine($app->getPath('templates'));

                $templates->registerFunction('url', function ($name, array $attributes = []) use ($app) {
                    return $app->getRoute($name, $attributes);
                });

                $templates->registerFunction('asset', function (string ...$dirs) use ($app) {
                    $cache = '/';

                    if (
                        APP_BUILD_ID !== 'NO_BUILD_ID' &&
                        (strpos($dirs[0], 'js/') === 0 || strpos($dirs[0], 'css/') === 0)
                    ) {
                        $cache = APP_BUILD_ID;
                    }

                    return (string) $app->getUri($cache, ...$dirs);
                });

                $templates->registerFunction('month', function ($date) {
                    $meses = [
                        'enero',
                        'febrero',
                        'marzo',
                        'abril',
                        'mayo',
                        'junio',
                        'julio',
                        'agosto',
                        'septiembre',
                        'octubre',
                        'noviembre',
                        'diciembre',
                    ];

                    return $meses[$date->format('m') - 1];
                });

                $templates->registerFunction('img', function ($file, $transform) use ($app) {
                    if (!$file) {
                        return;
                    }

                    $path = ImageManipulation::getUri($file, $transform, env('APP_KEY'));
                    return $app->getUri($path);
                });

                $templates->registerFunction('query', function ($page, $form) {
                    $query = $form->val();
                    unset($query['']);
                    $query['page'] = $page;

                    return $query ? '?'.http_build_query($query) : '';
                });

                return $templates;
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
