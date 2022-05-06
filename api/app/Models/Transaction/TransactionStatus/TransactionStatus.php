<?php

namespace App\Models\Transaction\TransactionStatus;

use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionStatus extends Model
{
    protected $table = 'transaction_statuses';

    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class,'id','status_id');
    }
}
