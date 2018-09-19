<?php

namespace App\Models;

use SimpleCrud\Table;

class Artist extends Table
{
    use BodyTrait;

    /**
     * {@inheritdoc}
     */
    public function dataToDatabase(array $data, $new)
    {
        if (empty($data['slug'])) {
            $data['slug'] = $data['name'].' '.$data['surname'];
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
