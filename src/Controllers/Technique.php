<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Technique extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');

        $techniques = $db->technique
            ->select()
            ->run();

        return $this->app->get('templates')->render(
            'pages/technique-search',
            compact('techniques')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $technique = $db->technique
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$technique) {
            return Factory::createResponse(404);
        }

        $artworks = $db->artwork
            ->select()
            ->relatedWith($technique)
            ->orderBy('RAND()')
            ->limit(6)
            ->run();

        return $this->app->get('templates')->render(
            'pages/technique-permalink',
            compact('technique', 'artworks')
        );
    }
}
