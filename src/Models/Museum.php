<?php

namespace App\Models;

use SimpleCrud\Table;

class Museum extends Table
{
    /**
     * {@inheritdoc}
     */
    public function dataToDatabase(array $data, $new)
    {
        if (empty($data['slug'])) {
            $data['slug'] = $data['name'];
        }

        if (empty($data['location'][0]) && !empty($data['city_id'])) {
            $city = $this->getDatabase()->city[$data['city_id']];
            $address = sprintf('%s, %s. %s', $data['name'], $city->name, $city->country->name);
            $geocoder = $this->getDatabase()->getAttribute('app')->get('geocoder');
            $coords = $geocoder->geocode($address)->first()->getCoordinates();

            $data['location'] = [
                $coords->getLatitude(),
                $coords->getLongitude(),
            ];
        }

        return $data;
    }
}
