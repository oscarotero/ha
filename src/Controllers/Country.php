<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Country extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');

        $countries = $db->country
            ->select()
            ->run();

        return $this->app->get('templates')->render(
            'pages/country-search',
            compact('countries')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $country = $db->country
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$country) {
            return Factory::createResponse(404);
        }

        $artworks = $db->artwork
            ->select()
            ->relatedWith($country)
            ->orderBy('RAND()')
            ->limit(6)
            ->run();

        $artists = $db->artist
            ->select()
            ->relatedWith($country)
            ->orderBy('RAND()')
            ->limit(6)
            ->run();

        return $this->app->get('templates')->render(
            'pages/country-permalink',
            compact('country', 'artworks', 'artists')
        );
    }
}
