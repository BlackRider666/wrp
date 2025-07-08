<?php

namespace App\Models\Article\Direction;

use App\Models\Article\Article;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Direction extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'directions';

    protected $fillable = [
        'name'
    ];

    public $translatable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
