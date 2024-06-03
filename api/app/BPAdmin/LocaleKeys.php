<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class LocaleKeys extends BPModel
{
    public string $model = \App\Models\Locale\LocaleKey\LocaleKey::class;

    public string $name = 'locale_keys';

    public array $fieldTypes = [
        'key_id' => [
            'type' => 'BelongsTo',
            'method' => 'key',
            'required' => true,
        ],
        'locale_id' => [
            'type' => 'BelongsTo',
            'method' => 'locale',
            'required' => true,
        ],
        'value' => [
            'type' => 'string',
            'required' => true,
        ],
    ];

    public array $tableHeaderFields = [
        'key.key',
        'locale.name',
        'value'
    ];

    public array $showPageFields = [
        'key.key',
        'locale.name',
        'value'
    ];

    public array $searchFields = [
        'value'
    ];
}
