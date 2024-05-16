<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Partners extends BPModel
{
    public string $model = \App\Models\Partner\Partner::class;

    public string $name = 'partners';

    public array $fieldTypes = [
        'title' => [
            'type' => 'string',
            'required' => true,
        ],
        'logo' => [
            'type' => 'file',
            'required' => true,
        ],
        'desc' => [
            'type' => 'string',
            'required' => true,
        ],
    ];

    public array $searchFields = [
        'title'
    ];

    public array $tableHeaderFields = [
        'id','title'
    ];

    public array $showPageFields = [
        'id','title'
    ];
}
