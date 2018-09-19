<?php

namespace App\Controllers;

use App\Forms;
use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Artwork extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');
        $query = $request->getQueryParams();

        if (!empty($query) || $request->getHeaderLine('Accept') === 'application/rss+xml') {
            $form = Forms::artwork($this->app);
            $form->loadFromPsr7($request);
            $data = $form->val();

            $artworksQuery = $db->artwork
                ->select()
                ->page($query['page'] ?? 1, 24);

            if (!empty($data['tag'])) {
                $tag = $db->tag->select()
                    ->one()
                    ->by('slug', $data['tag'])
                    ->run();

                if ($tag) {
                    $artworksQuery->relatedWith($tag);
                }
            }

            if (!empty($data['country'])) {
                $country = $db->country->select()
                    ->one()
                    ->by('slug', $data['country'])
                    ->run();

                if ($country) {
                    $artworksQuery->relatedWith($country);
                }
            }

            if (!empty($data['technique'])) {
                $technique = $db->technique->select()
                    ->one()
                    ->by('slug', $data['technique'])
                    ->run();

                if ($technique) {
                    $artworksQuery->relatedWith($technique);
                }
            }

            if (!empty($data['museum'])) {
                $museum = $db->museum->select()
                    ->one()
                    ->by('slug', $data['museum'])
                    ->run();

                if ($museum) {
                    $artworksQuery->relatedWith($museum);
                }
            }

            if (!empty($data['author'])) {
                $author = $db->author->select()
                    ->one()
                    ->by('slug', $data['author'])
                    ->run();

                if ($author) {
                    $artworksQuery->relatedWith($author);
                }
            }

            if (!empty($data['movement'])) {
                $movement = $db->movement->select()
                    ->one()
                    ->by('slug', $data['movement'])
                    ->run();

                if ($movement) {
                    $artworksQuery->relatedWith($movement);
                }
            }

            switch ($data['age']) {
                case 'olderst':
                    $artworksQuery->where('artwork.year < 1500');
                    break;
                case 'decade':
                    if (!empty($data['decade'])) {
                        $artworksQuery->where('artwork.year >= :from AND artwork.year < :to', [
                            ':from' => $data['decade'],
                            ':to' => $data['decade'] + 10,
                        ]);
                    }
                    break;
            }

            switch ($data['order']) {
                case 'alphabetic':
                    $artworksQuery->orderBy('title');
                    break;
                case 'olderst':
                    $artworksQuery->orderBy('year');
                    break;
                case 'youngest':
                    $artworksQuery->orderBy('year', 'DESC');
                    break;
                default:
                    $artworksQuery->orderBy('id', 'DESC');
                    break;
            }

            $artworks = $artworksQuery->run();

            if ($request->getHeaderLine('Accept') === 'application/rss+xml') {
                return $this->app->get('templates')->render(
                    'pages/artwork-search.rss',
                    compact('artworks')
                );
            }

            return $this->app->get('templates')->render(
                'pages/artwork-search',
                compact('artworks', 'form')
            );
        }

        $trending = [];

        $url = 'https://analytics.historia-arte.com/index.php?'.http_build_query([
            'date' => 'yesterday',
            'flat' => 1,
            'filter_limit' => 100,
            'format' => 'JSON',
            'idSite' => 1,
            'method' => 'Actions.getPageUrls',
            'module' => 'API',
            'period' => 'day',
            'token_auth' => '07d167f5576b72b3b29daf158c65426d',
        ]);

        $content = json_decode(file_get_contents($url));

        foreach ($content as $page) {
            if (strpos($page->label, '/obras/') !== 0 || strpos($page->label, '/ - ') !== false) {
                continue;
            }

            $trending[substr($page->label, 7)] = [
                'hits' => $page->nb_hits,
            ];
        }

        $artworks = $db->artwork->select()
            ->by('slug', array_keys($trending))
            ->run();

        foreach ($artworks as $artwork) {
            $trending[$artwork->slug]['row'] = $artwork;
        }

        $trending = array_slice($trending, 0, 6);

        return $this->app->get('templates')->render(
            'pages/artwork-search',
            compact('trending')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $artwork = $db->artwork
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$artwork) {
            return Factory::createResponse(404);
        }

        $ids = [$artwork->id];
        $limit = 8;
        $related = [];

        foreach ($artwork->artist as $artist) {
            if (count($related) >= $limit) {
                break;
            }

            $rel = $db->artwork
                ->select()
                ->where('artwork.id NOT IN (:ids)', [':ids' => $ids])
                ->relatedWith($artist)
                ->limit($limit - count($related))
                ->run();

            $related = array_merge($related, $rel->toArray(false));
            $ids = array_unique(array_merge($ids, $rel->id));
        }

        foreach ($artwork->tag as $tag) {
            if (count($related) >= $limit) {
                break;
            }

            $rel = $db->artwork
                ->select()
                ->where('artwork.id NOT IN (:ids)', [':ids' => $ids])
                ->relatedWith($tag)
                ->limit($limit - count($related))
                ->run();

            $related = array_merge($related, $rel->toArray(false));
            $ids = array_unique(array_merge($ids, $rel->id));
        }

        if (count($related) < $limit && $artwork->movement->count() && (string) $artwork->country) {
            $rel = $db->artwork
                ->select()
                ->where('artwork.id NOT IN (:ids)', [':ids' => $ids])
                ->relatedWith($artwork->movement)
                ->relatedWith($artwork->country)
                ->limit($limit - count($related))
                ->run();

            $related = array_merge($related, $rel->toArray(false));
            $ids = array_unique(array_merge($ids, $rel->id));
        }

        return $this->app->get('templates')->render(
            'pages/artwork-permalink',
            compact('artwork', 'related')
        );
    }

    public function rrss(Request $request)
    {
        $db = $this->app->get('db');

        $artworks = $db->artwork
            ->select()
            ->orderBy('publishedAt DESC')
            ->limit(6)
            ->run();

        if ($request->getHeaderLine('Accept') === 'application/rss+xml') {
            return $this->app->get('templates')->render('pages/artwork-rrss.rss', [
                'artworks' => $artworks,
                'rrss' => $request->getAttribute('rrss'),
            ]);
        }
    }
}
