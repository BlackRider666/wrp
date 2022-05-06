<?php

namespace App\Models\Organization;

use App\Models\Organization\StructuralUnit\StructuralUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $table = 'organization';

    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function units(): HasMany
    {
        return $this->hasMany(StructuralUnit::class);
    }
}
