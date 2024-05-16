<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class News extends BPModel
{
    public string $model = \App\Models\News\News::class;

    public string $name = 'news';

    public array $fieldTypes = [
        'title' => [
            'type' => 'string',
            'required' => true,
        ],
        'sub_title' => [
            'type' => 'string',
            'required' => true,
        ],
        'text' => [
            'type' => 'string',
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
