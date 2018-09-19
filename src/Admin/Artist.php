<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Artist extends SimpleCrud
{
    use BodyTrait;

    public $title = 'Artistas';
    public $description = 'Lista de todos los artistas';
    public $icon = 'palette';

    protected $searchFields = ['name', 'surname', 'body'];

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->artist;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'name' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Nombre'),

            'surname' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Apellido'),

            'shareTitle' => $b->text()
                ->maxlength(255)
                ->label('Título para compartir'),

            'shareDescription' => $b->textarea()
                ->maxlength(255)
                ->label('Descripción para compartir'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),

            'author_id' => $b->relationOne($this->admin->getEntity('author'))
                ->label('Escrito por'),

            'country_id' => $b->relationOne($this->admin->getEntity('country'))
                ->label('País'),

            'yearBorn' => $b->number()
                ->required()
                ->label('Año de nacimiento'),

            'yearDead' => $b->number()
                ->label('Año de muerte'),

            'imageFile' => $b->imageUpload()
                ->data('config', [
                    'directory' => 'data/uploads/',
                ])
                ->label('Imagen'),

            'movement' => $b->relationMany($this->admin->getEntity('movement'))
                ->label('Movimientos'),

            'tag' => $b->relationMany($this->admin->getEntity('tag'))
                ->data('config', [
                    'create' => 'name',
                ])
                ->label('Etiquetas'),

            'body' => $this->buildBody($b),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel($id, array $data): string
    {
        return $id.' - '.$data['name'].' '.$data['surname'];
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
