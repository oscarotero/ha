<?php

namespace App\Models;

use SimpleCrud\Table;

class Reportage extends Table
{
    use BodyTrait;

    protected function init()
    {
        if (!env('APP_ADMIN')) {
            $this->addQueryModifier('select', function ($query) {
                $query
                    ->where('reportage.isActivated = 1')
                    ->where('reportage.publishedAt < :now', [':now' => date('Y-m-d H:i:s')]);
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
            $data['body'] = $this->bodyToDatabase($data['body'], $this->imageFile);
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dataFromDatabase(array $data)
    {
        if (!empty($data['body'])) {
            $data['body'] = $this->bodyFromDatabase($data['body'], $this->imageFile);
        }

        return $data;
    }
}
