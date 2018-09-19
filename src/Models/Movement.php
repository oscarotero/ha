<?php

namespace App\Models;

use SimpleCrud\Table;
use Typofixer\Typofixer;

class Movement extends Table
{
    /**
     * {@inheritdoc}
     */
    public function dataToDatabase(array $data, $new)
    {
        if (empty($data['slug'])) {
            $data['slug'] = $data['name'];
        }

        $data['description'] = Typofixer::fix($data['description']);

        return $data;
    }
}
