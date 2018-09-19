<?php

namespace App\Admin;

use Folk\Entities\SimpleCrud;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;
use SimpleCrud\Table;

class Text extends SimpleCrud
{
    use BodyTrait;

    public $title = 'Textos';
    public $description = 'Páxinas soltas de texto';
    public $icon = 'file-document';

    public function getTable(): Table
    {
        return $this->admin->get('app')->get('db')->text;
    }

    public function getScheme(FormatFactory $b): Group
    {
        return $b->group([
            'title' => $b->text()
                ->required()
                ->maxlength(255)
                ->label('Título'),

            'slug' => $b->text()
                ->maxlength(255)
                ->label('Url id'),

            'isActivated' => $b->checkbox()
                ->label('Mostrar'),

            'position' => $b->number()
                ->required()
                ->label('Posición'),

            'body' => $this->buildBody($b),
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
