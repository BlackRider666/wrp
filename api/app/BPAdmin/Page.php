<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Page extends BPModel
{
    public string $model = \App\Models\Pages\Page::class;

    public string $name = 'page';

    public array $fieldTypes = [
        'key' => [
            'type' => 'string',
            'required' => true,
        ],
        'title' => [
            'type' => 'translatable',
            'required' => true,
        ],
        'content' => [
            'type' => 'translatableEditor',
            'required' => true,
        ],
    ];

    public array $tableHeaderFields = [
        'title'
    ];

    public array $showPageFields = [
        'title','content'
    ];
}
