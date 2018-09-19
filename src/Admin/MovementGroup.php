<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class MovementGroup extends SimpleCrud
{
    public $title = 'Agrupación de movimientos';
    public $description = 'Lista de las agrupaciones de los distintos movimentos';
    public $icon = 'run-fast';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->movementGroup;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'name' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Nombre'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),
        ]);
    }
}
