<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    const STATUS_PENDING = 'pending';

    const STATUS_CONFIRMED = 'confirmed';

    const STATUS_PROCESSING = 'processing';

    const STATUS_SHIPPED = 'shipped';

    const STATUS_DELIVERED = 'delivered';

    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_PENDING = 'pending';

    const PAYMENT_PENDING_VERIFICATION = 'pending_verification';

    const PAYMENT_CASH_ON_DELIVERY = 'cash_on_delivery';

    const PAYMENT_PAID = 'paid';

    const PAYMENT_FAILED = 'failed';

    const PAYMENT_REFUNDED = 'refunded';

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'sender_number',
        'shipping_address_id',
        'billing_address_id',
        'subtotal',
        'discount',
        'coupon_id',
        'coupon_code',
        'shipping_cost',
        'tax',
        'grand_total',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            $order->order_number = 'ORD-'.strtoupper(Str::random(10));
        });
    }
}
