<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class City extends SimpleCrud
{
    public $title = 'Ciudades';
    public $description = 'Lista de todas las ciudades';
    public $icon = 'flag';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->city;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'country_id' => $b->relationOne($this->admin->getEntity('country'))
                ->data('config', [
                    'create' => 'name',
                ])
                ->label('País'),

            'name' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Nombre'),
        ]);
    }
}
