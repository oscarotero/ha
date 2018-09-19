<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Tag extends SimpleCrud
{
    public $title = 'Etiquetas';
    public $description = 'Lista de todas las etiquetas';
    public $icon = 'tag-multiple';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->tag;
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
