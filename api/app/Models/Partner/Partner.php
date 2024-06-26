<?php

namespace App\Models\Partner;

use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';

    protected $fillable = [
        'title',
        'logo',
        'desc',
    ];

    protected $appends = [
        'logo_url',
    ];

    protected $casts = [
//        'logo' => 'file',
    ];

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ?
            (new PathManager())->getFile($this->logo, 'partners_logo')
            :
            (new PathManager())->getDefaultPicture();
    }
}
