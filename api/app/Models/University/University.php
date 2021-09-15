<?php

namespace App\Models\University;

use App\Models\University\Faculty\Faculty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    protected $table = 'universities';

    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function faculties(): HasMany
    {
        return $this->hasMany(Faculty::class);
    }
}
