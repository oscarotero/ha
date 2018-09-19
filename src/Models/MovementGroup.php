<?php

namespace App\Models;

use SimpleCrud\Table;

class MovementGroup extends Table
{
    /**
     * {@inheritdoc}
     */
    public function dataToDatabase(array $data, $new)
    {
        if (empty($data['slug'])) {
            $data['slug'] = $data['name'];
        }

        return $data;
    }
}
