<?php

namespace App\Models\User;

use App\Models\Article\Article;
use App\Models\Article\ArticleAuthor\ArticleAuthor;
use App\Models\Conference\Conference;
use App\Models\Conference\EditorialBoard\EditorialBoard;
use App\Models\Conference\OrganizationalCommittee\OrganizationalCommittee;
use App\Models\Country\City\City;
use App\Models\Country\Country;
use App\Models\Organization\Organization;
use App\Models\User\Grant\Grant;
use App\Models\User\Premium\Premium;
use App\Models\User\Project\Project;
use App\Models\User\SocialLink\SocialLink;
use App\Models\User\Work\Work;
use BlackParadise\LaravelAdmin\Core\PathManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles, BelongsToThroughTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'second_name',
        'surname',
        'avatar',
        'email',
        'password',
        'phone',
        'desc',
        'verify',
        'degree',
        'position',
        'city_id',
        'organization_id',
    ];

    protected $appends = [
        'full_name',
        'avatar_url',
        'is_premium',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email'             => 'email',
        'password'          => 'password',
        'avatar'            => 'file'
    ];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->second_name.' '.$this->surname;
    }

    /**
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ?
            (new PathManager())->getFile($this->avatar, 'user_avatar')
            :
            (new PathManager())->getDefaultPicture();
    }

    /**
     * @return HasMany
     */
    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }

    /**
     * @return Collection
     */
    public function forSelect(): Collection
    {
        $collection = $this->newQuery()->get();
        return $collection->pluck('full_name', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'students', 'user_id', 'student_id');
    }

    /**
     * @return BelongsToMany
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'students', 'student_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function grants(): HasMany
    {
        return $this->hasMany(Grant::class);
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class)
            ->using(ArticleAuthor::class)
            ->withPivot(['approved']);
    }

    /**
     * @return HasMany
     */
    public function premiums(): HasMany
    {
        return $this->hasMany(Premium::class);
    }

    /**
     * @return string|false
     */
    public function getIsPremiumAttribute()
    {
        $now = Carbon::now()->format('Y-m-d');
        $prem = $this->premiums()
            ->where('start','<=',Carbon::now()->format('Y-m-d'))
            ->where('finish','>=',$now)
            ->get('finish');
        if ($prem->count() > 0) {
            return Carbon::parse($prem->first()->finish)->format('d-m-Y');
        }
        return false;
    }

    /**
     * @return HasMany
     */
    public function conferenceAuthor(): HasMany
    {
        return $this->hasMany(Conference::class);
    }

    /**
     * @return BelongsToMany
     */
    public function conferenceInOrgCommittee(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class,'organizational_committees')
                    ->using(OrganizationalCommittee::class);
    }

    /**
     * @return BelongsToMany
     */
    public function conferenceInEditors(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class,'editorial_boards')
                    ->using(EditorialBoard::class);
    }

    /**
     * @return HasMany
     */
    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
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
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
