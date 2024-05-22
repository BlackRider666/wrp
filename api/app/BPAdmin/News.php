<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class News extends BPModel
{
    public string $model = \App\Models\News\News::class;

    public string $name = 'news';

    public string $filePath = 'news';

    public array $fieldTypes = [
        'title' => [
            'type' => 'translatable',
            'required' => true,
        ],
        'sub_title' => [
            'type' => 'translatable',
            'required' => true,
        ],
        'text' => [
            'type' => 'translatableEditor',
            'required' => true,
        ],
        'main_photo' => [
            'type' => 'file',
            'required' => true,
        ],
        'tag' => [
            'type' => 'string',
            'required' => true,
        ],
    ];

    public array $searchFields = [
        'title'
    ];

    public array $tableHeaderFields = [
        'title','tag',
    ];

    public array $showPageFields = [
        'title',
        'sub_title',
        'text',
        'tag',
    ];
}
