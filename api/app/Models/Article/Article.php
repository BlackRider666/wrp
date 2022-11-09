<?php

namespace App\Models\Article;

use App\Models\Article\ArticleAuthor\ArticleAuthor;
use App\Models\Article\Category\Category;
use App\Models\Article\Citation\Citation;
use App\Models\Country\City\City;
use App\Models\Country\Country;
use App\Models\Tag\Tag;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'country_id',
        'city_id',
        'title',
        'category_id',
        'year',
        'journal',
        'part',
        'number',
        'pages',
        'publisher',
        'country',
        'patent_number',
        'app_number',
        'desc',
    ];

    protected $casts = [
        'year'  =>  'date:Y',
    ];

    protected $appends = [
        'full_title',
        'citation_this_count',
    ];

    public $createWithRel = [
        'authors_id' => [
            'required' => true,
            'type' => 'integer',
        ],
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(ArticleAuthor::class)
            ->withPivot(['approved']);
    }

    public function forSelect()
    {
        return $this->pluck('title','id');
    }

    /**
     * @return BelongsTo
     */
    public function countryCreate(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'tag_article');
    }

    /**
     * @return string
     */
    public function getFullTitleAttribute(): string
    {
        $authors = implode('', $this->authors()->get(['first_name','second_name','surname'])->pluck('full_name')->toArray());
        return $this->title.' - ('.$authors.')';
    }

    /**
     * @return HasMany
     */
    public function citationAny(): HasMany
    {
        return $this->hasMany(Citation::class,'article_id','id');
    }

    /**
     * @return HasMany
     */
    public function citationsThis(): HasMany
    {
        return $this->hasMany(Citation::class,'citation_article_id','id');
    }

    /**
     * @return int
     */
    public function getCitationThisCountAttribute(): int
    {
        return $this->citationsThis()->count();
    }
}
