<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Museum extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');

        $countries = $db->country->select()->orderBy('name')->run();

        return $this->app->get('templates')->render(
            'pages/museum-search',
            compact('countries')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $museum = $db->museum
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$museum) {
            return Factory::createResponse(404);
        }

        $artworks = $db->artwork
            ->select()
            ->relatedWith($museum)
            ->run();

        $museums = $museum->city
            ->museum()
            ->where('id != :id', [':id' => $museum->id])
            ->orderBy('name')
            ->run();

        return $this->app->get('templates')->render(
            'pages/museum-permalink',
            compact('museum', 'artworks', 'museums')
        );
    }
}
