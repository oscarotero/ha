<?php

namespace App\Models;

use Embed\Embed;
use SimpleCrud\Fields\File;
use Typofixer\Typofixer;

trait BodyTrait
{
    private function bodyToDatabase(array $body, File $field)
    {
        foreach ($body as &$section) {
            if ($section['type'] === 'image') {
                $section['image'] = $field->dataToDatabase($section['image']);

                if (!empty($section['caption'])) {
                    $section['caption'] = Typofixer::fix($section['caption']);
                }
            }

            if ($section['type'] === 'code' && filter_var($section['code'], FILTER_VALIDATE_URL) !== false) {
                $section['code'] = Embed::create($section['code'])->code;

                if (!empty($section['caption'])) {
                    $section['caption'] = Typofixer::fix($section['caption']);
                }
            }

            if ($section['type'] === 'text' || $section['type'] === 'highlight-text') {
                $section['text'] = Typofixer::fix($section['text']);
            }
        }

        return $body;
    }

    private function bodyFromDatabase(array $body, File $field)
    {
        foreach ($body as &$section) {
            if ($section['type'] === 'image') {
                $section['image'] = $field->dataFromDatabase($section['image']);
            }

            if ($section['type'] === 'code' && filter_var($section['code'], FILTER_VALIDATE_URL) !== false) {
                $section['code'] = Embed::create($section['code'])->code;
            }
        }

        return $body;
    }
}
