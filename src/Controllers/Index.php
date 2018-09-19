<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Index extends Controller
{
    public function index(Request $request)
    {
        $db = $this->app->get('db');

        $config = $this->app->get('config');

        if (!empty($config->weekend) && date('N') >= $config->weekend_day) {
            $artwork = $db->artwork
                ->select()
                ->one()
                ->orderBy('RAND()')
                ->run();
            $reportage = null;
        } else {
            $artwork = $db->artwork
                ->select()
                ->one()
                ->orderBy('publishedAt DESC')
                ->run();

            $reportage = $db->reportage
                ->select()
                ->one()
                ->orderBy('publishedAt DESC')
                ->where('publishedAt > :date', [':date' => $artwork->publishedAt->format('Y-m-d H:i:s')])
                ->run();
        }

        $artworksQuery = $db->artwork
            ->select()
            ->orderBy('publishedAt DESC')
            ->limit(8);

        if ($reportage) {
            $artwork = null;
        } else {
            $artworksQuery->where('id != :id', [':id' => $artwork->id]);
        }

        $artworks = $artworksQuery->run();

        $ephemeris = $db->ephemeris
            ->select()
            ->one()
            ->where('isActivated = 1')
            ->where('month = :month', [':month' => date('m')])
            ->where('day = :day', [':day' => date('d')])
            ->where('(year IS NULL) OR (year = :year)', [':year' => date('Y')])
            ->orderBy('RAND()')
            ->run();

        return $this->app->get('templates')->render(
            'pages/index',
            compact('artwork', 'reportage', 'artworks', 'ephemeris')
        );
    }

    public function lostConnection(Request $request)
    {
        echo $this->app->get('templates')->render('pages/lost-connection');

        return Factory::createResponse(200)->withHeader('Content-Type', 'text/html');
    }
}
