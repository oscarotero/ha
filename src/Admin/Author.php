<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Author extends SimpleCrud
{
    public $title = 'Autores';
    public $description = 'Autores de las fichas';
    public $icon = 'emoticon';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->author;
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

            'title' => $b->text()
                ->maxlength(255)
                ->label('Título'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Nick id'),

            'bio' => $b->html()
                ->label('Biografía'),

            'imageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen'),

            'links' => $b->collectionMultiple([
                'link' => [
                    'text' => $b->text()->label('Texto'),
                    'url' => $b->url()->label('Url'),
                ],
                'email' => [
                    'text' => $b->text()->label('Texto'),
                    'email' => $b->email()->label('Email'),
                ],
            ])->label('Contacto'),
        ]);
    }
}
