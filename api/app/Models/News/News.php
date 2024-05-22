<?php

namespace App\Models\News;

use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasTranslations;
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
//        'main_photo' => 'file',
        'created_at' => 'datetime:d M Y H:i'
    ];

    public $translatable = [
        'title',
        'sub_title',
        'text',
    ];

    public function getMainPhotoUrlAttribute(): string
    {
        return $this->main_photo ?
            (new PathManager())->getFile($this->main_photo, 'news/main_photo')
            :
            (new PathManager())->getDefaultPicture();
    }
}
