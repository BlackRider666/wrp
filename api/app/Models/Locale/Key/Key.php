<?php

namespace App\Models\Locale\Key;

use App\Models\Locale\Locale;
use App\Models\Locale\LocaleKey\LocaleKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Key extends Model
{
    protected $table = 'keys';

    protected $fillable = [
        'key',
        'description',
    ];

    /**
     * @return BelongsToMany
     */
    public function locales(): BelongsToMany
    {
        return $this->belongsToMany(Locale::class,'locale_keys')
            ->using(LocaleKey::class)
            ->withPivot('value');
    }

    /**
     * @return Collection
     */
    public function forSelect(): Collection
    {
        return $this->newQuery()->pluck('key','id');
    }
}
