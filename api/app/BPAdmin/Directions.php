<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Directions extends BPModel
{
    public string $model = \App\Models\Article\Direction\Direction::class;

    public string $name = 'directions';

    public array $fieldTypes = [
        'name' => [
            'type' => 'translatable',
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
