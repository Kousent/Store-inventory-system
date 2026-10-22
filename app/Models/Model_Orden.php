<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Model_Orden extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    protected $table = 'orders';

    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }

    protected $fillable = [
        'user_id', 'customer_name', 'email', 'phone', 'shipping_address',
        'payment_method', 'status', 'total', 'currency_code',
    ];

    protected function casts(): array
    {
        return ['total' => 'decimal:2'];
    }

    protected function currencySymbol(): Attribute
    {
        return Attribute::get(
            fn (): string => $this->currency_code === 'PEN' ? 'S/' : '$'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Model_OrdenItem::class, 'order_id');
    }
}
