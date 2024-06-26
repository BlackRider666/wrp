<?php

namespace App\Models\Country;

use App\Models\Conference\Conference;
use App\Models\Country\City\City;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;

    protected $table = 'countries';

    protected $fillable = [
        'name',
    ];

    public $translatable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * @return HasMany
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    /**
     * @return HasManyThrough
     */
    public function conferences(): HasManyThrough
    {
        return $this->hasManyThrough(Conference::class,City::class);
    }
}
