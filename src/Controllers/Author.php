<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Author extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');

        $authors = $db->author->select()->orderBy('name')->run();

        return $this->app->get('templates')->render(
            'pages/author-search',
            compact('authors')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $author = $db->author
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$author) {
            return Factory::createResponse(404);
        }

        $artworks = $db->artwork
            ->select()
            ->relatedWith($author)
            ->orderBy('RAND()')
            ->limit(6)
            ->run();

        $reportages = $db->reportage
            ->select()
            ->relatedWith($author)
            ->orderBy('reportage.id', 'DESC')
            ->run();

        $artists = $db->artist
            ->select()
            ->relatedWith($author)
            ->orderBy('RAND()')
            ->limit(8)
            ->run();

        return $this->app->get('templates')->render(
            'pages/author-permalink',
            compact('author', 'artworks', 'reportages', 'artists')
        );
    }
}
