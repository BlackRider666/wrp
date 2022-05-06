<?php

namespace App\Models\Country\City;

use App\Models\Country\Country;
use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'country_id',
        'name',
    ];

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return HasMany
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
