<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Tag extends Controller
{
    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $tag = $db->tag
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$tag) {
            return Factory::createResponse(404);
        }

        $artworks = $db->artwork
            ->select()
            ->relatedWith($tag)
            ->orderBy('RAND()')
            ->limit(6)
            ->run();

        $artists = $db->artist
            ->select()
            ->relatedWith($tag)
            ->orderBy('RAND()')
            ->limit(8)
            ->run();

        $reportages = $db->reportage
            ->select()
            ->relatedWith($tag)
            ->run();

        return $this->app->get('templates')->render(
            'pages/tag-permalink',
            compact('tag', 'artworks', 'reportages', 'artists')
        );
    }
}
