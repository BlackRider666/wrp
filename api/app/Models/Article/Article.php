<?php

namespace App\Models\Article;

use App\Models\Article\Category\Category;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
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
        return $this->belongsToMany(User::class);
    }
}
