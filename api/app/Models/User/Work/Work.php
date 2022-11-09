<?php

namespace App\Models\User\Work;

use App\Models\Organization\StructuralUnit\StructuralUnit;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Work extends Model
{
    protected $table = 'works';

    protected $fillable = [
        'user_id',
        'start',
        'finish',
        'position',
        'structural_unit_id',
    ];

    protected $appends = [
        'title',
    ];

    protected $casts = [
        'start'  => 'date:Y-m-d',
        'finish' => 'date:Y-m-d',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(StructuralUnit::class,'structural_unit_id','id');
    }

    /**
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return $this->unit->organization->name.'-'.$this->unit->name.'-'.$this->position;
    }
}
