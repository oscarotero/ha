<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Movement extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');

        $groups = $db->movementGroup
            ->select()
            ->run();

        $groups->movement;

        return $this->app->get('templates')->render(
            'pages/movement-search',
            compact('groups')
        );
    }

    public function timeline(Request $request)
    {
        $db = $this->app->get('db');

        $movements = $db->movement->select()->orderBy('yearStart')->run();

        return $this->app->get('templates')->render(
            'pages/movement-timeline',
            compact('movements')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $movement = $db->movement
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$movement) {
            return Factory::createResponse(404);
        }

        $artworks = $db->artwork
            ->select()
            ->relatedWith($movement)
            ->orderBy('RAND()')
            ->limit(6)
            ->run();

        $artists = $db->artist
            ->select()
            ->relatedWith($movement)
            ->orderBy('RAND()')
            ->limit(8)
            ->run();

        $movements = $db->movement
            ->select()
            ->relatedWith($movement->movementGroup)
            ->where('id != :id', [':id' => $movement->id])
            ->orderBy('name')
            ->run();

        return $this->app->get('templates')->render(
            'pages/movement-permalink',
            compact('movement', 'artworks', 'artists', 'movements')
        );
    }
}
