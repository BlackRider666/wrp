<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class StructuralUnits extends BPModel
{
    public string $model = \App\Models\Organization\StructuralUnit\StructuralUnit::class;

    public string $name = 'structural_units';

    public array $fieldTypes = [
        'name' => [
            'type' => 'translatable',
            'required' => true,
        ],
        'organization_id' => [
            'type' => 'BelongsTo',
            'method' => 'organization',
            'required' => true,
        ],
        'parent_id' => [
            'type' => 'BelongsTo',
            'method' => 'parent',
            'required' => true,
        ],
        'type' => [
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
        'id','name','type',
    ];
}
