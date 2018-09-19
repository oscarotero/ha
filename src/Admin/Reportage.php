<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Reportage extends SimpleCrud
{
    use BodyTrait;

    public $title = 'Artítulos';
    public $description = 'Posts temáticos';
    public $icon = 'file-document';

    protected $searchFields = ['title', 'body'];

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->reportage;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'title' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Título'),

            'subtitle' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Subtítulo'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),

            'shareTitle' => $b->text()
                ->set('list', false)
                ->maxlength(255)
                ->label('Título para compartir'),

            'shareDescription' => $b->textarea()
                ->set('list', false)
                ->maxlength(255)
                ->label('Descripción para compartir'),

            'shareImageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen para compartir'),

            'facebook' => $b->textarea()
                ->set('list', false)
                ->maxlength(255)
                ->label('Texto para publicar en facebook'),

            'twitter' => $b->textarea()
                ->set('list', false)
                ->maxlength(100)
                ->label('Texto para publicar en twitter'),

            'author_id' => $b->relationOne($this->admin->getEntity('author'))
                ->label('Escrito por'),

            'imageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen'),

            'imageCropX' => $b->number()
                ->set('list', false)
                ->min(0)
                ->max(100)
                ->label('Recorte horizontal'),

            'imageCropY' => $b->number()
                ->set('list', false)
                ->min(0)
                ->max(100)
                ->label('Recorte vertical'),

            'isActivated' => $b->checkbox()
                ->label('Mostrar'),

            'publishedAt' => $b->datetime()
                ->label('Fecha de publicación'),

            'tag' => $b->relationMany($this->admin->getEntity('tag'))
                ->data('config', [
                    'create' => 'name',
                ])
                ->label('Etiquetas'),

            'special' => $b->relationMany($this->admin->getEntity('special'))
                ->label('Especial'),

            'backgroundColor' => $b->text()
                ->set('list', false)
                ->label('Color de fondo'),

            'foregroundColor' => $b->text()
                ->set('list', false)
                ->label('Color de texto'),

            'body' => $this->buildBody($b),
        ]);
    }

    public function getActions($id): array
    {
        $actions = [];
        $row = $this->getTable()[$id];

        if ($row->isActivated && $row->publishedAt && $row->publishedAt->getTimestamp() <= time()) {
            $actions[] = [
                'label' => 'Ver',
                'icon' => 'eye',
                'url' => $this->admin->get('app')->getRoute('reportage-permalink', ['slug' => $row->slug]),
            ];
        } else {
            $actions[] = [
                'label' => 'Previsualizar',
                'icon' => 'eye',
                'url' => $this->admin->get('app')->getRoute('reportage-permalink', ['slug' => $row->slug]),
                'method' => 'post',
                'target' => '_blank',
                'data' => [
                    'from_admin' => env('APP_KEY'),
                ],
            ];
        }

        return $actions;
    }
}
