<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Organizers extends BPModel
{
    public string $model = \App\Models\Organizer\Organizer::class;

    public string $name = 'organizers';

    public string $filePath = 'organizers';

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
        'title'
    ];

    public array $showPageFields = [
        'id','title','desc','logo'
    ];
}
