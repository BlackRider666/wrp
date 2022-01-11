<?php

namespace App\Models\Conference;

use App\Models\Article\Article;
use App\Models\Conference\ConferenceArticle\ConferenceArticle;
use App\Models\Conference\ConferenceOrganizer\ConferenceOrganizer;
use App\Models\Conference\EditorialBoard\EditorialBoard;
use App\Models\Conference\OrganizationalCommittee\OrganizationalCommittee;
use App\Models\Country\City\City;
use App\Models\Country\Country;
use App\Models\Organizer\Organizer;
use App\Models\User\User;
use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Znck\Eloquent\Relations\BelongsToThrough as BelongsToThroughZnck;
use Znck\Eloquent\Traits\BelongsToThrough;

class Conference extends Model
{
    use BelongsToThrough;

    protected $table = 'conferences';

    protected $fillable = [
        'id',
        'title',
        'date',
        'city_id',
        'file',
        'user_id',
    ];

    protected $appends = [
        'file_url',
        'country_id',
    ];

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsToThroughZnck
     */
    public function country(): BelongsToThroughZnck
    {
        return $this->belongsToThrough(Country::class,City::class);
    }
    /**
     * @return BelongsToMany
     */
    public function organizers(): BelongsToMany
    {
        return $this->belongsToMany(Organizer::class,'conference_organizers')
            ->using(ConferenceOrganizer::class);
    }

    /**
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class,'conference_articles')
            ->using(ConferenceArticle::class);
    }

    /**
     * @return string|null
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ?
            (new PathManager())->getFile($this->file, 'conference_files')
            : null;
    }

    /**
     * @return int
     */
    public function getCountryIdAttribute(): int
    {
        return $this->country()->pluck('countries.id')->first();
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function editors(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'editorial_boards')
                    ->using(EditorialBoard::class);
    }

    /**
     * @return BelongsToMany
     */
    public function orgCommittee(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'organizational_committees')
            ->using(OrganizationalCommittee::class);
    }
}
