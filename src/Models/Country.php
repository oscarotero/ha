<?php

namespace App\Models;

use SimpleCrud\Table;

class Country extends Table
{
    protected function init()
    {
        $this->setRowMethod('hasMuseums', function () {
            return $this->getDatabase()->museum
                ->count()
                ->relatedWith($this)
                ->limit(1)
                ->run() > 0;
        });
    }

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
