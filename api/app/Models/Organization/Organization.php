<?php

namespace App\Models\Organization;

use App\Models\Country\City\City;
use App\Models\Country\Country;
use App\Models\Organization\StructuralUnit\StructuralUnit;
use App\Models\User\User;
use BlackParadise\LaravelAdmin\Core\PathManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $table = 'organization';

    protected $fillable = [
        'name',
        'img',
        'country_id',
        'city_id',
        'rate',
        'verified',
        'user_id',
    ];

    protected $casts = [
        'img' => 'file',
    ];

    protected $appends = [
        'img_url'
    ];

    /**
     * @return HasMany
     */
    public function units(): HasMany
    {
        return $this->hasMany(StructuralUnit::class)->where('parent_id', null);
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getImgUrlAttribute(): string
    {
        return $this->img?
            (new PathManager())->getFile($this->img, 'organizations_img')
            :
            (new PathManager())->getDefaultPicture();
    }

    /**
     * @return BelongsToMany
     */
    public function editors(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'organization_user');
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'organization_staff');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
