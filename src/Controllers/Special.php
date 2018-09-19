<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Special extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');

        $specials = $db->special
            ->select()
            ->run();

        return $this->app->get('templates')->render(
            'pages/special-search',
            compact('specials')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $special = $db->special
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$special) {
            return Factory::createResponse(404);
        }

        $artworks = $db->artwork
            ->select()
            ->relatedWith($special)
            ->orderBy('artwork.publishedAt DESC')
            ->run();

        $reportages = $db->reportage
            ->select()
            ->relatedWith($special)
            ->orderBy('reportage.publishedAt DESC')
            ->run();

        $specials = $db->special
            ->select()
            ->where('id != :id', [':id' => $special->id])
            ->orderBy('startsAt DESC')
            ->run();

        return $this->app->get('templates')->render(
            'pages/special-permalink',
            compact('special', 'artworks', 'reportages', 'specials')
        );
    }
}
