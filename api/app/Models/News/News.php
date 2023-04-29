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
        'main_photo' => 'file',
        'created_at' => 'datetime:d M Y H:i'
    ];

    public function getMainPhotoUrlAttribute(): string
    {
        return $this->main_photo ?
            (new PathManager())->getFile($this->main_photo, 'news_main_photo')
            :
            (new PathManager())->getDefaultPicture();
    }
}
