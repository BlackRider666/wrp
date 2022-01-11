<?php

namespace App\Models\Conference\ConferenceOrganizer;

use App\Models\Conference\Conference;
use App\Models\Organizer\Organizer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ConferenceOrganizer extends Pivot
{
    protected $table = 'conference_organizers';

    protected $fillable = [
        'conference_id',
        'organizer_id',
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
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }
}
