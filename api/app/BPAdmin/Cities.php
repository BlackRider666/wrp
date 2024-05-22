<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Cities extends BPModel
{
    public string $model = \App\Models\Country\City\City::class;

    public string $name = 'cities';

    public array $fieldTypes = [
        'country_id' => [
            'type' => 'BelongsTo',
            'method' => 'country',
            'required' => true,
        ],
        'name' => [
            'type' => 'translatable',
            'required' => true,
        ],
    ];

    public array $tableHeaderFields = [
        'name',
        'country.name',
    ];

    public array $showPageFields = [
        'name',
        'country.name',
    ];
}
