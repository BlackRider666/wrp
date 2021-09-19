<?php

namespace App\Models\News;

use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'sub_title',
        'text',
        'main_photo',
        'tag',
    ];

    protected $appends = [
        'main_photo_url',
    ];

    protected $casts = [
        'main_photo' => 'image',
    ];

    public function getMainPhotoUrlAttribute(): string
    {
        return $this->main_photo ?
            (new PathManager())->getFile($this->main_photo, 'news')
            :
            (new PathManager())->getDefaultPicture();
    }
}
