<?php

namespace App\Models\Conference\ConferenceArticle;

use App\Models\Article\Article;
use App\Models\Conference\Conference;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ConferenceArticle extends Pivot
{
    protected $table = 'conference_articles';

    protected $fillable = [
        'conference_id',
        'article_id',
    ];

    /**
     * @return BelongsTo
     */
    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    /**
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
