<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->role === 'manager_stock') {
        // Data for Manager Stock Dashboard
        $orders = Order::latest()->get();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $inProgressOrders = Order::whereIn('status', ['in_progress', 'shipped'])->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        return view('dashboards.manager-stock', compact(
            'orders', 
            'totalOrders', 
            'pendingOrders', 
            'inProgressOrders', 
            'completedOrders'
        ));
    } 
    
    
    if ($user->role === 'vendor') {
        // Data for Vendor Dashboard
        $orders = Order::where('vendor_id', $user->id)->latest()->get();
        $totalOrders = $orders->count();
        $newOrders = $orders->where('status', 'pending')->count();
        $inProgress = $orders->whereIn('status', ['confirmed', 'in_progress'])->count();
        $completed = $orders->whereIn('status', ['completed', 'shipped'])->count();
        $totalSales = $orders->whereIn('status', ['completed', 'shipped'])->sum('total_price');
        
        return view('dashboards.vendor', compact(
            'orders',
            'totalOrders',
            'newOrders',
            'inProgress',
            'completed',
            'totalSales'
        ));
    }

    if ($user->role === 'admin') {
        return view('dashboards.admin');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


use Illuminate\Http\Request;
use App\Events\OrderCreated;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorOrderController;

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('/vendors', function () {
        return \App\Models\User::where('role', 'vendor')->get(['id', 'name', 'store_name', 'phone', 'email']);
    });

    Route::get('/vendors/{id}/products', function ($id) {
        return \App\Models\Product::where('vendor_id', $id)->where('stock', '>', 0)->get();
    });

    Route::post('/orders', function (Request $request) {
        $validated = $request->validate([
            'vendor_name' => 'required',
            'product_name' => 'required',
            'quantity' => 'required|integer|min:1',
            'estimated_delivery' => 'required|date',
            'vendor_id' => 'nullable|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);
        
        if($product->stock < $request->quantity){
            return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi. Sisa stok: ' . $product->stock], 400);
        }

        $order = new Order();
        $order->order_number = 'ORD-' . time();
        $order->user_id = Auth::id();
        $order->vendor_id = $request->vendor_id; 
        $order->vendor_name = $request->vendor_name;
        $order->product_name = $request->product_name; // Keep name in case product is deleted/changed
        $order->quantity = $request->quantity;
        $order->total_price = $product->price * $request->quantity;
        $order->status = 'pending';
        $order->estimated_delivery = $request->estimated_delivery;
        $order->save();

        // Decrement stock
        $product->decrement('stock', $request->quantity);

        // Dispatch Event
        if ($order->vendor_id) {
            OrderCreated::dispatch($order);
            
            // Send Database Notification
            $vendor = \App\Models\User::find($order->vendor_id);
            if($vendor){
                $vendor->notify(new \App\Notifications\NewOrderNotification($order));
            }
        }

        return response()->json(['success' => true, 'order' => $order]);
    });
    
    Route::get('/orders/{id}/tracking', function ($id) {
        try {
            $order = Order::findOrFail($id);
            $vendor = \App\Models\User::find($order->vendor_id);
            
            // Build comprehensive timeline
            $timeline = [];
            $statusOrder = ['pending', 'confirmed', 'in_progress', 'shipped', 'completed'];
            $currentStatusIndex = array_search($order->status, $statusOrder);
            
            // If status is 'rejected', treat it specially
            if ($currentStatusIndex === false) {
                // For rejected orders, show only the first step and rejection
                $timeline[] = [
                    'status' => 'pending',
                    'title' => 'Pesanan Dibuat',
                    'date' => $order->created_at ? $order->created_at->format('d M Y, H:i') : '-',
                    'description' => 'Pesanan telah berhasil dibuat',
                    'active' => true
                ];
                
                $timeline[] = [
                    'status' => 'rejected',
                    'title' => 'Pesanan Ditolak',
                    'date' => $order->updated_at ? $order->updated_at->format('d M Y, H:i') : '-',
                    'description' => 'Pesanan ditolak oleh vendor',
                    'active' => true
                ];
            } else {
                // Pesanan Dibuat - always shown
                $timeline[] = [
                    'status' => 'pending',
                    'title' => 'Pesanan Dibuat',
                    'date' => $order->created_at ? $order->created_at->format('d M Y, H:i') : '-',
                    'description' => 'Pesanan telah berhasil dibuat dan menunggu konfirmasi vendor',
                    'active' => true
                ];
                
                // Dikonfirmasi Vendor
                $timeline[] = [
                    'status' => 'confirmed',
                    'title' => 'Dikonfirmasi Vendor',
                    'date' => ($currentStatusIndex >= 1 && $order->updated_at) ? $order->updated_at->format('d M Y, H:i') : '',
                    'description' => 'Vendor telah mengkonfirmasi pesanan Anda',
                    'active' => $currentStatusIndex >= 1
                ];
                
                // Sedang Diproses
                $timeline[] = [
                    'status' => 'in_progress',
                    'title' => 'Sedang Diproses',
                    'date' => ($currentStatusIndex >= 2 && $order->updated_at) ? $order->updated_at->format('d M Y, H:i') : '',
                    'description' => 'Pesanan sedang dikemas oleh vendor',
                    'active' => $currentStatusIndex >= 2
                ];
                
                // Dalam Pengiriman
                $timeline[] = [
                    'status' => 'shipped',
                    'title' => 'Dalam Pengiriman',
                    'date' => ($currentStatusIndex >= 3 && $order->updated_at) ? $order->updated_at->format('d M Y, H:i') : '',
                    'description' => 'Pesanan sedang dikirim ke lokasi',
                    'estimated' => ($order->estimated_delivery) ? $order->estimated_delivery->format('d M Y') : null,
                    'active' => $currentStatusIndex >= 3
                ];
                
                // Pesanan Selesai
                $timeline[] = [
                    'status' => 'completed',
                    'title' => 'Pesanan Selesai',
                    'date' => ($currentStatusIndex >= 4 && $order->updated_at) ? $order->updated_at->format('d M Y, H:i') : '',
                    'description' => $currentStatusIndex >= 4 ? 'Pesanan telah selesai' : 'Menunggu pesanan selesai',
                    'active' => $currentStatusIndex >= 4
                ];
            }
            
            return response()->json([
                'order' => $order,
                'vendor' => $vendor,
                'status_label' => $order->getStatusLabel(),
                'tracking_number' => $order->tracking_number ?? 'JKT3XXZ12345',
                'timeline' => $timeline
            ]);
        } catch (\Exception $e) {
            \Log::error('Tracking error: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Gagal memuat tracking: ' . $e->getMessage()
            ], 500);
        }
    });

    Route::post('/orders/{id}/confirm', function ($id) {
        $order = Order::findOrFail($id);
        $order->status = 'completed';
        $order->save();
        return response()->json(['success' => true]);
    });

    Route::get('/vendor/orders', [VendorOrderController::class, 'index'])->name('vendor.orders.index');
    Route::patch('/vendor/orders/{id}/status', [VendorOrderController::class, 'updateStatus'])->name('vendor.orders.updateStatus');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
