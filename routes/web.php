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

    // Read filter params from querystring
    $q = request('q');
    $status = request('status');

    if ($user->role === 'manager_stock') {
        // Data for Manager Stock Dashboard
        $ordersQuery = Order::query();

        if ($q) {
            $ordersQuery->where(function($sub) use ($q) {
                $sub->where('order_number', 'like', "%{$q}%")
                    ->orWhere('product_name', 'like', "%{$q}%")
                    ->orWhere('vendor_name', 'like', "%{$q}%");
            });
        }

        if ($status) {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->latest()->get();

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
        ))->with(['q' => $q, 'status' => $status]);
    }


    if ($user->role === 'vendor') {
        // Data for Vendor Dashboard
        $ordersQuery = Order::where('vendor_id', $user->id);

        if ($q) {
            $ordersQuery->where(function($sub) use ($q) {
                $sub->where('order_number', 'like', "%{$q}%")
                    ->orWhere('product_name', 'like', "%{$q}%")
                    ->orWhere('user_id', 'like', "%{$q}%");
            });
        }

        if ($status) {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->latest()->get();
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
        ))->with(['q' => $q, 'status' => $status]);
    }

    if ($user->role === 'admin') {
        $pendingUsersCount = \App\Models\User::where('is_approved', false)->count();
        $unreadNotifications = $user->unreadNotifications;
        return view('dashboards.admin', compact('pendingUsersCount', 'unreadNotifications'));
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Order History Route for Manager Stock
Route::get('/riwayat-pesanan', function () {
    $user = Auth::user();
    
    if ($user->role !== 'manager_stock') {
        abort(403, 'Unauthorized');
    }
    
    // Get filter parameters
    $q = request('q');
    $status = request('status');
    $vendor = request('vendor');
    $dateFrom = request('date_from');
    $dateTo = request('date_to');
    
    // Build query
    $ordersQuery = Order::query();
    
    // Search filter
    if ($q) {
        $ordersQuery->where(function($sub) use ($q) {
            $sub->where('order_number', 'like', "%{$q}%")
                ->orWhere('product_name', 'like', "%{$q}%")
                ->orWhere('vendor_name', 'like', "%{$q}%");
        });
    }
    
    // Status filter
    if ($status) {
        $ordersQuery->where('status', $status);
    }
    
    // Vendor filter
    if ($vendor) {
        $ordersQuery->where('vendor_name', $vendor);
    }
    
    // Date range filter
    if ($dateFrom) {
        $ordersQuery->whereDate('created_at', '>=', $dateFrom);
    }
    if ($dateTo) {
        $ordersQuery->whereDate('created_at', '<=', $dateTo);
    }
    
    // Paginate results
    $orders = $ordersQuery->latest()->paginate(15)->withQueryString();
    
    // Get unique vendors for filter dropdown
    $vendors = Order::select('vendor_name')->distinct()->orderBy('vendor_name')->pluck('vendor_name');
    
    // Statistics
    $stats = [
        'total' => Order::count(),
        'completed' => Order::where('status', 'completed')->count(),
        'rejected' => Order::where('status', 'rejected')->count(),
        'total_spent' => Order::whereIn('status', ['completed', 'shipped'])->sum('total_price'),
    ];
    
    return view('dashboards.order-history', compact('orders', 'vendors', 'stats'));
})->middleware(['auth', 'verified'])->name('order.history');

// Product Catalog Route for Manager Stock
Route::get('/katalog', function () {
    $user = Auth::user();
    
    if ($user->role !== 'manager_stock') {
        abort(403, 'Unauthorized');
    }
    
    // Get filter parameters
    $q = request('q');
    $vendor = request('vendor');
    $minPrice = request('min_price');
    $maxPrice = request('max_price');
    $inStock = request('in_stock');
    
    // Build query
    $productsQuery = \App\Models\Product::with('vendor');
    
    // Search filter
    if ($q) {
        $productsQuery->where(function($sub) use ($q) {
            $sub->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        });
    }
    
    // Vendor filter
    if ($vendor) {
        $productsQuery->where('vendor_id', $vendor);
    }
    
    // Price range filter
    if ($minPrice) {
        $productsQuery->where('price', '>=', $minPrice);
    }
    if ($maxPrice) {
        $productsQuery->where('price', '<=', $maxPrice);
    }
    
    // In stock filter
    if ($inStock) {
        $productsQuery->where('stock', '>', 0);
    }
    
    // Paginate results
    $products = $productsQuery->latest()->paginate(12)->withQueryString();
    
    // Get all vendors for filter dropdown
    $vendors = \App\Models\User::where('role', 'vendor')
        ->where('is_approved', true)
        ->orderBy('store_name')
        ->get(['id', 'name', 'store_name']);
    
    // Statistics
    $stats = [
        'total_products' => \App\Models\Product::count(),
        'total_vendors' => \App\Models\User::where('role', 'vendor')->where('is_approved', true)->count(),
        'in_stock' => \App\Models\Product::where('stock', '>', 0)->count(),
        'out_of_stock' => \App\Models\Product::where('stock', '<=', 0)->count(),
    ];
    
    return view('dashboards.catalog', compact('products', 'vendors', 'stats'));
})->middleware(['auth', 'verified'])->name('catalog');

// Reports & Analytics Route for Manager Stock
Route::get('/laporan', function () {
    $user = Auth::user();
    
    if ($user->role !== 'manager_stock') {
        abort(403, 'Unauthorized');
    }
    
    // Get year filter (default current year)
    $year = request('year', date('Y'));
    $month = request('month');
    
    // Monthly spending data for chart
    $monthlySpending = [];
    for ($m = 1; $m <= 12; $m++) {
        $spending = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $m)
            ->whereIn('status', ['completed', 'shipped', 'confirmed'])
            ->sum('total_price');
        $monthlySpending[] = $spending;
    }
    
    // Monthly order count
    $monthlyOrders = [];
    for ($m = 1; $m <= 12; $m++) {
        $count = Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $m)
            ->count();
        $monthlyOrders[] = $count;
    }
    
    // Top products (most ordered)
    $topProducts = Order::select('product_name', \DB::raw('SUM(quantity) as total_qty'), \DB::raw('SUM(total_price) as total_spent'))
        ->whereYear('created_at', $year)
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->groupBy('product_name')
        ->orderByDesc('total_qty')
        ->limit(10)
        ->get();
    
    // Top vendors by spending
    $topVendors = Order::select('vendor_name', \DB::raw('COUNT(*) as total_orders'), \DB::raw('SUM(total_price) as total_spent'))
        ->whereYear('created_at', $year)
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->whereIn('status', ['completed', 'shipped', 'confirmed'])
        ->groupBy('vendor_name')
        ->orderByDesc('total_spent')
        ->limit(10)
        ->get();
    
    // Order status distribution
    $statusDistribution = Order::select('status', \DB::raw('COUNT(*) as count'))
        ->whereYear('created_at', $year)
        ->when($month, fn($q) => $q->whereMonth('created_at', $month))
        ->groupBy('status')
        ->get()
        ->pluck('count', 'status')
        ->toArray();
    
    // Overall statistics
    $stats = [
        'total_orders' => Order::whereYear('created_at', $year)->when($month, fn($q) => $q->whereMonth('created_at', $month))->count(),
        'total_spent' => Order::whereYear('created_at', $year)->when($month, fn($q) => $q->whereMonth('created_at', $month))->whereIn('status', ['completed', 'shipped', 'confirmed'])->sum('total_price'),
        'completed_orders' => Order::whereYear('created_at', $year)->when($month, fn($q) => $q->whereMonth('created_at', $month))->where('status', 'completed')->count(),
        'avg_order_value' => Order::whereYear('created_at', $year)->when($month, fn($q) => $q->whereMonth('created_at', $month))->whereIn('status', ['completed', 'shipped', 'confirmed'])->avg('total_price') ?? 0,
    ];
    
    // Available years for filter
    $availableYears = Order::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');
    
    if ($availableYears->isEmpty()) {
        $availableYears = collect([date('Y')]);
    }
    
    return view('dashboards.reports', compact(
        'monthlySpending', 
        'monthlyOrders', 
        'topProducts', 
        'topVendors', 
        'statusDistribution', 
        'stats', 
        'year', 
        'month',
        'availableYears'
    ));
})->middleware(['auth', 'verified'])->name('reports');


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

    // Download/preview invoice as PDF (opens inline in browser)
    Route::get('/orders/{id}/invoice/download', function ($id) {
        $order = Order::findOrFail($id);

        $data = ['order' => $order];

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.invoice_pdf', $data)->setPaper('a4', 'portrait');
            return $pdf->stream('invoice-' . ($order->order_number ?? $order->id) . '.pdf');
        }

        // Fallback: render HTML so browser can print/save as PDF
        return response()->view('orders.invoice_pdf', $data);
    })->name('orders.invoice.download');

    Route::get('/vendor/orders', [VendorOrderController::class, 'index'])->name('vendor.orders.index');
    Route::patch('/vendor/orders/{id}/status', [VendorOrderController::class, 'updateStatus'])->name('vendor.orders.updateStatus');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::get('/admin/approvals', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.approvals');
    Route::post('/admin/approvals/{id}', [\App\Http\Controllers\AdminController::class, 'approve'])->name('admin.approve');
    Route::delete('/admin/approvals/{id}', [\App\Http\Controllers\AdminController::class, 'reject'])->name('admin.reject');
    
    // Notification Routes
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\AdminController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/clear-all', [\App\Http\Controllers\AdminController::class, 'clearAll'])->name('notifications.clearAll');
});

require __DIR__.'/auth.php';
