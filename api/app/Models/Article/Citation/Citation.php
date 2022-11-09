<?php

namespace App\Models\Article\Citation;

use App\Models\Article\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Citation extends Model
{
    protected $table = 'citations';

    protected $fillable = [
        'article_id',
        'citation_article_id',
        'url'
    ];

    /**
     * @return BelongsTo
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function citationArticle()
    {
        return $this->belongsTo(Article::class,'citation_article_id','id');
    }
}
