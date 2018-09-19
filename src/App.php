<?php

namespace App;

use Fol;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;

class App extends Fol\App
{
    /**
     * Run the app.
     */
    public static function run()
    {
        $app = new static();

        $request = ServerRequestFactory::fromGlobals();
        $response = $app->dispatch($request, new Response());

        (new SapiEmitter())->emit($response);
    }

    /**
     * Init the app.
     */
    public function __construct()
    {
        parent::__construct(dirname(__DIR__), new Uri(env('APP_URL')));

        $this->addServiceProvider(new Providers\Router());
        $this->addServiceProvider(new Providers\Templates());
        $this->addServiceProvider(new Providers\Middleware());
        $this->addServiceProvider(new Providers\Database());
        $this->addServiceProvider(new Providers\Logger());
        $this->addServiceProvider(new Providers\Cache());
        $this->addServiceProvider(new Providers\Config());
        $this->addServiceProvider(new Providers\Geolocation());
    }

    /**
     * Returns a router's url
     *
     * @param string $name
     * @param array  $attributes
     *
     * @return Uri
     */
    public function getRoute(string $name, array $attributes = []): Uri
    {
        $url = $this->get('router')->getGenerator()->generate($name, $attributes);

        return $this->getUri($url);
    }

    /**
     * Executes a request.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request, ResponseInterface $response)
    {
        //Previsualización
        if (!self::isPublic($request)) {
            putenv('APP_ADMIN=true');
            $request = $request->withMethod('GET');
        }

        $dispatcher = $this->get('middleware');

        return $dispatcher->dispatch($request);
    }

    private static function isPublic(ServerRequestInterface $request)
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            if (isset($data['from_admin']) && $data['from_admin'] === env('APP_KEY')) {
                return false;
            }
        }

        return true;
    }
}
