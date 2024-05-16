<?php

namespace App\BPAdmin;

use BlackParadise\LaravelAdmin\Core\Models\BPModel;

class Users extends BPModel
{
    public string $model = \App\Models\User\User::class;

    public string $filePath = 'users';

    public string $name = 'users';

    protected array $fieldTypes = [
        'first_name' => [
            'type' => 'string',
            'required' => true,
        ],
        'second_name' => [
            'type' => 'string',
            'required' => true,
        ],
        'surname' => [
            'type' => 'string',
            'required' => true,
        ],
        'avatar' => [
            'type' => 'file',
            'required' => false,
        ],
        'email' => [
            'type' => 'email',
            'required' => true,
        ],
        'password' => [
            'type' => 'hashed',
            'required' => true,
        ],
        'phone' => [
            'type' => 'string',
            'required' => false,
        ],
        'desc' => [
            'type' => 'string',
            'required' => false,
        ],
        'degree' => [
            'type' => 'string',
            'required' => false,
        ],
        'position' => [
            'type' => 'string',
            'required' => false,
        ],
        'city_id' => [
            'type' => 'BelongsTo',
            'method' => 'city',
            'required' => true,
        ],
        'organization_id' => [
            'type' => 'BelongsTo',
            'method' => 'organization',
            'required' => true,
        ],
        'verify' => [
            'type' => 'boolean',
            'required' => true,
        ],
        'students_method' => [
            'type' => 'BelongsToMany',
            'method' => 'students',
            'multiple' => true,
        ],
        'teachers_method' => [
            'type' => 'BelongsToMany',
            'method' => 'teachers',
            'multiple' => true,
        ],
        'articles_method' => [
            'type' => 'BelongsToMany',
            'method' => 'articles',
            'multiple' => true,
        ],
        'conferenceInOrgCommittee_method' => [
            'type' => 'BelongsToMany',
            'method' => 'conferenceInOrgCommittee',
            'multiple' => true,
        ],
        'conferenceInEditors_method' => [
            'type' => 'BelongsToMany',
            'method' => 'conferenceInEditors',
            'multiple' => true,
        ],
        'roles_method' => [
            'type' => 'BelongsToMany',
            'method' => 'roles',
            'multiple' => true,
        ],
        'permissions_method' => [
            'type' => 'BelongsToMany',
            'method' => 'permissions',
            'multiple' => true,
        ],
    ];

    public array $searchFields = [
        'first_name',
        'second_name',
        'surname',
        'email'
    ];

    public array $tableHeaderFields = [
        'first_name',
        'second_name',
        'surname',
        'email'
    ];

    public array $showPageFields = [
        'id',
        'first_name',
        'email',
        'role_id',
    ];
}
