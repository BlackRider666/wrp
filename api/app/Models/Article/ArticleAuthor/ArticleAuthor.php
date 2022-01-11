<?php

namespace App\Models\Article\ArticleAuthor;

use App\Models\Article\Article;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArticleAuthor extends Pivot
{
    protected $table = 'article_user';

    protected $fillable = [
        'article_id',
        'user_id',
        'approved',
    ];

    /**
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
