<?php

namespace App\Models;

use SimpleCrud\Fields\File;
use SimpleCrud\Table;

class Text extends Table
{
    use BodyTrait;

    protected function init()
    {
        if (env('APP_PUBLIC')) {
            $this->addQueryModifier('select', function ($query) {
                $query->where('text.isActivated = 1');
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dataToDatabase(array $data, $new)
    {
        if (empty($data['slug'])) {
            $data['slug'] = $data['title'];
        }

        if (!empty($data['body'])) {
            $data['body'] = $this->bodyToDatabase($data['body'], new File($this, 'imageFile'));
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dataFromDatabase(array $data)
    {
        if (!empty($data['body'])) {
            $data['body'] = $this->bodyFromDatabase($data['body'], new File($this, 'imageFile'));
        }

        return $data;
    }
}
