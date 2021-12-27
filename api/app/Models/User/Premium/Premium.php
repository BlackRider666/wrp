<?php

namespace App\Models\User\Premium;

use App\Models\Order\Order;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Premium extends Model
{
    protected $table = 'premia';

    protected $fillable = [
        'user_id',
        'order_id',
        'start',
        'finish',
    ];

    protected $casts = [
        'start' => 'date',
        'finish' => 'date',
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
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
