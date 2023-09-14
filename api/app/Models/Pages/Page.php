<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $table = 'pages';

    protected $fillable = [
        'key',
        'title',
        'content',
    ];

    protected $hidden = [
        'key',
    ];

    public $translatable = [
        'title',
        'content',
    ];

    public $editable = [
        'content',
    ];
}
