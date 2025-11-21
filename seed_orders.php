<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Order;
use App\Models\User;

echo "=== SEED SAMPLE ORDERS ===\n\n";

// Hapus orders lama
echo "🗑️  Menghapus orders lama...\n";
Order::truncate();

// Get manager stock user
$manager = User::where('role', 'manager_stock')->first();

if (!$manager) {
    echo "❌ User manager stock tidak ditemukan!\n";
    exit(1);
}

// Sample orders data
$orders = [
    [
        'order_number' => 'ORD-2025-001',
        'vendor_name' => 'Sadikun',
        'product_name' => 'Gas LPG 12kg',
        'quantity' => 10,
        'total_price' => 2500000,
        'status' => 'completed',
        'estimated_delivery' => '2025-01-12',
    ],
    [
        'order_number' => 'ORD-2025-002',
        'vendor_name' => 'Kencana Emas',
        'product_name' => 'CO₂ Tank 25kg',
        'quantity' => 5,
        'total_price' => 1750000,
        'status' => 'in_progress',
        'estimated_delivery' => '2025-01-15',
    ],
    [
        'order_number' => 'ORD-2025-003',
        'vendor_name' => 'Kencana Emas',
        'product_name' => 'Translite Menu A3',
        'quantity' => 15,
        'total_price' => 3000000,
        'status' => 'confirmed',
        'estimated_delivery' => '2025-01-16',
    ],
    [
        'order_number' => 'ORD-2025-004',
        'vendor_name' => 'Akrilik Jaya',
        'product_name' => 'Akrilik Display Stand',
        'quantity' => 8,
        'total_price' => 1200000,
        'status' => 'pending',
        'estimated_delivery' => null,
    ],
    [
        'order_number' => 'ORD-2025-005',
        'vendor_name' => 'Sadikun',
        'product_name' => 'Gas LPG 12kg',
        'quantity' => 12,
        'total_price' => 3000000,
        'status' => 'completed',
        'estimated_delivery' => '2025-01-14',
    ],
];

echo "📦 Membuat " . count($orders) . " sample orders...\n\n";

foreach ($orders as $orderData) {
    $order = Order::create([
        'user_id' => $manager->id,
        'order_number' => $orderData['order_number'],
        'vendor_name' => $orderData['vendor_name'],
        'product_name' => $orderData['product_name'],
        'quantity' => $orderData['quantity'],
        'total_price' => $orderData['total_price'],
        'status' => $orderData['status'],
        'estimated_delivery' => $orderData['estimated_delivery'],
    ]);
    
    echo "✅ " . $order->order_number . " - " . $order->product_name . " (" . $order->getStatusLabel() . ")\n";
}

echo "\n=================================\n";
echo "✅ SELESAI!\n";
echo "Total orders: " . Order::count() . "\n";
echo "=================================\n";
