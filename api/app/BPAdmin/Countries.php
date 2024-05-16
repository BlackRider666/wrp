<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Countries extends BPModel
{
    public string $model = \App\Models\Country\Country::class;

    public string $name = 'countries';

    public array $fieldTypes = [
        'name' => [
            'type' => 'string',
            'required' => true,
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
