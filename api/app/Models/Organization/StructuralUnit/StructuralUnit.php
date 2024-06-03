<?php

namespace App\Models\Organization\StructuralUnit;

use App\Models\Organization\Organization;
use App\Models\User\Work\Work;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class StructuralUnit extends Model
{
    use HasTranslations;

    protected $table = 'structural_units';

    protected $fillable = [
        'name',
        'organization_id',
        'parent_id',
        'type',
        ];

    protected $appends = [
        'organization_title',
    ];

    public $translatable = [
        'name'
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
        return $this->organization?$this->organization->name:'';
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class,'parent_id');
    }

    /**
     * @return HasMany
     */
    public function child(): HasMany
    {
        return $this->hasMany(self::class,'parent_id')->with('child');
    }
}
