<?php

namespace App\Models;

use Database\Factories\NotificationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    /** @use HasFactory<NotificationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'order_id',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->latest();
    }

    public static function createForUser(int $userId, string $type, string $title, ?string $message = null, ?int $orderId = null): self
    {
        return static::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'order_id' => $orderId,
        ]);
    }

    public static function createForAdmin(string $title, ?string $message = null, ?int $orderId = null): self
    {
        $adminUser = User::where('role', 'admin')->first();

        return static::create([
            'user_id' => $adminUser?->id ?? 1,
            'type' => 'admin',
            'title' => $title,
            'message' => $message,
            'order_id' => $orderId,
        ]);
    }

    public static function createForCustomer(int $userId, string $title, ?string $message = null, ?int $orderId = null): self
    {
        return static::create([
            'user_id' => $userId,
            'type' => 'customer',
            'title' => $title,
            'message' => $message,
            'order_id' => $orderId,
        ]);
    }
}
