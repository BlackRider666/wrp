<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Articles extends BPModel
{
    public string $model = \App\Models\Article\Article::class;

    public string $name = 'articles';

    public array $fieldTypes = [
        'city_id' => [
            'type' => 'BelongsTo',
            'method' => 'city',
            'required' => true,
        ],
        'title' => [
            'type' => 'translatable',
            'required' => true,
        ],
        'category_id' => [
            'type' => 'BelongsTo',
            'method' => 'category',
            'required' => true,
        ],
        'year' => [
            'type' => 'date:Y',
            'required' => true,
        ],
        'journal' => [
            'type' => 'string',
            'required' => false,
        ],
        'part' => [
            'type' => 'string',
            'required' => false,
        ],
        'number' => [
            'type' => 'string',
            'required' => false,
        ],
        'pages' => [
            'type' => 'string',
            'required' => false,
        ],
        'publisher' => [
            'type' => 'string',
            'required' => false,
        ],
        'patent_number' => [
            'type' => 'string',
            'required' => false,
        ],
        'app_number' => [
            'type' => 'string',
            'required' => false,
        ],
        'desc' => [
            'type' => 'translatableEditor',
            'required' => false,
        ],
        'full_text' => [
            'type' => 'translatableEditor',
            'required' => false,
        ],
        'file' => [
            'type' => 'file',
            'required' => false,
        ],
        'authors_method' => [
            'type' => 'BelongsToMany',
            'method' => 'authors',
            'multiple' => true,
        ],
        'tags_method' => [
            'type' => 'BelongsToMany',
            'method' => 'tags',
            'multiple' => true,
        ],
        'conferences_method' => [
            'type' => 'BelongsToMany',
            'method' => 'conferences',
            'multiple' => true,
        ],
    ];

    public array $tableHeaderFields = [
        'title','year',
    ];

    public array $showPageFields = [
        'title',
        'year',
        'category_id',
    ];
}
