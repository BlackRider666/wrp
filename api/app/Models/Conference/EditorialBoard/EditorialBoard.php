<?php

namespace App\Models\Conference\EditorialBoard;

use App\Models\Conference\Conference;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EditorialBoard extends Pivot
{
    protected $table = 'editorial_boards';

    protected $fillable = [
        'conference_id',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
