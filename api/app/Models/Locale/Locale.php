<?php

namespace App\Models\Locale;

use App\Models\Locale\Key\Key;
use App\Models\Locale\LocaleKey\LocaleKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Locale extends Model
{
    protected $table = 'locales';

    protected $fillable = [
        'name',
        'iso_code',
        'is_active',
    ];

    /**
     * @return BelongsToMany
     */
    public function keys(): BelongsToMany
    {
        return $this->belongsToMany(Key::class,'locale_keys')
            ->using(LocaleKey::class)
            ->withPivot('value');
    }

    /**
     * @return Collection
     */
    public function forSelect(): Collection
    {
        return $this->newQuery()->pluck('name','id');
    }
}
