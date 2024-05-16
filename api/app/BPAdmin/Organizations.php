<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Organizations extends BPModel
{
    public string $model = \App\Models\Organization\Organization::class;

    public string $name = 'organizations';

    public array $fieldTypes = [
        'name' => [
            'type' => 'translatable',
            'required' => true,
        ],
        'img' => [
            'type' => 'file',
            'required' => false,
        ],
        'country_id' => [
            'type' => 'BelongsTo',
            'method' => 'country',
            'required' => true,
        ],
        'city_id' => [
            'type' => 'BelongsTo',
            'method' => 'city',
            'required' => true,
        ],
        'rate' => [
            'type' => 'integer',
            'required' => true,
        ],
        'verified' => [
            'type' => 'boolean',
            'required' => true,
        ],
        'user_id' => [
            'type' => 'BelongsTo',
            'method' => 'user',
            'required' => true,
        ],
        'address' => [
            'type' => 'string',
            'required' => false,
        ],
        'zip_code' => [
            'type' => 'string',
            'required' => false,
        ],
        'site' => [
            'type' => 'string',
            'required' => false,
        ],
        'phone' => [
            'type' => 'string',
            'required' => false,
        ],
        'desc' => [
            'type' => 'translatableEditor',
            'required' => true,
        ],
        'editors_method' => [
            'type' => 'BelongsToMany',
            'method' => 'editors',
            'multiple' => true,
        ],
        'staff_method' => [
            'type' => 'BelongsToMany',
            'method' => 'staff',
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
