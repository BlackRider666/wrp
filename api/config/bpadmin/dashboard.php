<?php

return [
    'title' => 'BPAdmin',

    'entities' => [
        'users' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\User\User::class,
            'key'       =>  'id',
            'icon'      =>  'fa-users',
            'paginate'  =>  10,
            'table_headers'   =>  [
                'full_name','email'
            ],
            'show_title'    => 'User Information',
            'show_fields'   => [
                'first_name',
                'email',
                'role_id',
            ],
            'validation_type' => 'default',
        ],
        'articles' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Article\Article::class,
            'key'       =>  'id',
            'icon'      =>  'fa-newspaper',
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
        'categories' => [
            'type'      =>  'default',
            'entity'    =>  \App\Models\Article\Category\Category::class,
            'key'       =>  'id',
            'icon'      =>  'fa-newspaper',
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
    ],
];
