<?php

namespace App\Models;

use SimpleCrud\Table;
use Typofixer\Typofixer;

class Ephemeris extends Table
{
    /**
     * {@inheritdoc}
     */
    public function dataToDatabase(array $data, $new)
    {
        $data['text'] = Typofixer::fix($data['text']);

        return $data;
    }
}
