<?php

namespace App\Models;

use App\Traits\QueryFilterTrait;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;
    use QueryFilterTrait;

    protected $fillable = [
      'customer_id',
      'status',
      'amount',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
