<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'vendor_id',
        'vendor_name',
        'product_name',
        'quantity',
        'total_price',
        'tracking_number',
        'status',
        'estimated_delivery',
    ];

    public function vendor()
    {
        return $this->belongsTo(\App\Models\User::class, 'vendor_id');
    }

    protected $casts = [
        'estimated_delivery' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function getStatusBadgeColor(): string
    {
        switch ($this->status) {
            case 'completed':
                return 'bg-green-100 text-green-800';
            case 'shipped':
                return 'bg-indigo-100 text-indigo-800';
            case 'in_progress':
                return 'bg-purple-100 text-purple-800';
            case 'confirmed':
                return 'bg-blue-100 text-blue-800';
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            case 'rejected':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    public function getStatusLabel(): string
    {
        switch ($this->status) {
            case 'completed':
                return 'Selesai';
            case 'shipped':
                return 'Dikirim';
            case 'in_progress':
                return 'Sedang Diproses';
            case 'confirmed':
                return 'Dikonfirmasi';
            case 'pending':
                return 'Menunggu Konfirmasi';
            case 'rejected':
                return 'Ditolak';
            default:
                return ucfirst($this->status);
        }
    }
}
