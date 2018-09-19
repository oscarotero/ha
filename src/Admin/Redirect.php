<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Redirect extends SimpleCrud
{
    public $title = 'Redirecciones';
    public $description = 'Lista de todas las redirecciones desde as urls antiguas a las nuevas';
    public $icon = 'call-merge';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->redirect;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'from' => $b->url()
                ->required()
                ->label('Desde'),

            'to' => $b->url()
                ->label('Hasta'),

            'referrers' => $b->collection([
                    'url' => $b->url(),
                ])
                ->label('Referencias'),
        ]);
    }
}
