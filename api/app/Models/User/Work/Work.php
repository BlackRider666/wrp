<?php

namespace App\Models\User\Work;

use App\Models\Organization\StructuralUnit\StructuralUnit;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Work extends Model
{
    use  HasTranslations;

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

    public $translatable = [
        'position',
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
     * @return array
     */
    public function getTitleAttribute(): array
    {
        $unitNames = $this->unit->getTranslations('name');
        $orgNames =$this->unit->organization->getTranslations('name');
        $positions = $this->getTranslations('position');
        $titles = [];
        foreach ($positions as $tKey => $tValue) {
            $titles[$tKey] = $orgNames[$tKey].'-'.$unitNames[$tKey].'-'.$tValue;
        }

        return $titles;
    }
}
