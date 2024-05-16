<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Tags extends BPModel
{
    public string $model = \App\Models\Tag\Tag::class;

    public string $name = 'tags';

    public array $fieldTypes = [
        'name' => [
            'type' => 'string',
            'required' => true,
        ],
        'articles_method' => [
            'type' => 'BelongsToMany',
            'method' => 'articles',
            'multiple' => true,
        ],
    ];

    public array $searchFields = [
        'name'
    ];

    public array $tableHeaderFields = [
        'id','name'
    ];

    public array $showPageFields = [
        'id','name'
    ];
}
