<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\ServerRequest as Request;

class Text extends Controller
{
    public function permalink(Request $request)
    {
        $db = $this->app->get('db');

        $text = $db->text
            ->select()
            ->one()
            ->by('slug', $request->getAttribute('slug'))
            ->run();

        if (!$text) {
            return Factory::createResponse(404);
        }

        $texts = $db->text
            ->select()
            ->where('isActivated = 1')
            ->orderBy('position', 'ASC')
            ->run();

        return $this->app->get('templates')->render(
            'pages/text-permalink',
            compact('text', 'texts')
        );
    }
}
