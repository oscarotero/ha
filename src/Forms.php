<?php

namespace App;

use FormManager\Builder as B;

abstract class Forms
{
    public static function search()
    {
        return B::form([
            'q' => B::search()
                ->placeholder('Buscar')
                ->data('source', '/buscar')
                ->required()
                ->label('Buscar'),
            '' => B::submit()
                ->label('Buscar'),
        ]);
    }

    public static function artist(App $app)
    {
        $db = $app->get('db');

        $countries = [
            '' => 'Todos',
        ];

        $result = $db->execute('SELECT DISTINCT `country`.`name`, `country`.`slug` FROM `country` LEFT JOIN `artist` ON  (`artist`.`country_id` = `country`.`id`) WHERE `artist`.`country_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $country) {
            $countries[$country['slug']] = $country['name'];
        }

        $tags = [
            '' => 'Todas',
        ];

        $result = $db->execute('SELECT DISTINCT `tag`.`name`, `tag`.`slug` FROM `tag` LEFT JOIN `artist_tag` ON  (`artist_tag`.`tag_id` = `tag`.`id`) WHERE `artist_tag`.`artist_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $tag) {
            $tags[$tag['slug']] = $tag['name'];
        }

        $movements = [
            '' => 'Todos',
        ];

        $result = $db->execute('SELECT DISTINCT `movement`.`name`, `movement`.`slug` FROM `movement` LEFT JOIN `artist_movement` ON  (`artist_movement`.`movement_id` = `movement`.`id`) WHERE `artist_movement`.`artist_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $movement) {
            $movements[$movement['slug']] = $movement['name'];
        }

        $authors = [
            '' => 'Todos',
        ];

        $result = $db->execute('SELECT DISTINCT `author`.`name`, `author`.`slug` FROM `author` LEFT JOIN `artist` ON  (`artist`.`author_id` = `author`.`id`) WHERE `artist`.`author_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $author) {
            $authors[$author['slug']] = $author['name'];
        }

        return B::form([
            'movement' => B::select($movements)
                ->label('Escoge un movimiento')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['expresionismo', 'romanticismo', 'post-impresionismo', 'surrealismo']),

            'country' => B::select($countries)
                ->label('Escoge un país')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['espana', 'francia', 'italia', 'estados-unidos']),

            'tag' => B::select($tags)
                ->label('Escoge una etiqueta')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['mujer', 'die-brucke', 'ready-made', 'pre-rafaelitas']),

            'life' => B::choose([
                '' => B::radio()->label('Cualquier año')->checked(),
                '1' => B::radio()->label('Vive actualmente'),
                'year' => B::radio()
                    ->label('Vivía en <output data-range="#input-year"></output>')
                    ->addClass('js-age')
                    ->labelAttr(['class' => 'has-output'])
                    ->data('range', '#input-year'),
            ]),

            'author' => B::select($authors)
                ->label('Escoge un autor')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['miguelcalvo', 'andreafischer', 'estebaniborio', 'fulwoodlapkin']),

            'year' => B::range()
                ->id('input-year')
                ->min(1300)
                ->max(2017)
                ->value(2010),

            // 'genre' => B::choose([
            //     '' => B::radio()->label('Todo')->checked(),
            //     'm' => B::radio()->label('Sólo mujeres'),
            //     'g' => B::radio()->label('Colectivos'),
            // ]),

            'order' => B::choose([
                    '' => B::radio()->label('Últimos añadidos')->checked(),
                    'olderst' => B::radio()->label('Los más antiguos'),
                    'youngest' => B::radio()->label('Los más recientes'),
                    'alphabetic' => B::radio()->label('Alfabeticamente'),
                ]),
            '' => B::submit()->label('Buscar artistas'),
        ])->method('get');
    }

    public static function artwork(App $app)
    {
        $db = $app->get('db');

        $countries = [
            '' => 'Todos',
        ];

        $result = $db->execute('SELECT DISTINCT `country`.`name`, `country`.`slug` FROM `country` LEFT JOIN `artwork` ON  (`artwork`.`country_id` = `country`.`id`) WHERE `artwork`.`country_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $country) {
            $countries[$country['slug']] = $country['name'];
        }

        $tags = [
            '' => 'Todas',
        ];

        $result = $db->execute('SELECT DISTINCT `tag`.`name`, `tag`.`slug` FROM `tag` LEFT JOIN `artwork_tag` ON  (`artwork_tag`.`tag_id` = `tag`.`id`) WHERE `artwork_tag`.`artwork_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $tag) {
            $tags[$tag['slug']] = $tag['name'];
        }

        $movements = [
            '' => 'Todos',
        ];

        $result = $db->execute('SELECT DISTINCT `movement`.`name`, `movement`.`slug` FROM `movement` LEFT JOIN `artwork_movement` ON  (`artwork_movement`.`movement_id` = `movement`.`id`) WHERE `artwork_movement`.`artwork_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $movement) {
            $movements[$movement['slug']] = $movement['name'];
        }

        $museums = [
            '' => 'Todos',
        ];

        $result = $db->execute('SELECT DISTINCT `museum`.`name`, `city`.`name` as `city_name`, `museum`.`slug` FROM `museum` LEFT JOIN `artwork` ON  (`artwork`.`museum_id` = `museum`.`id`) LEFT JOIN `city` ON (`museum`.`city_id` = `city`.`id`) WHERE `artwork`.`museum_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $museum) {
            $museums[$museum['slug']] = $museum['name'].(empty($museum['city_name']) ? '' : ', '.$museum['city_name']);
        }

        $authors = [
            '' => 'Todos',
        ];

        $result = $db->execute('SELECT DISTINCT `author`.`name`, `author`.`slug` FROM `author` LEFT JOIN `artwork` ON  (`artwork`.`author_id` = `author`.`id`) WHERE `artwork`.`author_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $author) {
            $authors[$author['slug']] = $author['name'];
        }

        $techniques = [
            '' => 'Todas',
        ];

        $result = $db->execute('SELECT DISTINCT `technique`.`name`, `technique`.`slug` FROM `technique` LEFT JOIN `artwork_technique` ON  (`artwork_technique`.`technique_id` = `technique`.`id`) WHERE `artwork_technique`.`artwork_id` IS NOT NULL ORDER BY name');

        foreach ($result->fetchAll() as $technique) {
            $techniques[$technique['slug']] = $technique['name'];
        }

        return B::form([
            'age' => B::choose([
                '' => B::radio()->label('Cualquier año')->checked(),
                'olderst' => B::radio()->label('Anteriores a 1500'),
                'decade' => B::radio()
                    ->label('De la década de <output data-range="#input-decade"></output>')
                    ->addClass('js-age')
                    ->labelAttr(['class' => 'has-output'])
                    ->data('range', '#input-decade'),
            ]),

            'decade' => B::range()
                ->id('input-decade')
                ->min(1500)
                ->max(2010)
                ->step(10)
                ->value(2010),

            'movement' => B::select($movements)
                ->label('Escoge un movimiento')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['expresionismo', 'romanticismo', 'post-impresionismo', 'surrealismo']),

            'technique' => B::select($techniques)
                ->label('Escoge una técnica')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['oleo', 'grabado', 'escultura', 'fotomontaje']),

            'country' => B::select($countries)
                ->label('Escoge un país')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['espana', 'francia', 'italia', 'estados-unidos']),

            'tag' => B::select($tags)
                ->label('Escoge una etiqueta')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['mujer', 'die-brucke', 'ready-made', 'pre-rafaelitas']),

            'museum' => B::select($museums)
                ->label('Escoge una museo')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['coleccion-particular', 'moma-nueva-york', 'louvre-paris']),

            'author' => B::select($authors)
                ->label('Escoge un autor')
                ->labelAttr(['class' => 'util-visuallyhidden'])
                ->data('trending', ['miguelcalvo', 'emiliabolano', 'estebaniborio', 'fulwoodlapkin']),

            'order' => B::choose([
                    '' => B::radio()->label('Últimos añadidos')->checked(),
                    'olderst' => B::radio()->label('Los más antiguos'),
                    'youngest' => B::radio()->label('Los más recientes'),
                    'alphabetic' => B::radio()->label('Alfabeticamente'),
                ]),
            '' => B::submit()->label('Buscar obras'),
        ])->method('get');
    }
}
