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
        return view('dashboards.vendor');
    }

    if ($user->role === 'admin') {
        return view('dashboards.admin');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


use Illuminate\Http\Request;
use App\Events\OrderCreated;

use App\Http\Controllers\ProductController;

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
        }

        return response()->json(['success' => true, 'order' => $order]);
    });
    
    Route::get('/orders/{id}/tracking', function ($id) {
        $order = Order::findOrFail($id);
        $vendor = \App\Models\User::find($order->vendor_id);
        
        $timeline = [
            ['title' => 'Pesanan Dibuat', 'date' => $order->created_at->format('d M Y H:i'), 'icon' => '📝', 'description' => 'Pesanan berhasil dibuat'],
        ];
        
        if($order->status !== 'pending'){
             $timeline[] = ['title' => 'Pesanan Dikonfirmasi', 'date' => $order->updated_at->format('d M Y H:i'), 'icon' => '✅', 'description' => 'Vendor menerima pesanan'];
        }
        
        return response()->json([
            'order' => $order,
            'vendor' => $vendor,
            'status_label' => $order->getStatusLabel(),
            'timeline' => $timeline
        ]);
    });

    Route::post('/orders/{id}/confirm', function ($id) {
        $order = Order::findOrFail($id);
        $order->status = 'completed';
        $order->save();
        return response()->json(['success' => true]);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
