<?php

namespace App\Models\Article;

use App\Models\Article\ArticleAuthor\ArticleAuthor;
use App\Models\Article\Category\Category;
use App\Models\Article\Citation\Citation;
use App\Models\Article\Direction\Direction;
use App\Models\Conference\Conference;
use App\Models\Conference\ConferenceArticle\ConferenceArticle;
use App\Models\Country\City\City;
use App\Models\Country\Country;
use App\Models\Tag\Tag;
use App\Models\User\User;
use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class Article extends Model
{
    use BelongsToThroughTrait, HasTranslations;

    protected $table = 'articles';

    protected $fillable = [
        'city_id',
        'title',
        'category_id',
        'year',
        'journal',
        'part',
        'number',
        'pages',
        'publisher',
        'patent_number',
        'app_number',
        'desc',
        'full_text',
        'file',
        'direction_id',
    ];

    protected $casts = [
        'year'  =>  'date:Y',
//        'file'  =>  'file',
    ];

    protected $appends = [
        'full_title',
        'citation_this_count',
        'file_path',
    ];

    public $translatable = [
        'title',
        'desc',
        'full_text',
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
     * @return BelongsToThrough
     */
    public function country(): BelongsToThrough
    {
        return $this->BelongsToThrough(Country::class,City::class);
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
     * @return array
     */
    public function getFullTitleAttribute(): array
    {
        $authors = $this->authors()->get(['first_name','second_name','surname'])->pluck('full_name');
        $titles = $this->getTranslations('title');
        $fullTitles = [];
        foreach ($titles as $tKey => $tValue) {
            $fullTitles[$tKey] = $tValue.' - ('.$authors->map(static function ($item) use($tKey){
                    return $item[$tKey];
                })->implode(' ').')';
        }
        return $fullTitles;
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

    /**
     * @return string
     */
    public function getFilePathAttribute(): string
    {
        return (new PathManager())->getFile($this->file,'articles_file');
    }

    /**
     * @return BelongsToMany
     */
    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class,'conference_articles')
            ->using(ConferenceArticle::class);
    }

    /**
     * @return BelongsTo
     */
    public function direction(): BelongsTo
    {
        return $this->belongsTo(Direction::class);
    }
}
