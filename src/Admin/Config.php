<?php

namespace App\Admin;

use FlyCrud\Directory;
use Folk\Entities\FlyCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;

class Config extends FlyCrud
{
    public $title = 'Configuración';
    public $description = 'Configuración genérica de la web';
    public $icon = 'settings';

    public function getDirectory(): Directory
    {
        return $this->admin->get('app')->get('data:Directory');
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'weekend' => $b->checkbox()
                ->label('Activar fin de semana'),
            'weekend_day' => $b->select([
                    1 => 'Lunes',
                    2 => 'Martes',
                    3 => 'Miercoles',
                    4 => 'Jueves',
                    5 => 'Viernes',
                    6 => 'Sábado',
                    7 => 'Domingo',
                ])
                ->label('Inicio del fin de semana'),
        ]);
    }
}
