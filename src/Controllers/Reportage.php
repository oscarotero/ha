<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Reportage extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');
        $query = $request->getQueryParams();

        $reportagesQuery = $db->reportage
            ->select()
            ->orderBy('publishedAt DESC')
            ->page($query['page'] ?? 1, 24);

        $tag = $author = null;

        if (!empty($query['tag'])) {
            $tag = $db->tag->select()
                ->one()
                ->by('slug', $query['tag'])
                ->run();

            if ($tag) {
                $reportagesQuery->relatedWith($tag);
            }
        }

        if (!empty($query['author'])) {
            $author = $db->author->select()
                ->one()
                ->by('id', $query['author'])
                ->run();

            if ($author) {
                $reportagesQuery->relatedWith($author);
            }
        }

        $reportages = $reportagesQuery->run();

        if ($request->getHeaderLine('Accept') === 'application/rss+xml') {
            return $this->app->get('templates')->render(
                'pages/reportage-search.rss',
                compact('reportages', 'tag', 'author')
            );
        }

        return $this->app->get('templates')->render(
            'pages/reportage-search',
            compact('reportages', 'tag', 'author')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $reportage = $db->reportage
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$reportage) {
            return Factory::createResponse(404);
        }

        return $this->app->get('templates')->render(
            'pages/reportage-permalink',
            compact('reportage')
        );
    }

    public function rrss(Request $request)
    {
        $db = $this->app->get('db');

        $reportages = $db->reportage
            ->select()
            ->orderBy('publishedAt DESC')
            ->limit(6)
            ->run();

        if ($request->getHeaderLine('Accept') === 'application/rss+xml') {
            return $this->app->get('templates')->render('pages/reportage-rrss.rss', [
                'reportages' => $reportages,
                'rrss' => $request->getAttribute('rrss'),
            ]);
        }
    }
}
