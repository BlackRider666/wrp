<?php

namespace App\Models\Organization\StructuralUnit;

use App\Models\Organization\Organization;
use App\Models\User\Work\Work;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StructuralUnit extends Model
{
    protected $table = 'structural_units';

    protected $fillable = [
        'name',
        'organization_id',
        ];

    protected $appends = [
        'organization_title',
    ];
    /**
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * @return HasMany
     */
    public function works(): HasMany
    {
        return $this->hasMany(Work::class, 'structural_unit_id','structural_unit_id');
    }

    public function getOrganizationTitleAttribute()
    {
        return $this->organization->name;
    }
}
