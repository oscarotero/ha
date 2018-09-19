<?php

namespace App\Controllers;

use App\Forms;
use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Artist extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');
        $query = $request->getQueryParams();

        if (!empty($query) || $request->getHeaderLine('Accept') === 'application/rss+xml') {
            $form = Forms::artist($this->app);
            $form->loadFromPsr7($request);
            $data = $form->val();

            $artistsQuery = $db->artist
                ->select()
                ->where('artist.imageFile IS NOT NULL')
                ->page($query['page'] ?? 1, 24);

            if (!empty($data['movement'])) {
                $movement = $db->movement->select()
                    ->one()
                    ->by('slug', $data['movement'])
                    ->run();

                if ($movement) {
                    $artistsQuery->relatedWith($movement);
                }
            }

            if (!empty($data['country'])) {
                $country = $db->country->select()
                    ->one()
                    ->by('slug', $data['country'])
                    ->run();

                if ($country) {
                    $artistsQuery->relatedWith($country);
                }
            }

            if (!empty($data['tag'])) {
                $tag = $db->tag->select()
                    ->one()
                    ->by('slug', $data['tag'])
                    ->run();

                if ($tag) {
                    $artistsQuery->relatedWith($tag);
                }
            }

            if (!empty($data['author'])) {
                $author = $db->author->select()
                    ->one()
                    ->by('slug', $data['author'])
                    ->run();

                if ($author) {
                    $artistsQuery->relatedWith($author);
                }
            }

            switch ($data['life']) {
                case '1':
                    $artistsQuery->where('artist.yearDead IS NULL');
                    break;
                case 'year':
                    if (!empty($data['year'])) {
                        $artistsQuery->where(
                            'artist.yearBorn <= :year AND artist.yearDead >= :year',
                            [':year' => $data['year']]
                        );
                    }
                    break;
            }

            switch ($data['order']) {
                case 'alphabetic':
                    $artistsQuery
                        ->orderBy('surname')
                        ->orderBy('name');
                    break;
                case 'olderst':
                    $artistsQuery
                        ->orderBy('yearBorn')
                        ->orderBy('yearDead');
                    break;
                case 'youngest':
                    $artistsQuery
                        ->orderBy('yearBorn', 'DESC')
                        ->orderBy('yearDead', 'DESC');
                    break;
                default:
                    $artistsQuery->orderBy('id', 'DESC');
                    break;
            }

            $artists = $artistsQuery->run();

            if ($request->getHeaderLine('Accept') === 'application/rss+xml') {
                return $this->app->get('templates')->render(
                    'pages/artist-search.rss',
                    compact('artists')
                );
            }

            return $this->app->get('templates')->render(
                'pages/artist-search',
                compact('artists', 'form')
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
            if (strpos($page->label, '/artistas/') !== 0 || strpos($page->label, '/ - ') !== false) {
                continue;
            }

            $trending[substr($page->label, 10)] = [
                'hits' => $page->nb_hits,
            ];
        }

        $artists = $db->artist->select()
            ->by('slug', array_keys($trending))
            ->run();

        foreach ($artists as $artist) {
            $trending[$artist->slug]['row'] = $artist;
        }

        $trending = array_slice($trending, 0, 12);

        return $this->app->get('templates')->render(
            'pages/artist-search',
            compact('trending')
        );
    }

    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $artist = $db->artist
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$artist) {
            return Factory::createResponse(404);
        }

        $related = null;

        if ($artist->movement->count()) {
            $related = $db->artist
                ->select()
                ->where('artist.id != :id', [':id' => $artist->id])
                ->relatedWith($artist->movement)
                ->limit(6)
                ->orderBy('RAND()')
                ->run();
        }

        if ((!$related || !$related->count()) && $artist->tag->count()) {
            $related = $db->artist
                ->select()
                ->where('artist.id != :id', [':id' => $artist->id])
                ->relatedWith($artist->tag)
                ->limit(6)
                ->orderBy('RAND()')
                ->run();
        }

        if ((!$related || !$related->count()) && $artist->country) {
            $related = $db->artist
                ->select()
                ->where('artist.id != :id', [':id' => $artist->id])
                ->relatedWith($artist->country)
                ->limit(6)
                ->orderBy('RAND()')
                ->run();
        }

        return $this->app->get('templates')->render(
            'pages/artist-permalink',
            compact('artist', 'related')
        );
    }
}
