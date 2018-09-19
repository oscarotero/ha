<?php

namespace App\Models;

use Embed\Embed;
use SimpleCrud\Table;

class Artwork extends Table
{
    use BodyTrait;

    protected function init()
    {
        if (!env('APP_ADMIN')) {
            $this->addQueryModifier('select', function ($query) {
                $query
                    ->where('artwork.isActivated = 1')
                    ->where('artwork.publishedAt < :now', [':now' => date('Y-m-d H:i:s')]);
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dataToDatabase(array $data, $new)
    {
        if (isset($data['slug']) && empty($data['slug'])) {
            $data['slug'] = $data['title'];
        }

        if (isset($data['code']) && filter_var($data['code'], FILTER_VALIDATE_URL) !== false) {
            $data['code'] = Embed::create($data['code'])->code;
        }

        if (!empty($data['images'])) {
            foreach ($data['images'] as &$file) {
                $file['image'] = $this->imageFile->dataToDatabase($file['image']);
            }
            unset($file);
        }

        if (!empty($data['body'])) {
            $data['body'] = $this->bodyToDatabase($data['body'], $this->imageFile);
        }

        if (isset($data['imageFile']) && is_object($data['imageFile'])) {
            $data['imageFile'] = $this->imageFile->dataToDatabase($data['imageFile']);
            $file = $this->getDatabase()
                ->getAttribute('app')
                ->getPath('data/uploads/artwork/imageFile', $data['imageFile']);

            $size = getimagesize($file);
            $data['imageWidth'] = $size[0];
            $data['imageHeight'] = $size[1];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function dataFromDatabase(array $data)
    {
        if (!empty($data['images'])) {
            foreach ($data['images'] as &$file) {
                $file['image'] = $this->imageFile->dataFromDatabase($file['image']);
            }
        }

        if (!empty($data['body'])) {
            $data['body'] = $this->bodyFromDatabase($data['body'], $this->imageFile);
        }

        return $data;
    }
}
