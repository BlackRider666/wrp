<?php

namespace App\Models\Transaction;

use App\Models\Transaction\TransactionStatus\TransactionStatus;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    const TYPE_DEPOSIT = 1;
    const TYPE_WITHDRAW = 2;

    protected $table = 'transactions';

    protected $with = [
        'status',
    ];

    protected $fillable = [
        'user_id',
        'amount',
        'status_id',
        'description',
        'type',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function status(): HasOne
    {
        return $this->hasOne(TransactionStatus::class,'id','status_id');
    }
}
