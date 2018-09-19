<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Ephemeris extends SimpleCrud
{
    public $title = 'Efemérides';
    public $description = 'Efemérides independientes mostradas en la portada';
    public $icon = 'calendar-today';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->ephemeris;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'text' => $b->html()
                ->required()
                ->label('Texto'),

            'year' => $b->number()
                ->min(2016)
                ->label('Año'),

            'month' => $b->select()
                ->options([
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 => 'Agosto',
                    9 => 'Septiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre',
                ])
                ->label('Mes'),

            'day' => $b->number()
                ->min(1)
                ->max(31)
                ->required()
                ->label('Día'),

            'isActivated' => $b->checkbox()
                ->label('Mostrar'),
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
