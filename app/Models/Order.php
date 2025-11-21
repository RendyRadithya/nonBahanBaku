<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'vendor_name',
        'product_name',
        'quantity',
        'total_price',
        'status',
        'estimated_delivery',
    ];

    protected $casts = [
        'estimated_delivery' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_REJECTED = 'rejected';

    // Status badge colors
    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            self::STATUS_COMPLETED => 'bg-green-100 text-green-800',
            self::STATUS_IN_PROGRESS => 'bg-purple-100 text-purple-800',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Status labels in Indonesian
    public function getStatusLabel(): string
    {
        return match($this->status) {
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_IN_PROGRESS => 'Sedang Diproses',
            self::STATUS_CONFIRMED => 'Dikonfirmasi',
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_REJECTED => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
}
