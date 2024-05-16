<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Locales extends BPModel
{
    public string $model = \App\Models\Locale\Locale::class;

    public string $name = 'locales';

    public array $fieldTypes = [
        'name' => [
            'type' => 'string',
            'required' => true,
        ],
        'iso_code' => [
            'type' => 'string',
            'required' => true,
        ],
        'is_active' => [
            'type' => 'boolean',
            'required' => true,
        ],
        'keys_method' => [
            'type' => 'BelongsToMany',
            'method' => 'keys',
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
        'name',
        'iso_code',
        'is_active'
    ];
}
