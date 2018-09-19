<?php

namespace App\Providers;

use FlyCrud\Directory;
use FlyCrud\Document;
use FlyCrud\Formats\Serialize;
use Fol\App;
use Interop\Container\ServiceProviderInterface;

class Config implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'config' => function (App $app): Document {
                $dir = $app->get('data:Directory');
                $defaults = [
                    'weekend' => true,
                    'weekend_day' => 6,
                ];

                if ($dir->hasDocument('config')) {
                    $config = $dir->getDocument('config');

                    foreach ($defaults as $key => $value) {
                        if (!isset($config->$key)) {
                            $config->$key = $value;
                        }
                    }

                    return $config;
                }

                $config = new Document($defaults);

                $dir->saveDocument('config', $config);

                return $config;
            },
            'data:Directory' => function (App $app): Directory {
                return Directory::make($app->getPath('data'), new Serialize());
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
