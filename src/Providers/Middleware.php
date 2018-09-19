<?php

namespace App\Providers;

use App\Admin;
use App\Controllers;
use Fol\App;
use Interop\Container\ServiceProviderInterface;
use Middleland\Dispatcher;
use Middlewares;
use Neomerx\Cors\Analyzer;
use Neomerx\Cors\Strategies\Settings;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Zend\Diactoros\Uri;

class Middleware implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'middleware' => function (App $app): Dispatcher {
                $requestHandlerContainer = new Middlewares\Utils\RequestHandlerContainer([$app]);

                $middleware = [];

                $middleware[] = new Middlewares\ContentLength();

                $middleware[] = (new Middlewares\JsonPayload())
                    ->contentType([
                        'application/csp-report',
                        'application/json',
                    ]);

                $middleware[] = new Middlewares\BasePath($app->getUri()->getPath());

                $middleware[] = ['/admin', new Middlewares\DigestAuthentication([
                    env('APP_ADMIN_AUTH_USERNAME') => env('APP_ADMIN_AUTH_PASSWORD'),
                ])];

                $middleware[] = ['/admin', 'admin'];

                $middleware[] = (new Middlewares\TrailingSlash())->redirect();
                $middleware[] = new Middlewares\Cors($app->get('cors.config'));
                $middleware[] = (new Middlewares\ReportingLogger($app->get('log.csp')))->path('/scp-report');

                if (!env('APP_DEV')) {
                    $middleware[] = Middlewares\Csp::createFromData($app->get('csp.config'));
                }

                if (env('APP_DEV')) {
                    $middleware[] = new Middlewares\Whoops();
                //$middleware[] = new Middlewares\Debugbar($app->get('debugbar'));
                } else {
                    $middleware[] = (new Middlewares\ErrorHandler(
                        $requestHandlerContainer->get(Controllers\Error::class)
                    ))->catchExceptions(true);
                }

                if (!env('APP_DEV')) {
                    $middleware[] = new Middlewares\Cache($app->get('cache.http'));
                } else {
                    $middleware[] = new Middlewares\CachePrevention();
                }

                $middleware[] = new Middlewares\Expires();

                if (env('APP_DEV')) {
                    $middleware[] = new Middlewares\Robots(false);
                } else {
                    $middleware[] = (new Middlewares\Robots(true))->sitemap('https://historia-arte.com/sitemap_index.xml');
                }

                $middleware[] = new Middlewares\ContentType();

                //Gardar as imaxes
                if (!env('APP_DEV') || env('APP_LOCAL')) {
                    if (!env('APP_DEV')) {
                        $middleware[] = ['/_', function ($request, $next) use ($app) {
                            $response = $next->handle($request);

                            if ($response->getStatusCode() === 200) {
                                $optimizerChain = OptimizerChainFactory::create();
                                $pathToImage = $app->getPath('public', $request->getUri()->getPath());
                                $optimizerChain->optimize($pathToImage);
                            }

                            return $response;
                        }];

                        $middleware[] = ['/_', Middlewares\Writer::createFromDirectory($app->getPath('public'))];
                    }

                    $middleware[] = new Middlewares\ImageManipulation(env('APP_KEY'));
                    $middleware[] = Middlewares\Reader::createFromDirectory($app->getPath('data/uploads'))->continueOnError();
                } else {
                    $middleware[] = ['/_', new Middlewares\Proxy(new Uri('https://historia-arte.com'))];
                }

                $middleware[] = new Middlewares\AuraRouter($app->get('router'));
                $middleware[] = new Middlewares\RequestHandler($requestHandlerContainer);

                return new Dispatcher($middleware, $app);
            },
            'admin' => function (App $app): \Closure {
                return function ($request, $next) use ($app) {
                    $admin = new Admin($app->getUri('admin'), $app);
                    return $admin->handle($request);
                };
            },
            'cors.config' => function (App $app): Analyzer {
                $settings = new Settings();
                $settings->setServerOrigin([
                    'scheme' => $app->getUri()->getScheme(),
                    'port' => $app->getUri()->getPort(),
                    'host' => $app->getUri()->getHost(),
                ]);

                return Analyzer::instance($settings);
            },
            'csp.config' => function (App $app): array {
                return [
                    'report-uri' => '/csp-report',
                    'script-src' => [
                        'self' => true,
                        'allow' => [
                            'https://analytics.historia-arte.com',
                            'https://maps.googleapis.com',
                        ],
                    ],
                    'connect-src' => [
                        'self' => true,
                        'allow' => [
                            'http://localhost:3000',
                        ],
                    ],
                    'object-src' => ['self' => true],
                    'frame-ancestors' => ['self' => true],
                ];
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
