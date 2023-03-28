<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_status_id',
        'payment_id',
        'uuid',
        'products',
        'address',
        'delivery_fee',
        'amount',
        'shipped_at',
    ];

    public function orderStatus() : BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment() : BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
