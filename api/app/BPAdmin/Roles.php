<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Roles extends BPModel
{
    public string $model = \Spatie\Permission\Models\Role::class;

    public string $name = 'roles';

    public array $fieldTypes = [
        'permissions_method' => [
            'type' => 'BelongsToMany',
            'method' => 'permissions',
            'multiple' => true,
        ],
        'users_method' => [
            'type' => 'BelongsToMany',
            'method' => 'users',
            'multiple' => true,
        ],
    ];

    public array $tableHeaderFields = [
        'name',
    ];

    public array $showPageFields = [
        'name',
    ];
}
