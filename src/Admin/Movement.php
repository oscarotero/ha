<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Movement extends SimpleCrud
{
    public $title = 'Movementos';
    public $description = 'Lista de todos los movementos artísticos';
    public $icon = 'run';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->movement;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'movementGroup_id' => $b->relationOne($this->admin->getEntity('movementgroup'))
                ->label('Grupo del que forma parte'),

            'name' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Nombre'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),

            'description' => $b->html()
                ->label('Descripción'),

            'yearStart' => $b->number()
                ->label('Año de nacimiento'),

            'yearEnd' => $b->number()
                ->label('Año de fin'),

            'shareTitle' => $b->text()
                ->maxlength(255)
                ->label('Título para compartir'),

            'shareDescription' => $b->textarea()
                ->maxlength(255)
                ->label('Descripción para compartir'),

            'imageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen'),
        ]);
    }

    public function getActions($id): array
    {
        $table = $this->getTable();

        $prev = $table->select()
            ->one()
            ->where('id < :id', [':id' => $id])
            ->orderBy('id DESC')
            ->run();

        $next = $table->select()
            ->one()
            ->where('id > :id', [':id' => $id])
            ->orderBy('id ASC')
            ->run();

        $actions = [];

        if ($prev) {
            $actions[] = [
                'label' => 'Anterior',
                'url' => $this->admin->getRoute('read', ['entity' => $this->name, 'id' => $prev->id]),
            ];
        }

        if ($next) {
            $actions[] = [
                'label' => 'Siguiente',
                'url' => $this->admin->getRoute('read', ['entity' => $this->name, 'id' => $next->id]),
            ];
        }

        if (!empty($actions)) {
            return $actions;
        }
    }
}
