<?php

namespace App\Providers;

use Aura\Router\RouterContainer;
use Fol\App;
use Interop\Container\ServiceProviderInterface;

class Router implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'router' => function (App $app): RouterContainer {
                $ns = 'App\\Controllers\\';

                $routerContainer = new RouterContainer();

                $map = $routerContainer->getMap();

                $map->get('index', '/', "{$ns}Index::index");

                $map->get('search', '/buscar', "{$ns}Search::search");
                $map->get('search.json', '/buscar.json', "{$ns}Search::search");

                $map->get('movement-search', '/movimientos', "{$ns}Movement::search");
                $map->get('movement-timeline', '/movimientos/timeline', "{$ns}Movement::timeline");
                $map->get('movement-permalink', '/movimientos/{slug}', "{$ns}Movement::permalink");

                $map->get('technique-search', '/tecnicas', "{$ns}Technique::search");
                $map->get('technique-permalink', '/tecnicas/{slug}', "{$ns}Technique::permalink");

                $map->get('artwork-search', '/obras', "{$ns}Artwork::search");
                $map->get('artwork-search.rss', '/obras.rss', "{$ns}Artwork::search");
                $map->get('artwork-permalink', '/obras/{slug}', "{$ns}Artwork::permalink");
                $map->get('artwork-rrss', '/obras.{rrss}.rss', "{$ns}Artwork::rrss")
                    ->tokens([
                        'rrss' => 'facebook|twitter',
                    ]);

                $map->get('artist-search', '/artistas', "{$ns}Artist::search");
                $map->get('artist-search.rss', '/artistas.rss', "{$ns}Artist::search");
                $map->get('artist-permalink', '/artistas/{slug}', "{$ns}Artist::permalink");

                $map->get('reportage-search', '/articulos', "{$ns}Reportage::search");
                $map->get('reportage-search.rss', '/articulos.rss', "{$ns}Reportage::search");
                $map->get('reportage-permalink', '/articulos/{slug}', "{$ns}Reportage::permalink");
                $map->get('reportage-rrss', '/articulos.{rrss}.rss', "{$ns}Reportage::rrss")
                    ->tokens([
                        'rrss' => 'facebook|twitter',
                    ]);

                $map->get('country-search', '/paises', "{$ns}Country::search");
                $map->get('country-permalink', '/paises/{slug}', "{$ns}Country::permalink");

                $map->get('tag-permalink', '/etiquetas/{slug}', "{$ns}Tag::permalink");

                $map->get('museum-search', '/museos', "{$ns}Museum::search");
                $map->get('museum-permalink', '/museos/{slug}', "{$ns}Museum::permalink");

                $map->get('author-search', '/autores', "{$ns}Author::search");
                $map->get('author-permalink', '/autores/{slug}', "{$ns}Author::permalink");

                $map->get('special-permalink', '/especiales/{slug}', "{$ns}Special::permalink");

                $map->get('ephemeris.rss', '/efemerides.rss', "{$ns}Ephemeris::rss");

                $map->get('500', '/500', function () {
                    throw new \Exception('Error Processing Request', 1);
                });

                $map->get('lost-connection', '/sin-conexion', "{$ns}Index::lostConnection");

                $map->get('text-permalink', '/{slug}', "{$ns}Text::permalink");

                return $routerContainer;
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
