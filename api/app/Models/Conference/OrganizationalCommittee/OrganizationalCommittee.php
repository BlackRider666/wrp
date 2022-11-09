<?php

namespace App\Models\Conference\OrganizationalCommittee;

use App\Models\Conference\Conference;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrganizationalCommittee extends Pivot
{
    protected $table = 'organizational_committees';

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
