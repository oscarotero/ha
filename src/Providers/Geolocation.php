<?php

namespace App\Providers;

use Fol\App;
use Geocoder\Geocoder;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Geocoder\StatefulGeocoder;
use Http\Adapter\Guzzle6\Client;
use Interop\Container\ServiceProviderInterface;

class Geolocation implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'geocoder' => function (App $app): Geocoder {
                $provider = new GoogleMaps(new Client(), null, env('APP_GOOGLE_KEY'));

                return new StatefulGeocoder($provider);
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
