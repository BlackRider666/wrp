<?php

namespace App\Models\Article\Category;

use App\Models\Article\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'title',
        'tech_name',
    ];

    /**
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return Collection
     */
    public function forSelect(): Collection
    {
        return $this->newQuery()->pluck('title','id');
    }
}
