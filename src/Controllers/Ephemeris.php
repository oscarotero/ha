<?php

namespace App\Controllers;

use Zend\Diactoros\ServerRequest as Request;

class Ephemeris extends Controller
{
    public function rss(Request $request)
    {
        $db = $this->app->get('db');

        $ephemerises = $db->ephemeris
            ->select()
            ->where('isActivated = 1')
            ->where('month = :month', [':month' => date('m')])
            ->where('day = :day', [':day' => date('d')])
            ->where('(year IS NULL) OR (year = :year)', [':year' => date('Y')])
            ->run();

        return $this->app->get('templates')->render(
            'pages/ephemeris.rss',
            compact('ephemerises')
        );
    }
}
