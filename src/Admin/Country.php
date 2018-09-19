<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Country extends SimpleCrud
{
    public $title = 'Países';
    public $description = 'Lista de todos los países';
    public $icon = 'flag';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->country;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'name' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Nombre'),

            'gentileMale' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Gentilicio masculino'),

            'gentileFemale' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Gentilicio femenino'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),

            'imageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen'),
        ]);
    }
}
