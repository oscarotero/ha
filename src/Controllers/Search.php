<?php

namespace App\Controllers;

use App\Forms;
use Zend\Diactoros\ServerRequest as Request;

class Search extends Controller
{
    public function search(Request $request)
    {
        $db = $this->app->get('db');
        $form = Forms::search();
        $form->loadFromPsr7($request);
        $term = $form['q']->val();

        if (strlen($term) < 3) {
            if ($request->getHeaderLine('Accept') === 'application/json') {
                return json_encode([]);
            }

            return $this->app->get('templates')->render(
                'pages/search',
                ['isEmpty' => true, 'term' => $term]
            );
        }

        $artworks = $db->artwork->select()
            ->where('title LIKE :search OR originalTitle LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        if ($artworks->count()) {
            $artworks->artist;
        }

        $movements = $db->movement->select()
            ->where('name LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        $countries = $db->country->select()
            ->where('name LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        $techniques = $db->technique->select()
            ->where('name LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        $artists = $db->artist->select()
            ->where('name LIKE :search OR surname LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        $reportages = $db->reportage->select()
            ->where('title LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        $museums = $db->museum->select()
            ->leftJoin('city')
            ->where('museum.name LIKE :search OR city.name LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        $tags = $db->tag->select()
            ->where('name LIKE :search', [':search' => '%'.$term.'%'])
            ->limit(10)
            ->run();

        if ($request->getHeaderLine('Accept') === 'application/json') {
            return $this->app->get('templates')->render(
                'pages/search.json',
                compact('artists', 'reportages', 'artworks', 'movements', 'techniques', 'tags', 'term', 'countries', 'museums')
            );
        }

        return $this->app->get('templates')->render(
            'pages/search',
            compact('artists', 'reportages', 'artworks', 'movements', 'techniques', 'tags', 'term', 'countries', 'museums')
        );
    }
}
