<?php

namespace App\Models\Locale\LocaleKey;

use App\Models\Locale\Key\Key;
use App\Models\Locale\Locale;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LocaleKey extends Pivot
{
    protected $table = 'locale_keys';

    protected $with = [
        'key',
        'locale',
    ];
    protected $fillable = [
        'key_id',
        'locale_id',
        'value',
    ];

    /**
     * @return BelongsTo
     */
    public function key(): BelongsTo
    {
        return $this->belongsTo(Key::class);
    }

    /**
     * @return BelongsTo
     */
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }
}
