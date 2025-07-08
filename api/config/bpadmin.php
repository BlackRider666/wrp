<?php

return [
    'title' => 'BPAdmin',
    'userEntity'    => App\Models\User\User::class,
    'languages' => ['en','uk'],

    'entities' => [
        'users' => \App\Models\User\User::class,
        'roles' => \Spatie\Permission\Models\Role::class,
        'articles' => \App\Models\Article\Article::class,
        'tags' => \App\Models\Tag\Tag::class,
        'categories' => \App\Models\Article\Category\Category::class,
        'news' => \App\Models\News\News::class,
        'organizers' => \App\Models\Organizer\Organizer::class,
        'partners' => \App\Models\Partner\Partner::class,
        'locales' => \App\Models\Locale\Locale::class,
        'locale_keys' => \App\Models\Locale\LocaleKey\LocaleKey::class,
        'organizations' => \App\Models\Organization\Organization::class,
        'structural_units' => \App\Models\Organization\StructuralUnit\StructuralUnit::class,
        'countries' => \App\Models\Country\Country::class,
        'cities' => \App\Models\Country\City\City::class,
        'page' => \App\Models\Pages\Page::class,
        'directions' => \App\Models\Article\Direction\Direction::class,
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
                'directions' => [
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
        'countries' => [
            'icon' => 'mdi-flag',
            'items' => [
                'countries' => [
                    'icon' => 'mdi-flag',
                ],
                'cities' => [
                    'icon' => 'mdi-city',
                ],
            ],
        ],
        'page' => [
            'icon' => 'mdi-file-document-outline',
        ],
    ],
];
