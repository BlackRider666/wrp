<?php

namespace App\Models\User\Grant;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Grant extends Model
{
    use HasTranslations;

    protected $table = 'grants';

    protected $fillable = [
        'name',
        'user_id',
    ];

    public $translatable = [
        'name'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
