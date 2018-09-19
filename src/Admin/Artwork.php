<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Artwork extends SimpleCrud
{
    use BodyTrait;

    public $title = 'Obras';
    public $description = 'Lista de todas las obras de arte';
    public $icon = 'brush';

    protected $searchFields = ['title', 'body'];

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->artwork;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'title' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Título'),

            'originalTitle' => $b->text()
                ->maxlength(255)
                ->label('Título original'),

            'subtitle' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Subtítulo'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),

            'shareTitle' => $b->text()
                ->maxlength(255)
                ->set('list', false)
                ->label('Título para compartir'),

            'shareDescription' => $b->textarea()
                ->maxlength(255)
                ->set('list', false)
                ->label('Descripción para compartir'),

            'shareImageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen para compartir'),

            'facebook' => $b->textarea()
                ->maxlength(255)
                ->set('list', false)
                ->label('Texto para publicar en facebook'),

            'twitter' => $b->textarea()
                ->maxlength(100)
                ->set('list', false)
                ->label('Texto para publicar en twitter'),

            'author_id' => $b->relationOne($this->admin->getEntity('author'))
                ->label('Escrito por'),

            'museum_id' => $b->relationOne($this->admin->getEntity('museum'))
                ->data('config', [
                    'create' => 'name',
                ])
                ->label('Museo'),

            'size' => $b->text()
                ->maxlength(255)
                ->set('list', false)
                ->label('Dimensiones'),

            'copyright' => $b->text()
                ->maxlength(255)
                ->set('list', false)
                ->label('Copyright'),

            'year' => $b->number()
                ->min(0)
                ->max((int) date('Y'))
                ->set('list', false)
                ->required()
                ->label('Año'),

            'month' => $b->select()
                ->set('list', false)
                ->options([
                    '' => '',
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

            'description' => $b->html()
                ->set('list', false)
                ->data('config', [
                    'extraPlugins' => 'autogrow,wordcount,notification',
                    'disableNativeSpellChecker' => false,
                ])
                ->label('Descrición'),

            'code' => $b->text()
                ->set('list', false)
                ->label('Vídeo'),

            'widget' => $b->select([
                    '' => '',
                    'dragotto' => 'Azulejos Dragón Otto',
                    'dragescher' => 'Azulejos Lagarto Escher',
                ])
                ->label('Interactividad'),

            'imageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen'),

            'caption' => $b->html()->label('Pie de imagen'),
            'imageWidth' => $b->hidden(),
            'imageHeight' => $b->hidden(),

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

            'images' => $b->collection([
                'image' => $b->imageUpload()
                    ->data('config', [
                        'directory' => 'data/uploads/',
                    ])
                    ->label('Imagen'),
                'caption' => $b->html()
                    ->label('Pie de imagen'),
                ])->label('Imágenes extra'),

            'isActivated' => $b->checkbox()
                ->label('Mostrar'),

            'publishedAt' => $b->datetime()
                ->label('Fecha de publicación'),

            'artist' => $b->relationMany($this->admin->getEntity('artist'))
                ->label('Artistas'),

            'movement' => $b->relationMany($this->admin->getEntity('movement'))
                ->label('Movimientos'),

            'technique' => $b->relationMany($this->admin->getEntity('technique'))
                ->label('Técnicas'),

            'country_id' => $b->relationOne($this->admin->getEntity('country'))
                ->data('config', [
                    'create' => 'name',
                ])
                ->label('País'),

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
                'url' => $this->admin->get('app')->getRoute('artwork-permalink', ['slug' => $row->slug]),
            ];
        } else {
            $actions[] = [
                'label' => 'Previsualizar',
                'icon' => 'eye',
                'url' => $this->admin->get('app')->getRoute('artwork-permalink', ['slug' => $row->slug]),
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
