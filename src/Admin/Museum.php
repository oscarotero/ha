<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Museum extends SimpleCrud
{
    public $title = 'Museos';
    public $description = 'Lista de museos';
    public $icon = 'domain';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->museum;
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

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),

            'city_id' => $b->relationOne($this->admin->getEntity('city'))
                ->data('config', [
                    'create' => 'name',
                ])
                ->label('Ciudad'),

            'city' => $b->text()
                ->maxlength(255)
                ->label('Ciudad'),

            'location' => $b->group([
                0 => $b->number()->label('Latitude'),
                1 => $b->number()->label('Longitude'),
                ])
                ->label('Coordenadas'),

            'povHeading' => $b->number()
                ->min(0)
                ->max(360)
                ->set('editable', true)
                ->label('Posición de la cámara'),
        ]);
    }

    public function getActions($id): array
    {
        $actions = [];
        $table = $this->getTable();
        $row = $table[$id];

        if (!empty($row->location[0])) {
            $actions[] = [
                'label' => 'Ver en google',
                'icon' => 'map-marker',
                'url' => vsprintf('https://www.google.es/maps/@%s,%s,21z', $row->location),
                'target' => '_blank',
            ];
        }

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
