<?php

namespace App\Admin;

use Folk\Formats\CollectionMultiple;
use Folk\Formats\FormatFactory;

trait BodyTrait
{
    public function buildBody(FormatFactory $b): CollectionMultiple
    {
        return $b->collectionMultiple([
            'text' => [
                'text' => $b->html()
                    ->data('config', [
                    'extraPlugins' => 'autogrow,wordcount,notification',
                    'disableNativeSpellChecker' => false,
                ]),
            ],
            'footer' => [
                'text' => $b->html(),
            ],
            'highlight-text' => [
                'text' => $b->html()
                    ->data('config', [
                        'toolbar' => [
                            ['Italic', 'Bold', 'Link', 'Unlink'],
                        ],
                    ]),
            ],
            'image' => [
                'image' => $b->imageUpload()
                    ->data('config', [
                        'directory' => 'data/uploads/',
                    ])
                    ->label('Imagen'),
                'caption' => $b->html()
                    ->label('Pie de imagen'),
            ],
            'code' => [
                'code' => $b->textarea()
                    ->label('Url o código'),
                'caption' => $b->html()
                    ->label('Pie de vídeo'),
            ],
            'html' => [
                'code' => $b->code()
                    ->data('config', [
                        'mode' => 'htmlmixed',
                    ])
                    ->label('Html'),
            ],
        ]);
    }
}
