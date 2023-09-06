<?php

return [
    'title' => 'BPAdmin',
    'userEntity'    => App\Models\User\User::class,
    'languages' => ['en'],

    'entities' => [
        'users' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\User\User::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'search'    =>  ['first_name',
                'second_name',
                'surname',
                'email'],
            'table_headers'   =>  [
                'first_name',
                'second_name',
                'surname',
                'email'
            ],
            'show_title'    => 'User Information',
            'show_fields'   => [
                'first_name',
                'email',
                'role_id',
            ],
            'validation_type' => 'default',
        ],
        'roles' => [
            'type'      =>  'default',
            'entity'    =>  \Spatie\Permission\Models\Role::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'name',
            ],
            'show_title'    => 'Role Information',
            'show_fields'   => [
                'name',
            ],
            'validation_type' => 'default',
        ],
        'articles' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Article\Article::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'title','year',
            ],
            'show_title'    => 'Article Information',
            'show_fields'   => [
                'title',
                'year',
                'category_id',
            ],
            'validation_type' => 'default',
        ],
        'tags' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Tag\Tag::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'name',
            ],
            'show_title'    => 'Tag Information',
            'show_fields'   => [
                'name',
            ],
            'validation_type' => 'default',
        ],
        'categories' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Article\Category\Category::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'title',
            ],
            'show_title'    => 'Category Information',
            'show_fields'   => [
                'title',
            ],
            'validation_type' => 'default',
        ],
        'news' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\News\News::class,
            'key'       =>  'id',
            'icon'      =>  'fa-newspaper',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'title','tag',
            ],
            'show_title'    => 'News Information',
            'show_fields'   => [
                'title',
                'sub_title',
                'text',
                'tag',
            ],
            'validation_type' => 'default',
        ],
        'organizers' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Organizer\Organizer::class,
            'key'       =>  'id',
            'icon'      =>  'fa-handshake',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'title',
            ],
            'show_title'    => 'News Information',
            'show_fields'   => [
                'title',
                'logo_url',
            ],
            'validation_type' => 'default',
        ],
        'partners' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Partner\Partner::class,
            'key'       =>  'id',
            'icon'      =>  'fa-handshake',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'title',
            ],
            'show_title'    => 'Partner Information',
            'show_fields'   => [
                'title',
                'logo_url',
            ],
            'validation_type' => 'default',
        ],
        'locales' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Locale\Locale::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'name',
            ],
            'show_title'    => 'Locale Information',
            'show_fields'   => [
                'name',
                'iso_code',
                'is_active'
            ],
            'validation_type' => 'default',
        ],
        'locale_keys' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Locale\LocaleKey\LocaleKey::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'key.key',
                'locale.name',
                'value'
            ],
            'show_title'    => 'Partner Information',
            'show_fields'   => [
                'value'
            ],
            'validation_type' => 'default',
        ],
        'organizations' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Organization\Organization::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'name',
            ],
            'show_title'    => 'Organization Information',
            'show_fields'   => [
                'name',
            ],
            'validation_type' => 'default',
        ],
        'structural_units' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Organization\StructuralUnit\StructuralUnit::class,
            'key'       =>  'id',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'name',
                'organization.name',
            ],
            'show_title'    => 'Structural Unit Information',
            'show_fields'   => [
                'name',
                'organization_id'
            ],
            'validation_type' => 'default',
        ],
    ],
    'menu' => [
        'users' => [
            'icon' => 'mdi-account-cog',
            'items' => [
                'users' => [
                    'icon' => 'mdi-account',
                ],
                'roles' => [
                    'icon' => 'mdi-account-group',
                ],
            ],
        ],
        'articles' => [
            'icon' => 'mdi-newspaper',
            'items' => [
                'categories' => [
                    'icon' => 'mdi-shape',
                ],
                'articles' => [
                    'icon' => 'mdi-newspaper',
                ],
                'tags' => [
                    'icon' => 'mdi-tag-multiple',
                ],
            ],
        ],
        'locales' => [
            'icon' => 'mdi-translate',
            'items' => [
                'locales' => [
                    'icon' => 'mdi-translate',
                ],
                'locale_keys' => [
                    'icon' => 'mdi-key',
                ],
            ],
        ],
        'news' => [
            'icon' => 'mdi-newspaper',
            'items' => [
                'news' => [
                    'icon' => 'mdi-newspaper',
                ],
                'organizers' => [
                    'icon' => 'mdi-domain',
                ],
                'partners' => [
                    'icon' => 'mdi-handshake',
                ],
            ],
        ],
        'organizations' => [
            'icon' => 'mdi-school',
            'items' => [
                'organizations' => [
                    'icon' => 'mdi-school',
                ],
                'structural_units' => [
                    'icon' => 'mdi-book',
                ],
            ],
        ],
    ],
];
