<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Special extends SimpleCrud
{
    public $title = 'Especiales';
    public $description = 'Especiales y "Semanas de..."';
    public $icon = 'calendar-range';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->special;
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

            'description' => $b->html()
                ->label('Descripción'),

            'startsAt' => $b->date()
                ->label('Fecha de inicio'),

            'endsAt' => $b->date()
                ->label('Fecha de fin'),
        ]);
    }
}
