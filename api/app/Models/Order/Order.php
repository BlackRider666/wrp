<?php

namespace App\Models\Order;

use App\Models\Transaction\Transaction;
use App\Models\User\Premium\Premium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'price',
        'transaction_id',
        'desc',
    ];

    /**
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * @return HasOne
     */
    public function premium(): HasOne
    {
        return $this->hasOne(Premium::class);
    }
}
