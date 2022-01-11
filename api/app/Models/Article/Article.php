<?php

namespace App\Models\Article;

use App\Models\Article\ArticleAuthor\ArticleAuthor;
use App\Models\Article\Category\Category;
use App\Models\Country\City\City;
use App\Models\Country\Country;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    ];

    protected $casts = [
        'year'  =>  'date:Y',
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
}
