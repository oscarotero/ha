<?php

namespace App\Controllers;

use Middlewares\Utils\Factory;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest as Request;

class Error extends Controller
{
    public function __invoke(Request $request)
    {
        $error = $request->getAttribute('error');

        if ($error->getCode() === 404) {
            return $this->error404($request);
        }

        if ($error->getCode() === 500) {
            return $this->error500($request);
        }

        echo 'Error '.$error->getCode();
        echo $error;

        return Factory::createResponse($error->getCode())->withHeader('Content-Type', 'text/html');
    }

    private function error404(Request $request)
    {
        $url = self::fixUrl((string) $request->getUri());

        $referrer = $request->getHeaderLine('Referer');

        $db = $this->app->get('db');

        $redirect = $db->redirect
            ->select()
            ->one()
            ->by('from', $url)
            ->run();

        if (!env('APP_DEV')) {
            if ($redirect) {
                if ($referrer) {
                    $found = array_filter((array) $redirect->referrers, function ($val) use ($referrer) {
                        return $val['url'] === $referrer;
                    });

                    if (!$found) {
                        $referrers = $redirect->referrers ?: [];
                        $referrers[] = ['url' => $referrer];
                        $redirect->referrers;
                        $redirect->save();
                    }
                }

                if ($redirect->to) {
                    return new RedirectResponse($redirect->to, 301);
                }
            } elseif (
                   !preg_match('|\.jpg$|', $url)
                && !preg_match('|\.jpeg$|', $url)
                && !preg_match('|\.css$|', $url)
                && !preg_match('|\.png$|', $url)
                && !preg_match('|\.php$|', $url)
                && !preg_match('|\.js$|', $url)
                && !preg_match('|\.gif$|', $url)
                && !preg_match('|/feed$|', $url)
                && !preg_match('|/embed$|', $url)
            ) {
                $db->redirect[] = [
                    'from' => $url,
                    'referrers' => $referrer ? [['url' => $referrer]] : [],
                ];
            }
        }

        echo $this->app->get('templates')->render('pages/404');

        return Factory::createResponse(404)->withHeader('Content-Type', 'text/html');
    }

    private function error500(Request $request)
    {
        $this->app->get('log')->error('Error 500 in '.$request->getUri(), [
            'error' => $request->getAttribute('error'),
        ]);

        echo $this->app->get('templates')->render('pages/500');

        return Factory::createResponse(500)->withHeader('Content-Type', 'text/html');
    }

    private static function fixUrl($url)
    {
        $url = explode('?', $url, 2);
        $url = $url[0];

        $url = preg_replace('#(/page/\d+)$#', '', $url);
        $url = preg_replace('#/feed$#', '', $url);

        return $url;
    }
}
