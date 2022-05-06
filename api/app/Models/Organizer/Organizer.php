<?php

namespace App\Models\Organizer;

use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $table = 'organizers';

    protected $fillable = [
        'title',
        'logo',
    ];

    protected $appends = [
        'logo_url',
    ];

    protected $casts = [
        'logo' => 'image',
    ];

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ?
            (new PathManager())->getFile($this->logo, 'organizers')
            :
            (new PathManager())->getDefaultPicture();
    }
}
