<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Categories extends BPModel
{
    public string $model = \App\Models\Article\Category\Category::class;

    public string $name = 'categories';

    public array $fieldTypes = [
        'title' => [
            'type' => 'string',
            'required' => true,
        ],
        'tech_name' => [
            'type' => 'string',
            'required' => true,
        ],
    ];

    public array $tableHeaderFields = [
        'title'
    ];

    public array $showPageFields = [
        'title'
    ];
}
